<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
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
//    return view('welcome');
    return view('home-page');
})->name('home');

Route::get('/search-results', function () {
    return view('search-results');
})->name('search.results');

Route::get('/login', function () {
    return view('login-page');
})->name('login');

Route::get('/registration', function () {
    return view('sign-up-page');
})->name('registration');

Route::post('/registration', [RegisterController::class, 'store'])->name('registration');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/profile', function () {
    return view('profile-page');
})->name('profile');
