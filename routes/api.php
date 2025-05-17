<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\EventController;
use Illuminate\Http\Request;
use App\Http\Controllers\API\AuthController;

use Illuminate\Support\Facades\Route;


Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/logout',[AuthController::class,'logout']);
Route::group(['middleware'=>'verifyToken'],function(){
    Route::post('/logout',[AuthController::class,'logout']);
    Route::post('/refresh',[AuthController::class,'refresh']);

});
Route::group(['middleware'=>'admin'],function() {
    Route::post('/event/create', [EventController::class, 'create']);
    Route::post('/event/read', [EventController::class, 'read']);
  Route::post('/event/{id}', [EventController::class, 'show']);
    Route::put('/event/{id}', [EventController::class, 'update']);
    Route::delete('/event/{id}', [EventController::class, 'delete']);
});

Route::middleware('auth:api')->group(function () {
    Route::post('/book/{event_id}', [BookingController::class, 'bookEvent']);
    Route::get('/mybookings', [BookingController::class, 'mybookings']);
});
