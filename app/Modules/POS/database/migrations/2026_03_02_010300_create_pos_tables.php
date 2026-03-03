<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pos_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('pos_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('pos_categories')->nullOnDelete();
            $table->string('sku');
            $table->string('name');
            $table->decimal('price', 12, 2);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['tenant_id', 'sku']);
        });

        Schema::create('pos_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('pos_products')->cascadeOnDelete();
            $table->decimal('quantity', 12, 2)->default(0);
            $table->timestamps();
            $table->unique(['tenant_id', 'product_id']);
        });

        Schema::create('pos_customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });

        Schema::create('pos_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('pos_customers')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('sale_no');
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('discount_total', 12, 2)->default(0);
            $table->decimal('tax_total', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->timestamp('sold_at');
            $table->timestamps();
            $table->unique(['tenant_id', 'sale_no']);
        });

        Schema::create('pos_sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('pos_sales')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('pos_products')->cascadeOnDelete();
            $table->decimal('quantity', 12, 2)->default(1);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('line_total', 12, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('pos_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('sale_id')->constrained('pos_sales')->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('method')->default('cash');
            $table->string('reference')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        Schema::create('pos_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('sale_id')->constrained('pos_sales')->cascadeOnDelete();
            $table->string('receipt_no');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['tenant_id', 'receipt_no']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos_receipts');
        Schema::dropIfExists('pos_payments');
        Schema::dropIfExists('pos_sale_items');
        Schema::dropIfExists('pos_sales');
        Schema::dropIfExists('pos_customers');
        Schema::dropIfExists('pos_inventories');
        Schema::dropIfExists('pos_products');
        Schema::dropIfExists('pos_categories');
    }
};
