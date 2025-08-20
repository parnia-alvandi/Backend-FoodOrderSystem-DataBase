<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController, MenuController, OrderController, PaymentController,
    SurveyController, CommentController, ReportController
};

// Auth
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me',     [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Menus
    Route::get('/menus', [MenuController::class, 'index']);
    Route::get('/menus/{menu}', [MenuController::class, 'show']);
    Route::post('/menus', [MenuController::class, 'store'])->middleware('admin');
    Route::put('/menus/{menu}', [MenuController::class, 'update'])->middleware('admin');
    Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])->middleware('admin');

    // Orders
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/my', [OrderController::class, 'myOrders']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->middleware('admin');

    // Payment
    Route::post('/orders/{order}/pay', [PaymentController::class, 'pay']);

    // Surveys & Comments
    Route::post('/surveys', [SurveyController::class, 'store']);
    Route::get('/menus/{menuId}/comments', [CommentController::class, 'index']);
    Route::post('/comments', [CommentController::class, 'store']);

    // Reports (admin)
    Route::get('/reports/orders-by-status', [ReportController::class, 'ordersByStatus'])->middleware('admin');
    Route::get('/reports/popular-menus',   [ReportController::class, 'popularMenus'])->middleware('admin');
    Route::get('/reports/payments-summary',[ReportController::class, 'paymentsSummary'])->middleware('admin');
});
