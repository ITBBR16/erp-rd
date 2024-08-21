<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\kios\KiosPaymentController;
use App\Http\Controllers\repair\ReviewCustomerController;

Route::put('/updatePayment/{id}', [KiosPaymentController::class, 'updatePayment']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/send-review-repair', [ReviewCustomerController::class, 'sendWhatsapp']);
