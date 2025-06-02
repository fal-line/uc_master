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
});
