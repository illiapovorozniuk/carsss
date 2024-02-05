<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum',)->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::prefix('rent')->group(function () {
        Route::post('/searchfreecars', [RentController::class, 'searchFreeCars']);
        Route::post('/createnewbooking', [RentController::class, 'createBooking']);
    });
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/statisticsforthemonth', [StatisticsController::class, 'statisticsForTheMonth']);
    Route::get('/getbrands', [StatisticsController::class, 'getBrands']);

    Route::get('/getyears', [StatisticsController::class, 'getYears']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
