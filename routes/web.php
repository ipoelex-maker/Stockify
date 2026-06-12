<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockOpnameController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware(['role:admin'])->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('users', UserController::class);
    });

    Route::middleware(['role:admin|manager'])->group(function () {
        Route::resource('products', ProductController::class);
        Route::get('products-import', [ProductController::class, 'importForm'])->name('products.import.form');
        Route::post('products-import', [ProductController::class, 'importCsv'])->name('products.import');
        Route::get('products-template', [ProductController::class, 'downloadTemplate'])->name('products.template');

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export', [ReportController::class, 'exportCsv'])->name('reports.export');

        Route::resource('stock-opnames', StockOpnameController::class)->except(['edit','update']);
    });

    Route::middleware(['role:admin|manager|staff'])->group(function () {
        Route::resource('stock-ins', StockInController::class);
        Route::resource('stock-outs', StockOutController::class);
    });

});

require __DIR__.'/auth.php';