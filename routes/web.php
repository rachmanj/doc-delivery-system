<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middleware\CheckActive;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes - Apply guest middleware directly to routes
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

// Logout route (available to authenticated users)
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Protected Routes - Will be accessible only after login
Route::middleware(['auth', CheckActive::class])->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');
    
    // Load other route files from the routes directory 
    require __DIR__ . '/invoices.php';
    require __DIR__ . '/addocs.php';
    // require __DIR__ . '/deliveries.php';
    require __DIR__ . '/master.php';
    require __DIR__ . '/settings.php';
});
