<?php

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

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/* To Do Controller Routes */
Route::get('/', [App\Http\Controllers\TodoController::class, 'index'])->name('welcome');
Route::get('/create', [App\Http\Controllers\TodoController::class, 'create'])->name('create');
Route::get('/details/{todo}', [App\Http\Controllers\TodoController::class, 'details'])->name('details');
Route::get('/edit/{todo}', [App\Http\Controllers\TodoController::class, 'edit'])->name('edit');
Route::post('/update/{todo}', [App\Http\Controllers\TodoController::class, 'update'])->name('update');
Route::get('/delete/{todo}', [App\Http\Controllers\TodoController::class, 'delete'])->name('delete');
Route::post('/store', [App\Http\Controllers\TodoController::class, 'store'])->name('store');

Route::prefix('api')->middleware('auth')->group(function () {
    Route::get('items', [App\Http\Controllers\TodoController::class, 'index_api']);
    Route::get('item/{todo}', [App\Http\Controllers\TodoController::class, 'details_api']);
    Route::post('store', [App\Http\Controllers\TodoController::class, 'store_api']);
    Route::put('/delete/{todo}', [App\Http\Controllers\TodoController::class, 'delete_api']);
});
