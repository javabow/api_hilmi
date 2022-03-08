<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\QuoteController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

Route::post('/report/insert', [ReportController::class, 'insert'])->middleware('auth:sanctum');

//inventory
Route::get('/data-product', [InventoryController::class, 'show'])->middleware('auth:sanctum');
Route::get('/get-single-data-product', [InventoryController::class, 'getDataId'])->middleware('auth:sanctum');
Route::post('/product-update', [InventoryController::class, 'update'])->middleware('auth:sanctum');
Route::post('/product-insert', [InventoryController::class, 'store'])->middleware('auth:sanctum');
Route::post('/product-delete', [InventoryController::class, 'destroy'])->middleware('auth:sanctum');

//quote
Route::get('/quote-show', [QuoteController::class, 'showQuote'])->middleware('auth:sanctum');
Route::get('/quote-single', [QuoteController::class, 'singleQuote'])->middleware('auth:sanctum');
