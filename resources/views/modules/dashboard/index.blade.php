@extends('layouts.dashboard')

@section('title', 'Dashboard - MotoRentPro')
@section('page-title', 'Dashboard')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Dashboard</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Visão geral do sistema de locação</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-motorcycle text-blue-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Motos Disponíveis</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['available_motorcycles'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-key text-green-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Motos Alugadas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['rented_motorcycles'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-users text-purple-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Clientes Ativos</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['active_clients'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-dollar-sign text-green-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Receita Mensal</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">R$ {{ number_format($stats['monthly_revenue'], 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Motos em Manutenção</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['maintenance_motorcycles'] }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-green-600">Crescimento</p>
                    <p class="text-lg font-bold text-green-600">+{{ $stats['growth_percentage'] }}%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Revenue Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3">Receita Mensal</h3>
            <div class="h-48">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Motorcycle Status Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3">Status das Motocicletas</h3>
            <div class="h-48">
                <canvas id="motorcycleChart"></canvas>
            </div>
        </div>
    </div>

    <!-- More Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Reservation Status Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3">Status das Reservas</h3>
            <div class="h-48">
                <canvas id="reservationChart"></canvas>
            </div>
        </div>

        <!-- Maintenance Activity Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3">Atividade de Manutenção (30 dias)</h3>
            <div class="h-48">
                <canvas id="maintenanceChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Reservations -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Reservas Recentes</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Moto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Período</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($recent_reservations as $reservation)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $reservation->client->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $reservation->motorcycle->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $reservation->start_date ? \Carbon\Carbon::parse($reservation->start_date)->format('d/m') : 'N/A' }} - 
                            {{ $reservation->end_date ? \Carbon\Carbon::parse($reservation->end_date)->format('d/m') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($reservation->status == 'Ativo')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Ativo</span>
                            @elseif($reservation->status == 'Pendente')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pendente</span>
                            @elseif($reservation->status == 'Confirmado')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Confirmado</span>
                            @elseif($reservation->status == 'Concluída')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Concluída</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">{{ $reservation->status ?? 'N/A' }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            Nenhuma reserva encontrada
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: @json(array_column($monthly_revenue_data ?? [], 'month')),
        datasets: [{
            label: 'Receita (R$)',
            data: @json(array_column($monthly_revenue_data ?? [], 'revenue')),
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4,
            fill: true,
            pointRadius: 3,
            pointHoverRadius: 5
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
            x: {
                ticks: {
                    font: {
                        size: 11
                    }
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    font: {
                        size: 11
                    },
                    callback: function(value) {
                        return 'R$ ' + value.toLocaleString();
                    }
                }
            }
        }
    }
});

// Motorcycle Status Chart
const motorcycleCtx = document.getElementById('motorcycleChart').getContext('2d');
new Chart(motorcycleCtx, {
    type: 'doughnut',
    data: {
        labels: @json(array_column($motorcycle_status_data ?? [], 'label')),
        datasets: [{
            data: @json(array_column($motorcycle_status_data ?? [], 'value')),
            backgroundColor: [
                'rgb(34, 197, 94)',
                'rgb(59, 130, 246)',
                'rgb(239, 68, 68)',
                'rgb(168, 85, 247)'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    font: {
                        size: 11
                    },
                    padding: 10
                }
            }
        }
    }
});

// Reservation Status Chart
const reservationCtx = document.getElementById('reservationChart').getContext('2d');
new Chart(reservationCtx, {
    type: 'bar',
    data: {
        labels: @json(array_column($reservation_status_data ?? [], 'label')),
        datasets: [{
            label: 'Quantidade',
            data: @json(array_column($reservation_status_data ?? [], 'value')),
            backgroundColor: [
                'rgba(34, 197, 94, 0.8)',
                'rgba(59, 130, 246, 0.8)',
                'rgba(239, 68, 68, 0.8)',
                'rgba(168, 85, 247, 0.8)'
            ],
            borderColor: [
                'rgb(34, 197, 94)',
                'rgb(59, 130, 246)',
                'rgb(239, 68, 68)',
                'rgb(168, 85, 247)'
            ],
            borderWidth: 1
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
            x: {
                ticks: {
                    font: {
                        size: 11
                    }
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    font: {
                        size: 11
                    }
                }
            }
        }
    }
});

// Maintenance Activity Chart
const maintenanceCtx = document.getElementById('maintenanceChart').getContext('2d');
new Chart(maintenanceCtx, {
    type: 'line',
    data: {
        labels: @json(array_column($maintenance_data ?? [], 'date')),
        datasets: [{
            label: 'Manutenções',
            data: @json(array_column($maintenance_data ?? [], 'count')),
            borderColor: 'rgb(239, 68, 68)',
            backgroundColor: 'rgba(239, 68, 68, 0.1)',
            tension: 0.4,
            fill: true,
            pointRadius: 2,
            pointHoverRadius: 4
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
            x: {
                ticks: {
                    font: {
                        size: 10
                    },
                    maxTicksLimit: 15
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    font: {
                        size: 11
                    },
                    stepSize: 1
                }
            }
        }
    }
});
</script>
@endsection 