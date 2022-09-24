<?php

use App\Http\Controllers\Nova\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Nova Routes
|--------------------------------------------------------------------------
|
| Here you can register additional Nova routes for your Nova application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "nova" middleware group. Extend Your Nova!
*/


Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('show-register-form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
