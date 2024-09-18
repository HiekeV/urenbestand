<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TimeEntryController;
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


Route::middleware(['guest'])->group(function () {
    Route::redirect('/', '/login');
    
    Route::get('/register', [AuthController::class, 'create'])->name('auth.create');
    
    Route::post('/register', [AuthController::class, 'store'])->name('auth.store');
    
    Route::get('/login', [SessionController::class, 'create'])->name('login');
    
    Route::post('/login', [SessionController::class, 'store'])->name('session.store');
    
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('/', '/upload-csv/create');
    
    Route::post('/logout', [SessionController::class, 'destroy'])->name('session.destroy');

    Route::get('/upload-csv', [TimeEntryController::class, 'create'])->name('time-entries.create');
    
    Route::post('/upload-csv/store', [TimeEntryController::class, 'store'])->name('time-entries.store');
    
    Route::get('/edit', [TimeEntryController::class, 'edit'])->name('time-entries.edit');

    Route::put('/update/{timeEntry}', [TimeEntryController::class, 'update'])->name('time-entries.update');

    Route::get('/download', [TimeEntryController::class, 'download'])->name('time-entries.download');

    Route::delete('/destroy/{timeEntry}', [TimeEntryController::class, 'destroy'])->name('time-entries.destroy');

    Route::get('/destroy-all', [TimeEntryController::class, 'destroyAll'])->name('time-entries.destroy-entries');
});