<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MotorcycleController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;

// Rota principal - redireciona para dashboard se logado, senão para login
Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
});



// Rotas de Login Web
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rotas protegidas (requer autenticação)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rotas de motocicletas
    Route::get('/frota', [MotorcycleController::class, 'index'])->name('motorcycles.index');
    Route::get('/frota/create', [MotorcycleController::class, 'create'])->name('motorcycles.create');
    Route::post('/frota', [MotorcycleController::class, 'store'])->name('motorcycles.store');
    Route::get('/frota/{motorcycle}', [MotorcycleController::class, 'show'])->name('motorcycles.show');
    Route::get('/frota/{motorcycle}/edit', [MotorcycleController::class, 'edit'])->name('motorcycles.edit');
    Route::put('/frota/{motorcycle}', [MotorcycleController::class, 'update'])->name('motorcycles.update');
    Route::delete('/frota/{motorcycle}', [MotorcycleController::class, 'destroy'])->name('motorcycles.destroy');
    Route::post('/frota/bulk-delete', [MotorcycleController::class, 'bulkDelete'])->name('motorcycles.bulk-delete');
    Route::get('/frota/export', [MotorcycleController::class, 'export'])->name('motorcycles.export');
    
    // Rotas de clientes
    Route::get('/clientes', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clientes/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clientes', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clientes/{client}', [ClientController::class, 'show'])->name('clients.show');
    Route::get('/clientes/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clientes/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clientes/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
    Route::post('/clientes/bulk-delete', [ClientController::class, 'bulkDelete'])->name('clients.bulk-delete');
    Route::get('/clientes/export', [ClientController::class, 'export'])->name('clients.export');
    
    // Rotas de reservas
    Route::get('/reservas', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservas/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservas', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservas/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::get('/reservas/{reservation}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('/reservas/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('/reservas/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    Route::post('/reservas/bulk-delete', [ReservationController::class, 'bulkDelete'])->name('reservations.bulk-delete');
    Route::get('/reservas/export', [ReservationController::class, 'export'])->name('reservations.export');
    Route::get('/reservas/motorcycle-rate', [ReservationController::class, 'getMotorcycleRate'])->name('reservations.motorcycle-rate');
    
    // Rotas de manutenção
    Route::get('/manutencao', [MaintenanceController::class, 'index'])->name('maintenances.index');
    Route::get('/manutencao/create', [MaintenanceController::class, 'create'])->name('maintenances.create');
    Route::post('/manutencao', [MaintenanceController::class, 'store'])->name('maintenances.store');
    Route::get('/manutencao/{maintenance}', [MaintenanceController::class, 'show'])->name('maintenances.show');
    Route::get('/manutencao/{maintenance}/edit', [MaintenanceController::class, 'edit'])->name('maintenances.edit');
    Route::put('/manutencao/{maintenance}', [MaintenanceController::class, 'update'])->name('maintenances.update');
    Route::delete('/manutencao/{maintenance}', [MaintenanceController::class, 'destroy'])->name('maintenances.destroy');
    Route::post('/manutencao/bulk-delete', [MaintenanceController::class, 'bulkDelete'])->name('maintenances.bulk-delete');
    Route::get('/manutencao/export', [MaintenanceController::class, 'export'])->name('maintenances.export');
    
    // Rotas de pagamentos
    Route::get('/pagamentos', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/pagamentos/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/pagamentos', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/pagamentos/export', [PaymentController::class, 'export'])->name('payments.export');
    Route::get('/pagamentos/dashboard', [PaymentController::class, 'dashboard'])->name('payments.dashboard');
    Route::get('/pagamentos/reports', [PaymentController::class, 'reports'])->name('payments.reports');
    Route::get('/pagamentos/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::get('/pagamentos/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
    Route::put('/pagamentos/{payment}', [PaymentController::class, 'update'])->name('payments.update');
    Route::delete('/pagamentos/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');
    
    // Rotas para registro de pagamentos de parcelas
    Route::get('/pagamentos/installment/register', [PaymentController::class, 'showRegisterPaymentForm'])->name('payments.installment.register');
    Route::post('/pagamentos/installment/register', [PaymentController::class, 'registerPayment'])->name('payments.installment.store');
    Route::get('/pagamentos/installment/pending', [PaymentController::class, 'getPendingInstallments'])->name('payments.installment.pending');
    
    // Rotas de relatórios gerais
    Route::get('/relatorios', [ReportController::class, 'index'])->name('reports.index');
    
    // Rotas de perfil
    Route::get('/perfil', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/perfil/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/perfil/password', [ProfileController::class, 'changePassword'])->name('profile.password');
    Route::post('/perfil/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    
    // Rotas de configurações
    Route::get('/configuracoes', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/configuracoes/update', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('/configuracoes/backup', [SettingsController::class, 'backup'])->name('settings.backup');
    Route::get('/configuracoes/clear-cache', [SettingsController::class, 'clearCache'])->name('settings.clear-cache');
    Route::get('/configuracoes/system-info', [SettingsController::class, 'systemInfo'])->name('settings.system-info');
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
