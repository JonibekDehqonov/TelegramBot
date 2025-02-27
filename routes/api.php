<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


use App\Http\Controllers\BusController;
use App\Http\Controllers\TelegramController;

Route::post('/update-location', [BusController::class, 'updateLocation']);
Route::get('/bus/{bus_number}', [BusController::class, 'getLocation']);
Route::post('/telegram-webhook', [TelegramController::class, 'handleWebhook']);
