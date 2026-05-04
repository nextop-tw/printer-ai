<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PrinterController as AdminPrinterController;
use App\Http\Controllers\Admin\SpecController;
use App\Http\Controllers\Api\OrderController as ApiOrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\Printer\PrinterAuthController;
use App\Http\Controllers\Printer\PrinterOrderController;
use App\Http\Middleware\AuthAdmin;
use App\Http\Middleware\AuthPrinter;
use Illuminate\Support\Facades\Route;

// 前台
Route::get('/', fn () => view('welcome'))->name('home');
Route::get('/order', fn () => view('order.create'))->name('order.create');
Route::get('/orders/{orderNo}', [ApiOrderController::class, 'show'])->name('orders.show');

// 前台 API
Route::prefix('api')->name('api.')->group(function () {
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/{id}/specs', [ProductController::class, 'specs'])->name('products.specs');
    Route::post('quote', [ProductController::class, 'quote'])->name('quote');
    Route::post('upload', [UploadController::class, 'store'])->name('upload');
    Route::post('orders', [ApiOrderController::class, 'store'])->name('orders.store');
});

// 藍新金流回調
Route::post('payment/notify', [PaymentController::class, 'notify'])->name('payment.notify')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
Route::get('payment/return', [PaymentController::class, 'return'])->name('payment.return');

// 後台 Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', fn () => view('admin.auth.login'))->name('login');
    Route::post('login', [\App\Http\Controllers\Admin\AdminAuthController::class, 'login'])->name('login.post');
    Route::post('logout', [\App\Http\Controllers\Admin\AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware(AuthAdmin::class)->group(function () {
        Route::get('/', fn () => redirect()->route('admin.orders.index'));
        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::post('orders/{order}/assign', [AdminOrderController::class, 'assign'])->name('orders.assign');
        Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
        Route::get('orders/{order}/file', [AdminOrderController::class, 'file'])->name('orders.file');

        Route::get('printers', [AdminPrinterController::class, 'index'])->name('printers.index');
        Route::get('printers/create', [AdminPrinterController::class, 'create'])->name('printers.create');
        Route::post('printers', [AdminPrinterController::class, 'store'])->name('printers.store');
        Route::get('printers/{printer}/edit', [AdminPrinterController::class, 'edit'])->name('printers.edit');
        Route::patch('printers/{printer}', [AdminPrinterController::class, 'update'])->name('printers.update');
        Route::patch('printers/{printer}/suspend', [AdminPrinterController::class, 'suspend'])->name('printers.suspend');

        Route::get('specs/dimensions', [SpecController::class, 'dimensionIndex'])->name('specs.dimensions');
        Route::post('specs/dimensions', [SpecController::class, 'dimensionStore'])->name('specs.dimensions.store');
        Route::post('specs/options', [SpecController::class, 'optionStore'])->name('specs.options.store');
        Route::get('specs/products', [SpecController::class, 'productIndex'])->name('specs.products');
        Route::post('specs/products', [SpecController::class, 'productStore'])->name('specs.products.store');
        Route::get('specs/prices', [SpecController::class, 'priceIndex'])->name('specs.prices');
        Route::post('specs/prices', [SpecController::class, 'priceStore'])->name('specs.prices.store');
        Route::post('specs/discounts', [SpecController::class, 'discountStore'])->name('specs.discounts.store');
    });
});

// 印刷廠
Route::prefix('printer')->name('printer.')->group(function () {
    Route::get('login', [PrinterAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [PrinterAuthController::class, 'login'])->name('login.post');
    Route::post('logout', [PrinterAuthController::class, 'logout'])->name('logout');

    Route::middleware(AuthPrinter::class)->group(function () {
        Route::get('orders', [PrinterOrderController::class, 'index'])->name('orders.index');
        Route::patch('status', [PrinterOrderController::class, 'updateStatus'])->name('status.update');
        Route::get('orders/{order}/file', [PrinterOrderController::class, 'file'])->name('orders.file');
    });
});

require __DIR__ . '/auth.php';
