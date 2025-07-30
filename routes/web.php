<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MotorcycleController;

Route::get('/', function () {
    return view('welcome');
});

// Rotas de Login Web
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rotas protegidas (requer autenticação)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rotas de motocicletas
    Route::resource('motorcycles', MotorcycleController::class);
    Route::post('motorcycles/bulk-delete', [MotorcycleController::class, 'bulkDelete'])->name('motorcycles.bulk-delete');
    Route::get('motorcycles/export', [MotorcycleController::class, 'export'])->name('motorcycles.export');
});

// Rotas de autenticação API
Route::post('/api/register', [AuthController::class, 'register']);
Route::post('/api/login', [AuthController::class, 'login']);

// Rotas protegidas API
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/api/logout', [AuthController::class, 'logout']);
    Route::get('/api/me', [AuthController::class, 'me']);
    
    // Rotas de usuários (apenas admin)
    Route::middleware('admin')->group(function () {
        Route::apiResource('/api/users', UserController::class);
    });
});
