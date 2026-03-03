<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Module;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;

class BillingService
{
    public function createOrUpdateSubscription(Tenant $tenant, array $moduleSlugs, ?int $planId = null, bool $startTrial = true, int $trialDays = 14): Subscription
    {
        return DB::transaction(function () use ($tenant, $moduleSlugs, $planId, $startTrial, $trialDays): Subscription {
            $subscription = $tenant->subscriptions()->create([
                'plan_id' => $planId,
                'status' => $startTrial ? Subscription::STATUS_TRIALING : Subscription::STATUS_ACTIVE,
                'starts_at' => now()->toDateString(),
                'trial_ends_at' => $startTrial ? now()->addDays($trialDays)->toDateString() : null,
                'next_billing_at' => now()->addMonth(),
            ]);

            $modules = Module::query()->whereIn('slug', $moduleSlugs)->get();
            $syncData = [];

            foreach ($modules as $module) {
                $syncData[$module->id] = ['price' => $module->base_price];
            }

            $subscription->modules()->sync($syncData);

            return $subscription->load('modules');
        });
    }

    public function generateInvoiceForSubscription(Subscription $subscription): Invoice
    {
        return DB::transaction(function () use ($subscription): Invoice {
            $subscription->loadMissing('modules', 'tenant');

            $invoice = Invoice::query()->create([
                'tenant_id' => $subscription->tenant_id,
                'subscription_id' => $subscription->id,
                'invoice_no' => sprintf('TIWI-%s-%04d', now()->format('Ym'), random_int(1, 9999)),
                'status' => 'issued',
                'issue_date' => now()->toDateString(),
                'due_date' => now()->addDays(7)->toDateString(),
                'currency' => $subscription->tenant->currency,
            ]);

            $subtotal = 0;

            foreach ($subscription->modules as $module) {
                $lineTotal = (float) ($module->pivot->price ?? $module->base_price);
                $subtotal += $lineTotal;

                $invoice->items()->create([
                    'module_id' => $module->id,
                    'description' => $module->name.' monthly subscription',
                    'quantity' => 1,
                    'unit_price' => $lineTotal,
                    'line_total' => $lineTotal,
                ]);
            }

            $invoice->update([
                'subtotal' => $subtotal,
                'tax_total' => 0,
                'total' => $subtotal,
                'amount_paid' => 0,
                'balance_due' => $subtotal,
            ]);

            return $invoice->refresh()->load('items', 'tenant');
        });
    }

    public function recordPayment(Invoice $invoice, float $amount, string $method = 'manual', ?string $reference = null): Payment
    {
        return DB::transaction(function () use ($invoice, $amount, $method, $reference): Payment {
            $payment = Payment::query()->create([
                'tenant_id' => $invoice->tenant_id,
                'invoice_id' => $invoice->id,
                'amount' => $amount,
                'currency' => $invoice->currency,
                'method' => $method,
                'reference' => $reference,
                'status' => 'completed',
                'paid_at' => now(),
            ]);

            $paid = (float) $invoice->payments()->sum('amount');
            $balance = max((float) $invoice->total - $paid, 0);

            $invoice->update([
                'amount_paid' => $paid,
                'balance_due' => $balance,
                'status' => $balance <= 0 ? 'paid' : 'partial',
            ]);

            if ($invoice->subscription && $invoice->subscription->status === Subscription::STATUS_PAST_DUE && $balance <= 0) {
                $invoice->subscription->update(['status' => Subscription::STATUS_ACTIVE]);
            }

            return $payment;
        });
    }
}
