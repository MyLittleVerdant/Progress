<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\DealController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthorizationController::class, 'index'])->name('index');

Route::get('/auth', [AuthenticationController::class, 'index'])->name('index');

Route::group(['prefix' => '/deal', 'as' => 'deal.'], function () {
    Route::get('/', [DealController::class, 'index'])->name('index');
    Route::post('/{deal?}', [DealController::class, 'store'])->name('store');
});
