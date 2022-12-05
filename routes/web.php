<?php

use App\Http\Controllers\HomeController;
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

Route::group(function () {
    Route::get('/', [HomeController::class, 'dashboard'])->name("dashboard");
});

Route::any("tlg_webhook", [App\Http\Controllers\BotController::class, "webhook"]);
