<?php

use App\Http\Controllers\api\KiosDailyRecapApiController;
use App\Http\Controllers\api\LogistikRepairFormController;
use App\Http\Controllers\CertificateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\kios\KiosPaymentController;
use App\Http\Controllers\repair\ReviewCustomerController;

Route::put('/updatePayment/{id}', [KiosPaymentController::class, 'updatePayment']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/send-review-repair', [ReviewCustomerController::class, 'sendWhatsapp']);
Route::post('/create-daily-recap', [KiosDailyRecapApiController::class, 'createDailyRecap']);
Route::post('/create-data-form-repair', [LogistikRepairFormController::class, 'storeFromFormGoogleRepair']);
Route::post('/update-resi-form-repair', [LogistikRepairFormController::class, 'updateFormForResi']);
Route::post('/send-certificate', [CertificateController::class, 'sendSertificate']);