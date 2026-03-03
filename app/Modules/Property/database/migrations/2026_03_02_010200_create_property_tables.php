<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->string('name');
            $table->string('type')->nullable();
            $table->string('location')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('property_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('property_id')->constrained('property_properties')->cascadeOnDelete();
            $table->string('unit_no');
            $table->decimal('rent_amount', 12, 2);
            $table->string('status')->default('vacant');
            $table->timestamps();
            $table->unique(['property_id', 'unit_no']);
        });

        Schema::create('property_tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('id_number')->nullable();
            $table->timestamps();
        });

        Schema::create('property_leases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('unit_id')->constrained('property_units')->cascadeOnDelete();
            $table->foreignId('rental_tenant_id')->constrained('property_tenants')->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('rent_amount', 12, 2);
            $table->decimal('deposit_amount', 12, 2)->default(0);
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('property_rent_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('lease_id')->constrained('property_leases')->cascadeOnDelete();
            $table->string('invoice_no');
            $table->date('issue_date');
            $table->date('due_date');
            $table->decimal('amount', 12, 2);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->decimal('balance', 12, 2)->default(0);
            $table->string('status')->default('unpaid');
            $table->timestamps();
            $table->unique(['tenant_id', 'invoice_no']);
        });

        Schema::create('property_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('rent_invoice_id')->constrained('property_rent_invoices')->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('method')->default('cash');
            $table->string('reference')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        Schema::create('property_maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('property_units')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status')->default('open');
            $table->string('priority')->default('normal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_maintenance_requests');
        Schema::dropIfExists('property_payments');
        Schema::dropIfExists('property_rent_invoices');
        Schema::dropIfExists('property_leases');
        Schema::dropIfExists('property_tenants');
        Schema::dropIfExists('property_units');
        Schema::dropIfExists('property_properties');
    }
};
