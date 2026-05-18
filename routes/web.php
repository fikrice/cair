<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::redirect('/signin', '/login');
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StockAdjustmentController;

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'lockout'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Katalog (Admin & Warehouse)
    Route::middleware('role:admin,warehouse')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::get('stock-movements', [\App\Http\Controllers\StockMovementController::class, 'index'])->name('stock-movements.index');
    });

    // Penyesuaian Stok (Admin Only)
    Route::middleware('role:admin')->group(function () {
        Route::resource('stock-adjustments', StockAdjustmentController::class);
    });

    // Operasional Pembelian (Create, Edit, Cancel, Print) - Purchasing
    Route::middleware('role:purchasing')->group(function () {
        Route::resource('suppliers', SupplierController::class);
        Route::patch('suppliers/{supplier}/toggle-status', [SupplierController::class, 'toggleStatus'])->name('suppliers.toggle-status');

        Route::resource('purchase-orders', PurchaseOrderController::class)->except(['index', 'show']);
        Route::post('purchase-orders/{purchase_order}/cancel', [PurchaseOrderController::class, 'cancel'])->name('purchase-orders.cancel');
        Route::get('purchase-orders/{purchase_order}/print', [PurchaseOrderController::class, 'print'])->name('purchase-orders.print');
    });

    // Pembelian Dasar (Daftar & Detail) - Bisa diakses Purchasing, Warehouse, Finance
    Route::middleware('role:purchasing,warehouse,finance')->group(function () {
        Route::get('purchase-orders', [PurchaseOrderController::class, 'index'])->name('purchase-orders.index');
        Route::get('purchase-orders/{purchase_order}', [PurchaseOrderController::class, 'show'])->name('purchase-orders.show');
    });

    // Penerimaan Barang (Warehouse)
    Route::middleware(['role:warehouse', 'lockout'])->group(function () {
        Route::post('purchase-orders/{purchase_order}/receive', [PurchaseOrderController::class, 'receive'])->name('purchase-orders.receive');
    });

    // Penjualan (Admin Only: Create, Store, Delete)
    Route::middleware('role:admin')->group(function () {
        Route::get('sales-orders/create', [SalesOrderController::class, 'create'])->name('sales-orders.create');
        Route::post('sales-orders', [SalesOrderController::class, 'store'])->name('sales-orders.store');
        Route::delete('sales-orders/{salesOrder}', [SalesOrderController::class, 'destroy'])->name('sales-orders.destroy');
    });

    // Penjualan (Finance & Admin: Edit, Update, Cancel)
    Route::middleware('role:admin,finance')->group(function () {
        Route::get('sales-orders/{salesOrder}/edit', [SalesOrderController::class, 'edit'])->name('sales-orders.edit');
        Route::match(['put', 'patch'], 'sales-orders/{salesOrder}', [SalesOrderController::class, 'update'])->name('sales-orders.update');
        Route::post('sales-orders/{salesOrder}/cancel', [SalesOrderController::class, 'cancel'])->name('sales-orders.cancel');
    });

    // Validasi Pengiriman SO & PO Payment (Warehouse, Finance, Admin)
    Route::middleware(['role:admin,finance,warehouse', 'lockout'])->group(function () {
        Route::get('sales-orders', [SalesOrderController::class, 'index'])->name('sales-orders.index');
        Route::get('sales-orders/{salesOrder}', [SalesOrderController::class, 'show'])->name('sales-orders.show');
        Route::post('sales-orders/{salesOrder}/complete', [SalesOrderController::class, 'complete'])->name('sales-orders.complete');
        Route::get('sales-orders/{salesOrder}/print', [SalesOrderController::class, 'print'])->name('sales-orders.print');
        Route::get('sales-orders/{salesOrder}/shipping-label', [SalesOrderController::class, 'shippingLabel'])->name('sales-orders.shipping-label');
        Route::get('sales-orders/{salesOrder}/payment', [SalesOrderController::class, 'payment'])->name('sales-orders.payment');
    });

    Route::middleware(['role:finance,warehouse', 'lockout'])->group(function () {
        // PO Payment Route
        Route::get('purchase-orders/{purchase_order}/payment', [PurchaseOrderController::class, 'payment'])->name('purchase-orders.payment');
    });

    // Keuangan & Pelaporan (Finance)
    Route::middleware(['role:finance', 'lockout'])->group(function () {
        Route::resource('transactions', \App\Http\Controllers\TransactionController::class);
        Route::get('reports/sales', [\App\Http\Controllers\ReportController::class, 'sales'])->name('reports.sales');
    });

    // Specific Report Access
    Route::get('reports/purchases', [\App\Http\Controllers\ReportController::class, 'purchases'])
        ->middleware('role:finance,purchasing')
        ->name('reports.purchases');

    Route::get('reports/inventory', [\App\Http\Controllers\ReportController::class, 'inventory'])
        ->middleware(['role:finance,warehouse', 'lockout'])
        ->name('reports.inventory');
    // Manajemen User (Admin Only)
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', \App\Http\Controllers\UserController::class);
    });
});

require __DIR__ . '/auth.php';
