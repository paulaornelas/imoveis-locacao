<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProprietarioController;
use App\Http\Controllers\ImovelController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('imoveis/filter', [ImovelController::class, 'filter']);
Route::apiResource('proprietarios', ProprietarioController::class);
Route::apiResource('imoveis', ImovelController::class);

