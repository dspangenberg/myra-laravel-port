<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookkeepingBookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Requests\StoreUser;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/times/pdf', [TimeController::class, 'pdf']);

    Route::resource('/users', UserController::class);
    Route::resource('/contacts', ContactController::class);
    Route::resource('/bookings', BookkeepingBookingController::class);
    Route::resource('/documents', DocumentController::class);
    Route::resource('/invoices', InvoiceController::class);
    Route::resource('/projects', ProjectController::class);
    Route::resource('/times', TimeController::class);
    Route::resource('/receipts', ReceiptController::class);
    Route::resource('/transactions', TransactionController::class);
    Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'createPdf']);
    Route::get('/receipts/{receipt}/pdf', [ReceiptController::class, 'downloadReceipt']);
});

Route::middleware([HandlePrecognitiveRequests::class])->group(function () {
    Route::post('/users', function (StoreUser $request) {});
    Route::put('/users/{user}', function (StoreUser $request) {});
});
