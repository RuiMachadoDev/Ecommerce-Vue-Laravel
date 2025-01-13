<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'csrf_token' => csrf_token(),
    ]);
});

// Dashboard: acessível apenas a utilizadores autenticados
Route::get('/dashboard', function () {
    if (auth()->user()->hasRole('admin')) {
        return Inertia::render('AdminDashboard');
    }
    return Inertia::render('UserDashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Logout
Route::post('/logout', function () {
    auth()->logout();
    return redirect('/login');
})->name('logout');

// Rotas protegidas por papéis
Route::middleware('auth')->group(function () {
    // Rotas para administradores
    Route::middleware('role:admin')->group(function () {
        Route::get('/categories', function () {
            return Inertia::render('Categories');
        })->name('categories');

        Route::get('/products', [ProductController::class, 'index'])->name('products');
    });

    // Rotas para utilizadores normais
    Route::middleware('auth')->group(function () {
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
        Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    });
});

// Página pública para todos os utilizadores
Route::get('/shop', [\App\Http\Controllers\ProductController::class, 'showPublicProducts'])->name('shop');

// Auth routes
require __DIR__ . '/auth.php';
