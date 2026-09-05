<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Referral\Http\Controllers\ReferralController;

Route::prefix('api/v1')->middleware('auth:sanctum')->group(function () {
    Route::prefix('referral-codes')->group(function () {
        Route::get('/', [ReferralController::class, 'index'])->middleware('permission:referral:view');
        Route::post('/', [ReferralController::class, 'store'])->middleware('permission:referral:view');
        Route::put('/{id}/toggle', [ReferralController::class, 'toggle'])->whereNumber('id')->middleware('permission:referral:view');
    });

    Route::prefix('referrals')->group(function () {
        Route::get('/', [ReferralController::class, 'referrals'])->middleware('permission:referral:view');
    });

    Route::prefix('commission-rules')->group(function () {
        Route::get('/', [ReferralController::class, 'rules'])->middleware('permission:referral:view');
    });
});