<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('policies', PolicyController::class);
    Route::get('/policies/{policy}/download', [PolicyController::class, 'downloadPolicyPDF']);
});
