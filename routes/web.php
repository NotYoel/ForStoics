<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('homepage');
});

Route::get('/register', [UserController::class, 'register']);
Route::post('/register', [UserController::class, 'store']);

Route::get('/login', [UserController::class, 'login']);
Route::post('/login', [UserController::class, 'attemptLogin']);

Route::get('/logout', [UserController::class, 'logout']);