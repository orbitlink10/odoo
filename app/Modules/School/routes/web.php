<?php

use App\Modules\School\Controllers\ClassController;
use App\Modules\School\Controllers\DashboardController;
use App\Modules\School\Controllers\FeeInvoiceController;
use App\Modules\School\Controllers\PaymentController;
use App\Modules\School\Controllers\ReportController;
use App\Modules\School\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');
Route::get('/reports', ReportController::class)->name('reports')->middleware('permission:school.reports.read');
Route::resource('students', StudentController::class)->middleware('permission:school.students.read');
Route::resource('classes', ClassController::class)->middleware('permission:school.classes.read');
Route::resource('fee-invoices', FeeInvoiceController::class)->only(['index', 'create', 'store', 'show'])->middleware('permission:school.fees.read');
Route::post('fee-invoices/{feeInvoice}/payments', [PaymentController::class, 'store'])
    ->name('fee-invoices.payments.store')
    ->middleware('permission:school.fees.pay');
