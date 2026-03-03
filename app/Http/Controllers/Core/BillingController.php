<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\RecordInvoicePaymentRequest;
use App\Http\Requests\Core\UpdateSubscriptionRequest;
use App\Models\Invoice;
use App\Models\Plan;
use App\Models\Subscription;
use App\Services\AuditLogService;
use App\Services\BillingService;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function __construct(
        private readonly BillingService $billingService,
        private readonly SubscriptionService $subscriptionService,
        private readonly AuditLogService $auditLogService,
    ) {
    }

    public function index(Request $request)
    {
        $tenant = $request->user()->tenant;
        $subscription = $tenant ? $this->subscriptionService->currentForTenant($tenant) : null;
        $plans = Plan::query()->with('modules')->where('is_active', true)->get();
        $invoices = Invoice::query()
            ->when($tenant, fn ($query) => $query->where('tenant_id', $tenant->id))
            ->latest()
            ->paginate(10);

        return view('billing.index', compact('tenant', 'subscription', 'plans', 'invoices'));
    }

    public function subscribe(UpdateSubscriptionRequest $request)
    {
        $tenant = $request->user()->tenant;

        if (! $tenant) {
            return redirect()->route('onboarding.create');
        }

        $subscription = $this->billingService->createOrUpdateSubscription(
            tenant: $tenant,
            moduleSlugs: $request->validated('modules'),
            planId: $request->validated('plan_id'),
            startTrial: (bool) $request->boolean('start_trial', true),
            trialDays: (int) $request->integer('trial_days', 14),
        );

        $invoice = $this->billingService->generateInvoiceForSubscription($subscription);

        $this->auditLogService->log('subscription.updated', Subscription::class, $subscription->id, [
            'modules' => $request->validated('modules'),
            'invoice_id' => $invoice->id,
        ]);

        return redirect()->route('billing.index')->with('success', 'Subscription updated successfully.');
    }

    public function payInvoice(RecordInvoicePaymentRequest $request)
    {
        $tenant = $request->user()->tenant;

        $invoice = Invoice::query()
            ->where('tenant_id', $tenant?->id)
            ->findOrFail($request->integer('invoice_id'));

        $payment = $this->billingService->recordPayment(
            invoice: $invoice,
            amount: (float) $request->input('amount'),
            method: (string) $request->input('method', 'manual'),
            reference: $request->input('reference'),
        );

        $this->auditLogService->log('invoice.payment_recorded', Invoice::class, $invoice->id, [
            'payment_id' => $payment->id,
            'amount' => $payment->amount,
        ]);

        return redirect()->route('billing.index')->with('success', 'Payment recorded.');
    }
}
