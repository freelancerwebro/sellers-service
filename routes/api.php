<?php

declare(strict_types=1);

use App\Http\Controllers\GetSalesController;
use App\Http\Controllers\GetSellerContactsController;
use App\Http\Controllers\GetSellerController;
use App\Http\Controllers\GetSellerSalesController;
use App\Http\Controllers\LoadFileController;
use Illuminate\Support\Facades\Route;

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

Route::post('/load', LoadFileController::class)->name('loadFile');

Route::get('/sellers/{sellerId}', GetSellerController::class)->name('getSeller');
Route::get('/sellers/{sellerId}/contacts', GetSellerContactsController::class)->name('getSellerContacts');
Route::get('/sellers/{sellerId}/sales', GetSellerSalesController::class)->name('getSellerSales');
Route::get('/sales/{year}', GetSalesController::class)->name('getSales');
