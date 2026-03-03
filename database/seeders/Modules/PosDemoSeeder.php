<?php

namespace Database\Seeders\Modules;

use App\Models\Tenant;
use App\Modules\POS\Models\Category;
use App\Modules\POS\Models\Inventory;
use App\Modules\POS\Models\PosPayment;
use App\Modules\POS\Models\Product;
use App\Modules\POS\Models\Receipt;
use App\Modules\POS\Models\Sale;
use App\Modules\POS\Models\SaleItem;
use Illuminate\Database\Seeder;

class PosDemoSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::query()->where('slug', 'demo-campus')->first();

        if (! $tenant) {
            return;
        }

        $category = Category::query()->withoutGlobalScope('tenant')->firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Beverages']
        );

        $product = Product::query()->withoutGlobalScope('tenant')->firstOrCreate(
            ['tenant_id' => $tenant->id, 'sku' => 'P001'],
            ['category_id' => $category->id, 'name' => 'Soda 500ml', 'price' => 120, 'tax_rate' => 16, 'is_active' => true]
        );

        Inventory::query()->withoutGlobalScope('tenant')->firstOrCreate(
            ['tenant_id' => $tenant->id, 'product_id' => $product->id],
            ['quantity' => 80]
        );

        $sale = Sale::query()->withoutGlobalScope('tenant')->firstOrCreate(
            ['tenant_id' => $tenant->id, 'sale_no' => 'POS-DEMO-001'],
            [
                'subtotal' => 240,
                'discount_total' => 0,
                'tax_total' => 38.4,
                'total' => 278.4,
                'sold_at' => now(),
            ]
        );

        SaleItem::query()->firstOrCreate(
            ['sale_id' => $sale->id, 'product_id' => $product->id],
            ['quantity' => 2, 'unit_price' => 120, 'discount' => 0, 'tax' => 38.4, 'line_total' => 278.4]
        );

        PosPayment::query()->withoutGlobalScope('tenant')->firstOrCreate(
            ['tenant_id' => $tenant->id, 'sale_id' => $sale->id, 'amount' => 278.4],
            ['method' => 'cash', 'paid_at' => now()]
        );

        Receipt::query()->withoutGlobalScope('tenant')->firstOrCreate(
            ['tenant_id' => $tenant->id, 'sale_id' => $sale->id],
            ['receipt_no' => 'RCPT-DEMO-001']
        );
    }
}
