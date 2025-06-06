<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [App\Http\Controllers\MenuController::class, 'index']);

Auth::routes();


Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\MenuController::class, 'orderPage'])->name('home');
    Route::delete('/home', [App\Http\Controllers\MenuController::class, 'destroy']);
    Route::post('/home/store', [App\Http\Controllers\MenuController::class, 'store']);

    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    // Route::get('/dashboard/menu', [App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    
    Route::get('/dashboard/menu', function () {
        return view('management/menu');
    });
    Route::get('/dashboard/order', function () {
        return view('management/order');
    });
    Route::get('/dashboard/crew', function () {
        return view('management/crew');
    });
    Route::get('/dashboard/payment', function () {
        return view('management/payment');
    });
});
