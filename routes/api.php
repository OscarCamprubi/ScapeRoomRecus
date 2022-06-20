<?php

use App\Http\Controllers\ValoracioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\WelcomeController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('vouchers',VoucherController::class);
Route::get('vouchers/{nom}',[VoucherController::class,'create']);
Route::post('save-valoracio', [ValoracioController::class, 'save']);
Route::get('five-valoracions', [ValoracioController::class, 'fiveValoracions']);
