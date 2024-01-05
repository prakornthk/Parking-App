<?php

use App\Http\Controllers\CarParkController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\ParkingSlotController;
use App\Services\ParkingFeeCalculatorService;
use Carbon\Carbon;
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

Route::apiResource('parkings', ParkingController::class);

Route::group([
    'prefix' => 'parking-slots',
    'as' => 'parking-slots.'
], function() {
    Route::get('/{parking}', [ParkingSlotController::class, 'index'])->name('index');
    Route::post('/{parking}', [ParkingSlotController::class, 'store'])->name('store');
    Route::delete('/{parking}', [ParkingSlotController::class, 'destroy'])->name('destroy');
});

Route::group([
    'prefix' => 'car-parks',
    'as' => 'car-parks.'
], function() {
    Route::post('check-in/{parking}', [CarParkController::class, 'checkIn'])->name('check-in');
    Route::post('check-out/{parkingSlot}', [CarParkController::class, 'checkOut'])->name('check-out');
});
