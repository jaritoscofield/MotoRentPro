@extends('layouts.dashboard')

@section('title', 'Relatórios Gerais - MotoRentPro')
@section('page-title', 'Relatórios Gerais')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Relatórios Gerais do Sistema</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Visão completa de todos os módulos e métricas</p>
            </div>
            <div class="flex flex-wrap gap-2 mt-4 lg:mt-0">
                <button onclick="exportReport()" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-download mr-1.5 text-xs"></i>
                    Exportar PDF
                </button>
                <button onclick="printReport()" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-print mr-1.5 text-xs"></i>
                    Imprimir
                </button>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
        <form method="GET" action="/relatorios" id="reportForm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Período</label>
                    <select name="period" onchange="this.form.submit()" class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="7" {{ request('period', 30) == 7 ? 'selected' : '' }}>Últimos 7 dias</option>
                        <option value="30" {{ request('period', 30) == 30 ? 'selected' : '' }}>Últimos 30 dias</option>
                        <option value="90" {{ request('period', 30) == 90 ? 'selected' : '' }}>Últimos 90 dias</option>
                        <option value="180" {{ request('period', 30) == 180 ? 'selected' : '' }}>Últimos 6 meses</option>
                        <option value="365" {{ request('period', 30) == 365 ? 'selected' : '' }}>Último ano</option>
                        <option value="custom" {{ request('period') == 'custom' ? 'selected' : '' }}>Personalizado</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Data Inicial</label>
                    <input type="date" name="start_date" value="{{ $startDate ? $startDate->format('Y-m-d') : '' }}" 
                           class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Data Final</label>
                    <input type="date" name="end_date" value="{{ $endDate ? $endDate->format('Y-m-d') : '' }}" 
                           class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
            </div>
        </form>
    </div>

    <!-- Main Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Frota -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Frota</p>
                    <p class="text-2xl font-bold">{{ $stats['total_motorcycles'] }}</p>
                    <p class="text-xs opacity-75 mt-1">{{ $stats['active_motorcycles'] }} ativas</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-motorcycle text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Clientes -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Clientes</p>
                    <p class="text-2xl font-bold">{{ $stats['total_clients'] }}</p>
                    <p class="text-xs opacity-75 mt-1">{{ $stats['active_clients'] }} ativos</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Reservas -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Reservas</p>
                    <p class="text-2xl font-bold">{{ $stats['total_reservations'] }}</p>
                    <p class="text-xs opacity-75 mt-1">{{ $stats['active_reservations'] }} ativas</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Receita -->
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Receita Total</p>
                    <p class="text-2xl font-bold">R$ {{ number_format($stats['total_revenue'], 2, ',', '.') }}</p>
                    <p class="text-xs opacity-75 mt-1">{{ $stats['total_payments'] }} transações</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Manutenções -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Manutenções</h3>
                <i class="fas fa-tools text-gray-400 dark:text-gray-500"></i>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Total</span>
                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $stats['total_maintenances'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Em Andamento</span>
                    <span class="text-sm font-medium text-yellow-600">{{ $stats['active_maintenances'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Concluídas</span>
                    <span class="text-sm font-medium text-green-600">{{ $stats['completed_maintenances'] }}</span>
                </div>
            </div>
        </div>

        <!-- Status da Frota -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Status da Frota</h3>
                <i class="fas fa-motorcycle text-gray-400 dark:text-gray-500"></i>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Ativas</span>
                    <span class="text-sm font-medium text-green-600">{{ $stats['active_motorcycles'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Em Manutenção</span>
                    <span class="text-sm font-medium text-yellow-600">{{ $stats['maintenance_motorcycles'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Inativas</span>
                    <span class="text-sm font-medium text-red-600">{{ $stats['total_motorcycles'] - $stats['active_motorcycles'] - $stats['maintenance_motorcycles'] }}</span>
                </div>
            </div>
        </div>

        <!-- Financeiro -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Financeiro</h3>
                <i class="fas fa-chart-line text-gray-400 dark:text-gray-500"></i>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Recebido</span>
                    <span class="text-sm font-medium text-green-600">R$ {{ number_format($stats['total_received'], 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Pendente</span>
                    <span class="text-sm font-medium text-yellow-600">R$ {{ number_format($stats['pending_amount'], 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Total</span>
                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">R$ {{ number_format($stats['total_revenue'], 2, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Revenue Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Receita</h3>
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Receita</span>
                </div>
            </div>
            <div class="h-48">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Reservations Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Reservas</h3>
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 bg-purple-500 rounded-full"></span>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Reservas</span>
                </div>
            </div>
            <div class="h-48">
                <canvas id="reservationsChart"></canvas>
            </div>
        </div>

        <!-- Maintenance Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Manutenções</h3>
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 bg-orange-500 rounded-full"></span>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Manutenções</span>
                </div>
            </div>
            <div class="h-48">
                <canvas id="maintenanceChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Performers -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Top Motorcycles -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Top Motocicletas</h3>
            <div class="space-y-3">
                @foreach($topMotorcycles as $motorcycle)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/40 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-motorcycle text-blue-600 dark:text-blue-400 text-xs"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $motorcycle->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $motorcycle->reservations_count }} reservas</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $motorcycle->license_plate }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Top Clients -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Top Clientes</h3>
            <div class="space-y-3">
                @foreach($topClients as $client)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-100 dark:bg-green-900/40 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-green-600 dark:text-green-400 text-xs"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $client->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $client->reservations_count }} reservas</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $client->email }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Top Revenue Motorcycles -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Maior Receita</h3>
            <div class="space-y-3">
                @foreach($topRevenueMotorcycles as $item)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900/40 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-dollar-sign text-yellow-600 dark:text-yellow-400 text-xs"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $item->motorcycle->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $item->motorcycle->license_plate }}</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">R$ {{ number_format($item->total_revenue, 2, ',', '.') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Atividade Recente</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($recentActivity as $activity)
                <div class="flex items-center space-x-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="flex-shrink-0">
                        @if($activity['type'] === 'reservation')
                            <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/40 rounded-full flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-purple-600 dark:text-purple-400 text-xs"></i>
                            </div>
                        @elseif($activity['type'] === 'maintenance')
                            <div class="w-8 h-8 bg-orange-100 dark:bg-orange-900/40 rounded-full flex items-center justify-center">
                                <i class="fas fa-tools text-orange-600 dark:text-orange-400 text-xs"></i>
                            </div>
                        @elseif($activity['type'] === 'payment')
                            <div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900/40 rounded-full flex items-center justify-center">
                                <i class="fas fa-credit-card text-yellow-600 dark:text-yellow-400 text-xs"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $activity['title'] }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $activity['description'] }}</p>
                    </div>
                    <div class="flex-shrink-0 text-right">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">R$ {{ number_format($activity['amount'], 2, ',', '.') }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $activity['date']->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($revenueChart['labels']) !!},
            datasets: [{
                label: 'Receita',
                data: {!! json_encode($revenueChart['data']) !!},
                borderColor: '#EAB308',
                backgroundColor: 'rgba(234, 179, 8, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'R$ ' + value.toLocaleString('pt-BR');
                        }
                    }
                }
            }
        }
    });

    // Reservations Chart
    const reservationsCtx = document.getElementById('reservationsChart').getContext('2d');
    new Chart(reservationsCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($reservationsChart['labels']) !!},
            datasets: [{
                label: 'Reservas',
                data: {!! json_encode($reservationsChart['data']) !!},
                borderColor: '#8B5CF6',
                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Maintenance Chart
    const maintenanceCtx = document.getElementById('maintenanceChart').getContext('2d');
    new Chart(maintenanceCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($maintenanceChart['labels']) !!},
            datasets: [{
                label: 'Manutenções',
                data: {!! json_encode($maintenanceChart['data']) !!},
                borderColor: '#F97316',
                backgroundColor: 'rgba(249, 115, 22, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});

function exportReport() {
    // Implement PDF export functionality
    alert('Funcionalidade de exportação será implementada');
}

function printReport() {
    window.print();
}
</script>
@endsection 