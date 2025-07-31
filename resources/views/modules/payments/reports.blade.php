@extends('layouts.dashboard')

@section('title', 'Relatórios de Pagamentos - MotoRentPro')
@section('page-title', 'Relatórios de Pagamentos')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Relatórios de Pagamentos</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Análise detalhada de vendas e receitas</p>
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
        <form method="GET" action="/pagamentos/reports" id="reportForm">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Período</label>
                    <select name="period" onchange="this.form.submit()" class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="30" {{ request('period', 30) == 30 ? 'selected' : '' }}>Últimos 30 dias</option>
                        <option value="90" {{ request('period', 30) == 90 ? 'selected' : '' }}>Últimos 90 dias</option>
                        <option value="180" {{ request('period', 30) == 180 ? 'selected' : '' }}>Últimos 6 meses</option>
                        <option value="365" {{ request('period', 30) == 365 ? 'selected' : '' }}>Último ano</option>
                        <option value="custom" {{ request('period') == 'custom' ? 'selected' : '' }}>Personalizado</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo</label>
                    <select name="sale_type" onchange="this.form.submit()" class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="">Todos</option>
                        <option value="venda" {{ request('sale_type') == 'venda' ? 'selected' : '' }}>Vendas</option>
                        <option value="aluguel" {{ request('sale_type') == 'aluguel' ? 'selected' : '' }}>Aluguéis</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select name="status" onchange="this.form.submit()" class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="">Todos</option>
                        <option value="ativa" {{ request('status') == 'ativa' ? 'selected' : '' }}>Ativas</option>
                        <option value="concluida" {{ request('status') == 'concluida' ? 'selected' : '' }}>Concluídas</option>
                        <option value="cancelada" {{ request('status') == 'cancelada' ? 'selected' : '' }}>Canceladas</option>
                        <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendentes</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Método</label>
                    <select name="payment_method" onchange="this.form.submit()" class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="">Todos</option>
                        <option value="dinheiro" {{ request('payment_method') == 'dinheiro' ? 'selected' : '' }}>Dinheiro</option>
                        <option value="cartao_credito" {{ request('payment_method') == 'cartao_credito' ? 'selected' : '' }}>Cartão de Crédito</option>
                        <option value="cartao_debito" {{ request('payment_method') == 'cartao_debito' ? 'selected' : '' }}>Cartão de Débito</option>
                        <option value="pix" {{ request('payment_method') == 'pix' ? 'selected' : '' }}>PIX</option>
                        <option value="transferencia" {{ request('payment_method') == 'transferencia' ? 'selected' : '' }}>Transferência</option>
                    </select>
                </div>
            </div>
        </form>
    </div>

    <!-- Main Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Revenue -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Receita Total</p>
                    <p class="text-2xl font-bold">R$ {{ number_format($stats['total_revenue'], 2, ',', '.') }}</p>
                    <p class="text-xs opacity-75 mt-1">{{ $stats['total_sales'] }} vendas</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Received Amount -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Recebido</p>
                    <p class="text-2xl font-bold">R$ {{ number_format($stats['total_received'], 2, ',', '.') }}</p>
                    <p class="text-xs opacity-75 mt-1">{{ $stats['completed_sales'] }} concluídas</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending Amount -->
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Pendente</p>
                    <p class="text-2xl font-bold">R$ {{ number_format($stats['pending_amount'], 2, ',', '.') }}</p>
                    <p class="text-xs opacity-75 mt-1">{{ $stats['active_sales'] }} ativas</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Overdue Amount -->
        <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Em Atraso</p>
                    <p class="text-2xl font-bold">R$ {{ number_format($stats['overdue_amount'], 2, ',', '.') }}</p>
                    <p class="text-xs opacity-75 mt-1">{{ $stats['overdue_sales'] }} atrasadas</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Revenue Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Receita por Mês</h3>
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Receita</span>
                </div>
            </div>
            <div class="h-64">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Sales Type Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Vendas por Tipo</h3>
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Vendas</span>
                    <span class="w-3 h-3 bg-purple-500 rounded-full ml-2"></span>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Aluguéis</span>
                </div>
            </div>
            <div class="h-64">
                <canvas id="salesTypeChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Detailed Statistics -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Payment Methods -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Métodos de Pagamento</h3>
            <div class="space-y-3">
                @foreach($paymentMethodsStats as $method => $data)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full mr-3" style="background-color: {{ $data['color'] }}"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $data['label'] }}</span>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $data['count'] }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $data['percentage'] }}%</div>
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
                        <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-gray-600 dark:text-gray-400 text-xs"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $client->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $client->total_sales }} vendas</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">R$ {{ number_format($client->total_amount, 2, ',', '.') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Top Motorcycles -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Top Motocicletas</h3>
            <div class="space-y-3">
                @foreach($topMotorcycles as $motorcycle)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-motorcycle text-gray-600 dark:text-gray-400 text-xs"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $motorcycle->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $motorcycle->total_sales }} vendas</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">R$ {{ number_format($motorcycle->total_amount, 2, ',', '.') }}</div>
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
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Motocicleta</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Valor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Data</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($recentActivity as $payment)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $payment->client->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $payment->client->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-gray-100">{{ $payment->motorcycle->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $payment->motorcycle->license_plate }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300">
                                <i class="{{ $payment->sale_type_icon }} mr-1 text-xs"></i>
                                {{ ucfirst($payment->sale_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            {{ $payment->formatted_total_amount }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $payment->status_color }}-100 dark:bg-{{ $payment->status_color }}-900/40 text-{{ $payment->status_color }}-800 dark:text-{{ $payment->status_color }}-300">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $payment->formatted_sale_date }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
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

    // Sales Type Chart
    const salesTypeCtx = document.getElementById('salesTypeChart').getContext('2d');
    new Chart(salesTypeCtx, {
        type: 'doughnut',
        data: {
            labels: ['Vendas', 'Aluguéis'],
            datasets: [{
                data: [
                    {{ $stats['venda_count'] }},
                    {{ $stats['aluguel_count'] }}
                ],
                backgroundColor: ['#10B981', '#8B5CF6'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
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