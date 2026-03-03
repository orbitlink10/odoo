<?php

namespace App\Modules\POS\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\POS\Models\Customer;
use App\Modules\POS\Models\Inventory;
use App\Modules\POS\Models\PosPayment;
use App\Modules\POS\Models\Product;
use App\Modules\POS\Models\Receipt;
use App\Modules\POS\Models\Sale;
use App\Modules\POS\Models\SaleItem;
use App\Modules\POS\Requests\CheckoutRequest;
use App\Services\AuditLogService;
use Illuminate\Support\Facades\DB;

class PosScreenController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function index()
    {
        $products = Product::query()->with('inventory')->where('is_active', true)->orderBy('name')->get();

        return view('modules.pos.screen', compact('products'));
    }

    public function checkout(CheckoutRequest $request)
    {
        $validated = $request->validated();
        $items = collect($validated['items'])
            ->filter(fn ($item) => ! empty($item['product_id']) && ! empty($item['quantity']))
            ->values()
            ->all();

        if (count($items) === 0) {
            return redirect()->back()->withErrors(['items' => 'Add at least one cart item with product and quantity.']);
        }

        $sale = DB::transaction(function () use ($request, $items, $validated): Sale {
            $customer = null;

            if ($request->filled('customer_name')) {
                $customer = Customer::query()->create([
                    'name' => $request->input('customer_name'),
                    'phone' => $request->input('customer_phone'),
                ]);
            }

            $subtotal = 0;
            $taxTotal = 0;
            $discountTotal = (float) $request->input('discount_total', 0);

            $sale = Sale::query()->create([
                'customer_id' => $customer?->id,
                'user_id' => $request->user()->id,
                'sale_no' => sprintf('POS-%s-%04d', now()->format('Ymd'), random_int(1, 9999)),
                'sold_at' => now(),
            ]);

            foreach ($items as $item) {
                $product = Product::query()->with('inventory')->findOrFail((int) $item['product_id']);
                $qty = (float) $item['quantity'];

                $lineSubtotal = $qty * (float) $product->price;
                $lineTax = $lineSubtotal * (((float) $product->tax_rate) / 100);
                $lineTotal = $lineSubtotal + $lineTax;

                $subtotal += $lineSubtotal;
                $taxTotal += $lineTax;

                SaleItem::query()->create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_price' => $product->price,
                    'discount' => 0,
                    'tax' => $lineTax,
                    'line_total' => $lineTotal,
                ]);

                $inventory = $product->inventory;
                if ($inventory) {
                    $inventory->update(['quantity' => max((float) $inventory->quantity - $qty, 0)]);
                } else {
                    Inventory::query()->create(['product_id' => $product->id, 'quantity' => 0]);
                }
            }

            $total = max($subtotal + $taxTotal - $discountTotal, 0);

            $sale->update([
                'subtotal' => $subtotal,
                'discount_total' => $discountTotal,
                'tax_total' => $taxTotal,
                'total' => $total,
            ]);

            PosPayment::query()->create([
                'sale_id' => $sale->id,
                'amount' => $validated['paid_amount'],
                'method' => $validated['payment_method'] ?? 'cash',
                'paid_at' => now(),
            ]);

            Receipt::query()->create([
                'sale_id' => $sale->id,
                'receipt_no' => sprintf('RCPT-%s-%04d', now()->format('Ymd'), random_int(1, 9999)),
            ]);

            return $sale;
        });

        $this->auditLogService->log('pos.sale.created', Sale::class, $sale->id);

        return redirect()->route('pos.receipts.show', $sale)->with('success', 'Sale completed.');
    }
}
