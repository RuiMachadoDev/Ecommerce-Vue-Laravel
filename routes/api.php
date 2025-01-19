<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Protege as rotas com autenticação e verifica o papel de admin
Route::middleware(['auth'])->group(function () {
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    
    Route::apiResource('products', ProductController::class);
});