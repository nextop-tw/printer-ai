<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PrinterController as AdminPrinterController;
use App\Http\Controllers\Admin\SpecController;
use App\Http\Controllers\Api\OrderController as ApiOrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Client\ClientDashboardController;
use App\Http\Controllers\Client\OrderHistoryController;
use App\Http\Controllers\Printer\PrinterAuthController;
use App\Http\Controllers\Printer\PrinterOrderController;
use App\Http\Middleware\AuthAdmin;
use App\Http\Middleware\AuthPrinter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// 前台公開頁面
Route::get('/', fn () => view('frontend.home'))->name('home');
Route::get('/features', fn () => view('frontend.features'))->name('features');
Route::get('/pricing', fn () => view('frontend.pricing'))->name('pricing');

// 用戶登入
Route::get('/login', fn () => view('frontend.auth.login'))->name('login')->middleware('guest');
Route::post('/login', [\App\Http\Controllers\Auth\ClientLoginController::class, 'login'])->name('login.post');
Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('home');
})->name('logout');

// 用戶後台（需登入）
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
    Route::get('/upload', [ClientDashboardController::class, 'upload'])->name('upload');
    Route::get('/detect', [ClientDashboardController::class, 'detect'])->name('detect');
    Route::get('/profile', [ClientDashboardController::class, 'profile'])->name('profile');
    Route::patch('/profile', [ClientDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::patch('/profile/password', [ClientDashboardController::class, 'updatePassword'])->name('profile.password');
    Route::get('/orders', [OrderHistoryController::class, 'index'])->name('orders.index');
});

// Google OAuth
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');

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
    ->withoutMiddleware('web');
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

// auth.php (Breeze) 已停用 — 使用自訂登入與 Google OAuth
