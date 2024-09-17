<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SessionController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/','/register');

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [AuthController::class, 'create'])->name('auth.create');

    Route::post('/register', [AuthController::class, 'store'])->name('auth.store');

    Route::get('/login', [SessionController::class, 'create'])->name('session.create');

    Route::post('/login', [SessionController::class, 'store'])->name('session.store');



});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [SessionController::class, 'destroy'])->name('session.destroy');
});