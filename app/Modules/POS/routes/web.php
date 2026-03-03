<?php

use App\Modules\POS\Controllers\DashboardController;
use App\Modules\POS\Controllers\BranchController;
use App\Modules\POS\Controllers\PageController;
use App\Modules\POS\Controllers\PosScreenController;
use App\Modules\POS\Controllers\ProductController;
use App\Modules\POS\Controllers\ReceiptController;
use App\Modules\POS\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');
Route::resource('products', ProductController::class)->middleware('permission:pos.products.read');
Route::get('/screen', [PosScreenController::class, 'index'])->name('screen')->middleware('permission:pos.sale.create');
Route::post('/checkout', [PosScreenController::class, 'checkout'])->name('checkout')->middleware('permission:pos.sale.create');
Route::get('/receipts/{sale}', [ReceiptController::class, 'show'])->name('receipts.show')->middleware('permission:pos.receipts.read');
Route::get('/reports', ReportController::class)->name('reports')->middleware('permission:pos.reports.read');
Route::get('/branches', [BranchController::class, 'index'])->name('branches.index')->middleware('permission:pos.products.read');
Route::get('/pages', [PageController::class, 'index'])->name('pages.index')->middleware('permission:pos.reports.read');
