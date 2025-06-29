<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\MedicineRecommendationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Patient routes
    Route::get('/patients/search', [PatientController::class, 'search']);
    Route::get('/patients/all', [PatientController::class, 'all']);
    Route::get('/patients/{patient}/prescriptions', [PatientController::class, 'prescriptions']);

    // Recommendation routes
    Route::post('/medicines/recommendations', [MedicineRecommendationController::class, 'getRecommendations']);
});
