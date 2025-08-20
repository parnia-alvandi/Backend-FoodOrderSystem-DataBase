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

/** Auth (pages + actions) */
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/** Menu (pages) */
Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');   // لیست منو
Route::get('/menus/{menu}', [MenuController::class, 'show'])->name('menus.show'); // نمایش جزئیات هر منو

/** Protected */
Route::middleware(['auth'])->group(function () {
    Route::post('/order/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::post('/order/place', [OrderController::class, 'placeOrder'])->name('order.place');

    Route::get('/payment/{order_id}', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('/payment/result/{status}/{order_id}', [PaymentController::class, 'result'])->name('payment.result');

    Route::post('/rate-food/{id}', [SurveyController::class, 'rate'])->name('food.rate');
    Route::post('/comment/{id}', [CommentController::class, 'comment'])->name('food.comment');
});

/** Admin-only */
Route::middleware(['admin'])->group(function () {
    Route::resource('menus', MenuController::class); // اینجا هم menus گذاشتم

    Route::get('/admin/orders-report', [ReportController::class, 'ordersReport'])->name('admin.orders_report');
    Route::get('/admin/popular-food', [ReportController::class, 'popularFood'])->name('admin.popular_food');
    Route::get('/admin/payment-report', [ReportController::class, 'paymentReport'])->name('admin.payment_report');
});
