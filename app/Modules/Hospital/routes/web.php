<?php

use App\Modules\Hospital\Controllers\AppointmentController;
use App\Modules\Hospital\Controllers\BillController;
use App\Modules\Hospital\Controllers\DashboardController;
use App\Modules\Hospital\Controllers\PatientController;
use App\Modules\Hospital\Controllers\PaymentController;
use App\Modules\Hospital\Controllers\ReportController;
use App\Modules\Hospital\Controllers\VisitController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');
Route::get('/reports', ReportController::class)->name('reports')->middleware('permission:hospital.reports.read');
Route::resource('patients', PatientController::class)->middleware('permission:hospital.patients.read');
Route::resource('appointments', AppointmentController::class)->except(['destroy'])->middleware('permission:hospital.appointments.read');
Route::resource('visits', VisitController::class)->only(['index', 'create', 'store', 'show'])->middleware('permission:hospital.visits.read');
Route::resource('bills', BillController::class)->only(['index', 'create', 'store', 'show'])->middleware('permission:hospital.bills.read');
Route::post('bills/{bill}/payments', [PaymentController::class, 'store'])
    ->name('bills.payments.store')
    ->middleware('permission:hospital.bills.pay');
