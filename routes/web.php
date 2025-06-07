<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Middleware\IsAdmin;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [App\Http\Controllers\MenuController::class, 'index']);

Auth::routes();


Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\MenuController::class, 'orderPage'])->name('home');
    Route::delete('/home', [App\Http\Controllers\MenuController::class, 'destroy']);
    Route::post('/home/store', [App\Http\Controllers\MenuController::class, 'store']);
    

    
});


Route::middleware('role:admin')->group(function () {

    
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
// Menu Management -----------------------------------
    // Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/menu', [App\Http\Controllers\AdminController::class, 'indexMenu'])->name('menuData');

    Route::get('/dashboard/menu/new', function () {
        return view('management/menuNew');
    });
    Route::post('/dashboard/menu', [App\Http\Controllers\AdminController::class, 'createMenu']);

    Route::get('/dashboard/menu/{id}', [App\Http\Controllers\AdminController::class, 'detailMenu']);
    Route::put('/dashboard/menu/{id}', [App\Http\Controllers\AdminController::class, 'updateMenu']);
    Route::delete('/dashboard/menu/{id}', [App\Http\Controllers\AdminController::class, 'deleteMenu']);
// Menu Management / User Management  -----------------------------------

    // Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/crew', [App\Http\Controllers\AdminController::class, 'indexCrew'])->name('crewData');

    Route::get('/dashboard/crew/new', function () {
        return view('management/crewNew');
    });
    Route::post('/dashboard/crew', [App\Http\Controllers\AdminController::class, 'createCrew']);

    Route::get('/dashboard/crew/{id}', [App\Http\Controllers\AdminController::class, 'detailCrew']);
    Route::put('/dashboard/crew/{id}', [App\Http\Controllers\AdminController::class, 'updateCrew']);
    Route::delete('/dashboard/crew/{id}', [App\Http\Controllers\AdminController::class, 'deleteCrew']);
// User Management /  -----------------------------------
    
    // Route::get('/dashboard/order', function () {
    //     return view('management/order');
    // });
    // Route::get('/dashboard/crew', function () {
    //     return view('management/crew');
    // });
    // Route::get('/dashboard/payment', function () {
    //     return view('management/payment');
    // });
});
