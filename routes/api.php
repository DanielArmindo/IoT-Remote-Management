<?php

use App\Http\Controllers\api\SensorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Related to sensors
Route::get('estado', [SensorController::class, 'estadoSistema']);
Route::get('chart', [SensorController::class, 'getChart']);
Route::get('sensor', [SensorController::class, 'indexCisco']); // Para o cisco
Route::get('sensor/data', [SensorController::class, 'index']);
Route::get('sensor/log', [SensorController::class, 'getLog']);
Route::post('sensor', [SensorController::class, 'store']);
Route::post('sensor/cisco', [SensorController::class, 'storeCisco']);
Route::post('cache', [SensorController::class, 'updateCache']);

Route::post('picture', [SensorController::class, 'store_picture']);
Route::get('trigger', [SensorController::class, 'index_trigger']);
Route::post('trigger', [SensorController::class, 'store_trigger']);
