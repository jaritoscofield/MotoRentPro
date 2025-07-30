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

Route::get('/', function () {
    return view('welcome');
});

// Rota para servir imagens do storage (pública)
Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    
    if (!file_exists($fullPath)) {
        return response('Arquivo não encontrado: ' . $path, 404);
    }
    
    try {
        $file = file_get_contents($fullPath);
        $type = mime_content_type($fullPath);
        
        return response($file, 200, [
            'Content-Type' => $type,
            'Cache-Control' => 'public, max-age=31536000',
            'Content-Length' => strlen($file)
        ]);
    } catch (Exception $e) {
        return response('Erro ao ler arquivo', 500);
    }
})->where('path', '.*');

// Rota de teste para debug
Route::get('/test-image/{filename}', function ($filename) {
    $fullPath = storage_path('app/public/motorcycles/' . $filename);
    
    echo "<h1>Teste de Imagem</h1>";
    echo "<p>Arquivo: {$filename}</p>";
    echo "<p>Caminho completo: {$fullPath}</p>";
    echo "<p>Existe: " . (file_exists($fullPath) ? 'SIM' : 'NÃO') . "</p>";
    
    if (file_exists($fullPath)) {
        echo "<p>Tamanho: " . filesize($fullPath) . " bytes</p>";
        echo "<p>Tipo: " . mime_content_type($fullPath) . "</p>";
        echo "<img src='/storage/motorcycles/{$filename}' style='max-width: 300px;'>";
    }
    
    echo "<hr>";
    echo "<p><a href='/storage/motorcycles/{$filename}' target='_blank'>Abrir imagem diretamente</a></p>";
});

// Rota para listar todas as motos e suas imagens
Route::get('/debug-motos', function () {
    $motorcycles = \App\Models\Motorcycle::all();
    
    echo "<h1>Debug - Todas as Motos</h1>";
    echo "<p>Total de motos: " . $motorcycles->count() . "</p>";
    
    foreach ($motorcycles as $moto) {
        echo "<hr>";
        echo "<h3>Moto ID: {$moto->id}</h3>";
        echo "<p>Nome: {$moto->name}</p>";
        echo "<p>Imagem no banco: " . ($moto->image ?: 'N/A') . "</p>";
        
        if ($moto->image) {
            $fullPath = storage_path('app/public/' . $moto->image);
            echo "<p>Caminho completo: {$fullPath}</p>";
            echo "<p>Arquivo existe: " . (file_exists($fullPath) ? 'SIM' : 'NÃO') . "</p>";
            
            if (file_exists($fullPath)) {
                echo "<p>Tamanho: " . filesize($fullPath) . " bytes</p>";
                echo "<p>Tipo: " . mime_content_type($fullPath) . "</p>";
                echo "<img src='/storage/{$moto->image}' style='max-width: 200px; border: 1px solid #ccc;'>";
                echo "<br><a href='/storage/{$moto->image}' target='_blank'>Abrir imagem</a>";
            }
        }
    }
    
    echo "<hr>";
    echo "<h2>Arquivos no diretório storage/app/public/motorcycles/</h2>";
    $files = scandir(storage_path('app/public/motorcycles'));
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            echo "<p>Arquivo: {$file}</p>";
        }
    }
});

// Rota temporária para testar motos sem autenticação
Route::get('/test-motos', function () {
    $motorcycles = \App\Models\Motorcycle::all();
    return view('modules.motorcycles.index', compact('motorcycles'));
});

// Rota de teste simples
Route::get('/teste', function () {
    return 'Servidor funcionando!';
});

// Rota de teste do controller
Route::get('/teste-controller', function () {
    $controller = new \App\Http\Controllers\MotorcycleController();
    return $controller->index(request());
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
