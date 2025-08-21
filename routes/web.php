<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

/** -------- Auth (صفحات + اکشن‌ها) -------- */
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/** -------- Menu (عمومی) -------- */
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{menu}', [MenuController::class, 'show'])->name('menu.show');

/** -------- Protected (کاربران لاگین) -------- */
Route::middleware(['auth'])->group(function () {
    Route::post('/order/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::post('/order/place', [OrderController::class, 'placeOrder'])->name('order.place');

    /** Payment */
    Route::get('/payment/{order_id}', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('/payment/result/{status}/{order_id}', [PaymentController::class, 'result'])->name('payment.result');

    /** Survey & Comment */
    Route::post('/rate-food/{id}', [SurveyController::class, 'rate'])->name('food.rate');
    Route::post('/comment/{id}', [CommentController::class, 'comment'])->name('food.comment');
});

/** -------- Admin-only (CRUD کامل منو) -------- */
Route::middleware(['admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('menu', MenuController::class); // admin.menu.index, admin.menu.create, ...
        Route::get('/orders-report', [ReportController::class, 'ordersReport'])->name('orders_report');
        Route::get('/popular-food', [ReportController::class, 'popularFood'])->name('popular_food');
        Route::get('/payment-report', [ReportController::class, 'paymentReport'])->name('payment_report');
    });
