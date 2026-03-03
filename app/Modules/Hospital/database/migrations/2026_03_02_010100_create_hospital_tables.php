<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hospital_departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->nullable();
            $table->timestamps();
        });

        Schema::create('hospital_doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('hospital_departments')->nullOnDelete();
            $table->string('name');
            $table->string('specialization')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });

        Schema::create('hospital_patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->string('patient_no');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['tenant_id', 'patient_no']);
        });

        Schema::create('hospital_appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained('hospital_patients')->cascadeOnDelete();
            $table->foreignId('doctor_id')->nullable()->constrained('hospital_doctors')->nullOnDelete();
            $table->timestamp('appointment_at');
            $table->string('status')->default('scheduled');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('hospital_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained('hospital_patients')->cascadeOnDelete();
            $table->foreignId('appointment_id')->nullable()->constrained('hospital_appointments')->nullOnDelete();
            $table->timestamp('visited_at');
            $table->text('diagnosis')->nullable();
            $table->text('treatment')->nullable();
            $table->timestamps();
        });

        Schema::create('hospital_bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained('hospital_patients')->cascadeOnDelete();
            $table->string('bill_no');
            $table->date('issue_date');
            $table->decimal('total', 12, 2)->default(0);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->decimal('balance', 12, 2)->default(0);
            $table->string('status')->default('unpaid');
            $table->timestamps();
            $table->unique(['tenant_id', 'bill_no']);
        });

        Schema::create('hospital_bill_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id')->constrained('hospital_bills')->cascadeOnDelete();
            $table->string('description');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 12, 2)->default(0);
            $table->decimal('line_total', 12, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('hospital_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('bill_id')->constrained('hospital_bills')->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('method')->default('cash');
            $table->string('reference')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hospital_payments');
        Schema::dropIfExists('hospital_bill_items');
        Schema::dropIfExists('hospital_bills');
        Schema::dropIfExists('hospital_visits');
        Schema::dropIfExists('hospital_appointments');
        Schema::dropIfExists('hospital_patients');
        Schema::dropIfExists('hospital_doctors');
        Schema::dropIfExists('hospital_departments');
    }
};
