<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\EventsApiController;
use Illuminate\Support\Facades\Route;

Route::post('login',[AuthApiController::class,'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('logout',[AuthApiController::class,'logout']);
    Route::get('events',[EventsApiController::class,'index']);

    Route::get('guests/{eventId}',[EventsApiController::class,'guests']);
    Route::post('bookings/{referenceNumber}/checkin', [EventsApiController::class, 'checkIn']);
    Route::get('bookings/{referenceNumber}/details', [EventsApiController::class, 'bookingDetails']);

    
});
