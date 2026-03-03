<?php

use App\Modules\Property\Controllers\DashboardController;
use App\Modules\Property\Controllers\LeaseController;
use App\Modules\Property\Controllers\MaintenanceRequestController;
use App\Modules\Property\Controllers\PropertyController;
use App\Modules\Property\Controllers\RentInvoiceController;
use App\Modules\Property\Controllers\ReportController;
use App\Modules\Property\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');
Route::get('/reports', ReportController::class)->name('reports')->middleware('permission:property.reports.read');
Route::resource('properties', PropertyController::class)->middleware('permission:property.properties.read');
Route::resource('units', UnitController::class)->except(['destroy'])->middleware('permission:property.units.read');
Route::resource('leases', LeaseController::class)->only(['index', 'create', 'store', 'show'])->middleware('permission:property.leases.read');
Route::resource('rent-invoices', RentInvoiceController::class)->only(['index', 'create', 'store', 'show'])->middleware('permission:property.rent.read');
Route::post('rent-invoices/{rentInvoice}/pay', [RentInvoiceController::class, 'pay'])->name('rent-invoices.pay')->middleware('permission:property.rent.collect');
Route::resource('maintenance', MaintenanceRequestController::class)->only(['index', 'create', 'store', 'show', 'update'])->middleware('permission:property.maintenance.read');
