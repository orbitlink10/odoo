<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_guardians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('relationship')->nullable();
            $table->timestamps();
        });

        Schema::create('school_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->string('name');
            $table->string('section')->nullable();
            $table->string('academic_year')->nullable();
            $table->timestamps();
        });

        Schema::create('school_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('guardian_id')->nullable()->constrained('school_guardians')->nullOnDelete();
            $table->string('admission_no');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['tenant_id', 'admission_no']);
        });

        Schema::create('school_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('school_students')->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('school_classes')->cascadeOnDelete();
            $table->date('enrolled_on');
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('school_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('class_id')->nullable()->constrained('school_classes')->nullOnDelete();
            $table->string('name');
            $table->string('term')->nullable();
            $table->decimal('amount', 12, 2);
            $table->date('due_date')->nullable();
            $table->timestamps();
        });

        Schema::create('school_fee_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('school_students')->cascadeOnDelete();
            $table->foreignId('fee_id')->nullable()->constrained('school_fees')->nullOnDelete();
            $table->string('invoice_no');
            $table->date('issue_date');
            $table->date('due_date')->nullable();
            $table->decimal('amount', 12, 2);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->decimal('balance', 12, 2)->default(0);
            $table->string('status')->default('unpaid');
            $table->timestamps();
            $table->unique(['tenant_id', 'invoice_no']);
        });

        Schema::create('school_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('fee_invoice_id')->constrained('school_fee_invoices')->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('method')->default('cash');
            $table->string('reference')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_payments');
        Schema::dropIfExists('school_fee_invoices');
        Schema::dropIfExists('school_fees');
        Schema::dropIfExists('school_enrollments');
        Schema::dropIfExists('school_students');
        Schema::dropIfExists('school_classes');
        Schema::dropIfExists('school_guardians');
    }
};
