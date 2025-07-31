@extends('layouts.dashboard')

@section('title', 'Gestão de Pagamentos - MotoRentPro')
@section('page-title', 'Gestão de Pagamentos')

@section('content')
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Gestão de Pagamentos</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Sistema completo de vendas e controle financeiro</p>
            </div>
            <div class="flex flex-wrap gap-2 mt-4 lg:mt-0">
                <a href="/pagamentos/export" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-download mr-1.5 text-xs"></i>
                    Exportar
                </a>
                <a href="/pagamentos/create" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md text-xs font-medium text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-plus mr-1.5 text-xs"></i>
                    Nova Venda
                </a>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button onclick="showTab('vendas')" id="tab-vendas" class="tab-button border-b-2 border-gray-800 dark:border-gray-200 py-2 px-1 text-sm font-medium text-gray-800 dark:text-gray-200">
                <i class="fas fa-shopping-cart mr-2"></i>
                Vendas
            </button>
            <button onclick="showTab('vendas-semanais')" id="tab-vendas-semanais" class="tab-button border-b-2 border-transparent py-2 px-1 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                <i class="fas fa-calendar-week mr-2"></i>
                Vendas Semanais
            </button>
            <button onclick="showTab('pagamentos')" id="tab-pagamentos" class="tab-button border-b-2 border-transparent py-2 px-1 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                <i class="fas fa-credit-card mr-2"></i>
                Pagamentos
            </button>
            <button onclick="showTab('carnes')" id="tab-carnes" class="tab-button border-b-2 border-transparent py-2 px-1 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                <i class="fas fa-book mr-2"></i>
                Carnês
            </button>
            <button onclick="showTab('relatorios')" id="tab-relatorios" class="tab-button border-b-2 border-transparent py-2 px-1 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                <i class="fas fa-chart-bar mr-2"></i>
                Relatórios
            </button>
        </nav>
    </div>

    <!-- Tab Content -->
    <div id="tab-content">
        <!-- Vendas Tab -->
        <div id="content-vendas" class="tab-content">
            <!-- Search and Filter Bar -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 mb-6">
                <form method="GET" action="/pagamentos" id="filterForm">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <!-- Search Bar -->
                        <div class="flex-1">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400 dark:text-gray-500"></i>
                                </div>
                                <input type="text" 
                                       name="search"
                                       value="{{ request('search') }}"
                                       class="block w-full pl-10 pr-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" 
                                       placeholder="Buscar por cliente, motocicleta...">
                            </div>
                        </div>
                        
                        <!-- Filters and Controls -->
                        <div class="flex items-center gap-3">
                            <!-- Filter Button -->
                            <button type="button" onclick="toggleFilters()" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fas fa-filter mr-1.5 text-xs"></i>
                                Filtros
                            </button>
                            
                            <!-- View Options -->
                            <div class="flex items-center bg-gray-100 dark:bg-gray-700 rounded-md p-0.5">
                                <button type="button" class="p-1.5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 rounded">
                                    <i class="fas fa-cog text-xs"></i>
                                </button>
                                <button type="button" class="p-1.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-600 rounded shadow-sm">
                                    <i class="fas fa-th text-xs"></i>
                                </button>
                                <button type="button" class="p-1.5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 rounded">
                                    <i class="fas fa-list text-xs"></i>
                                </button>
                            </div>
                            
                            <!-- Sort Dropdown -->
                            <select name="sort" onchange="this.form.submit()" class="block px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500">
                                <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Mais Recentes</option>
                                <option value="sale_date" {{ request('sort') == 'sale_date' ? 'selected' : '' }}>Data da Venda</option>
                                <option value="total_amount" {{ request('sort') == 'total_amount' ? 'selected' : '' }}>Valor</option>
                                <option value="status" {{ request('sort') == 'status' ? 'selected' : '' }}>Status</option>
                            </select>
                        </div>
                    </div>

                    <!-- Advanced Filters (Hidden by default) -->
                    <div id="advancedFilters" class="hidden mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex flex-wrap items-end gap-4">
                            <!-- Status Filter -->
                            <div class="w-40">
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                                <select name="status" class="block w-full px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-xs bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-gray-500">
                                    <option value="">Todos</option>
                                    <option value="ativa" {{ request('status') == 'ativa' ? 'selected' : '' }}>Ativa</option>
                                    <option value="concluida" {{ request('status') == 'concluida' ? 'selected' : '' }}>Concluída</option>
                                    <option value="cancelada" {{ request('status') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                    <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                                </select>
                            </div>

                            <!-- Sale Type Filter -->
                            <div class="w-40">
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo</label>
                                <select name="sale_type" class="block w-full px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-xs bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-gray-500">
                                    <option value="">Todos</option>
                                    <option value="venda" {{ request('sale_type') == 'venda' ? 'selected' : '' }}>Venda</option>
                                    <option value="aluguel" {{ request('sale_type') == 'aluguel' ? 'selected' : '' }}>Aluguel</option>
                                </select>
                            </div>

                            <!-- Periodicity Filter -->
                            <div class="w-40">
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Periodicidade</label>
                                <select name="periodicity" class="block w-full px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-xs bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-gray-500">
                                    <option value="">Todas</option>
                                    <option value="semanal" {{ request('periodicity') == 'semanal' ? 'selected' : '' }}>Semanal</option>
                                    <option value="mensal" {{ request('periodicity') == 'mensal' ? 'selected' : '' }}>Mensal</option>
                                </select>
                            </div>

                            <!-- Date From -->
                            <div class="w-40">
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Data Inicial</label>
                                <input type="date" name="date_from" value="{{ request('date_from') }}" 
                                       class="block w-full px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-xs bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-gray-500">
                            </div>

                            <!-- Date To -->
                            <div class="w-40">
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Data Final</label>
                                <input type="date" name="date_to" value="{{ request('date_to') }}" 
                                       class="block w-full px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-xs bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-gray-500">
                            </div>

                            <!-- Filter Actions -->
                            <div class="flex items-center gap-2">
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md text-xs font-medium text-white bg-gray-800 dark:bg-gray-700 hover:bg-gray-700 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    <i class="fas fa-search mr-1.5 text-xs"></i>
                                    Aplicar
                                </button>
                                <a href="/pagamentos" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    Limpar
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($payments as $payment)
                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $payment->motorcycle->name }}</h3>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-{{ $payment->status_color }}-100 dark:bg-{{ $payment->status_color }}-900/40 text-{{ $payment->status_color }}-800 dark:text-{{ $payment->status_color }}-300">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>
                    
                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Valor Total:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $payment->formatted_total_amount }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Entrada:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $payment->formatted_down_payment }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Pago:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $payment->formatted_paid_amount }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Restante:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $payment->formatted_remaining_amount }}</span>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-500 dark:text-gray-400">Progresso do Pagamento</span>
                            <span class="font-medium text-gray-900 dark:text-gray-100">{{ $payment->progress_percentage }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                            <div class="bg-blue-600 dark:bg-blue-500 h-2 rounded-full" style="width: {{ $payment->progress_percentage }}%"></div>
                        </div>
                    </div>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Parcelas:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $payment->installments }}x de {{ $payment->formatted_installment_amount }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Periodicidade:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ ucfirst($payment->periodicity) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Vendedor:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $payment->user->name ?? 'Admin' }}</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between">
                        <a href="/pagamentos/{{ $payment->id }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                            <i class="fas fa-eye mr-1"></i>
                            Ver Detalhes
                        </a>
                        <a href="/pagamentos/{{ $payment->id }}/carnet" class="text-sm text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300">
                            <i class="fas fa-book mr-1"></i>
                            Ver Carnê
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Vendas Semanais Tab -->
        <div id="content-vendas-semanais" class="tab-content hidden">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar-week text-blue-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Vendas Ativas</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $weeklySalesCount }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-dollar-sign text-green-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Receita Semanal</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">R$ {{ number_format($weeklyRevenue, 2, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pago</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">R$ {{ number_format($weeklyPaid, 2, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-clock text-yellow-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pendente</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">R$ {{ number_format($weeklyPending, 2, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Header Section -->
            <div class="mb-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Vendas Semanais</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Gestão especializada para vendas com pagamento semanal</p>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-4 lg:mt-0">
                        <a href="/pagamentos/create?type=semanal" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md text-xs font-medium text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <i class="fas fa-plus mr-1.5 text-xs"></i>
                            Nova Venda Semanal
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 mb-6">
                <div class="flex items-center justify-between">
                    <div class="relative flex-1 max-w-md">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400 dark:text-gray-500"></i>
                        </div>
                        <input type="text" placeholder="Buscar vendas semanais..." class="block w-full pl-10 pr-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    </div>
                    <button class="ml-4 px-2.5 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <i class="fas fa-filter mr-1.5 text-xs"></i>
                        Filtros
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($payments->where('periodicity', 'semanal') as $payment)
                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $payment->client->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Semanal</p>
                        </div>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-{{ $payment->status_color }}-100 dark:bg-{{ $payment->status_color }}-900/40 text-{{ $payment->status_color }}-800 dark:text-{{ $payment->status_color }}-300">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>
                    
                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Valor Total:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $payment->formatted_total_amount }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Parcela Semanal:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $payment->formatted_installment_amount }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Pago:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $payment->formatted_paid_amount }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Restante:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $payment->formatted_remaining_amount }}</span>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-500 dark:text-gray-400">Progresso do Pagamento</span>
                            <span class="font-medium text-gray-900 dark:text-gray-100">{{ $payment->progress_percentage }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                            <div class="bg-blue-600 dark:bg-blue-500 h-2 rounded-full" style="width: {{ $payment->progress_percentage }}%"></div>
                        </div>
                    </div>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Semanas:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $payment->installments }} semanas</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Início:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $payment->formatted_sale_date }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Vendedor:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $payment->user->name ?? 'Admin' }}</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between">
                        <a href="/pagamentos/{{ $payment->id }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                            <i class="fas fa-eye mr-1"></i>
                            Ver Detalhes
                        </a>
                        <a href="/pagamentos/{{ $payment->id }}/cronograma" class="text-sm text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300">
                            <i class="fas fa-calendar mr-1"></i>
                            Ver Cronograma
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Pagamentos Tab -->
        <div id="content-pagamentos" class="tab-content hidden">
            <!-- Header Section -->
            <div class="mb-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Controle de Pagamentos</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Gerencie todos os pagamentos e parcelas</p>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-4 lg:mt-0">
                        <a href="{{ route('payments.installment.register') }}" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md text-xs font-medium text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <i class="fas fa-plus mr-1.5 text-xs"></i>
                            Registrar Pagamento
                        </a>
                    </div>
                </div>
            </div>

            <!-- Search and Filter Bar -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 mb-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <!-- Search Bar -->
                    <div class="flex-1">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400 dark:text-gray-500"></i>
                            </div>
                            <input type="text" 
                                   id="search"
                                   name="search"
                                   value="{{ request('search') }}"
                                   class="block w-full pl-10 pr-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" 
                                   placeholder="Buscar por cliente, motocicleta, parcela...">
                        </div>
                    </div>
                    
                    <!-- Filters and Controls -->
                    <div class="flex items-center gap-3">
                        <!-- Filter Button -->
                        <button type="button" onclick="togglePagamentosFilters()" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <i class="fas fa-filter mr-1.5 text-xs"></i>
                            Filtros
                        </button>
                    </div>
                </div>

                <!-- Advanced Filters (Hidden by default) -->
                <div id="pagamentosAdvancedFilters" class="hidden mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex flex-wrap items-end gap-4">
                        <!-- Status Filter -->
                        <div class="w-40">
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                            <select id="status" name="status" class="block w-full px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-xs bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-gray-500">
                                <option value="">Todos</option>
                                <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                                <option value="pago" {{ request('status') == 'pago' ? 'selected' : '' }}>Pago</option>
                                <option value="vencido" {{ request('status') == 'vencido' ? 'selected' : '' }}>Vencido</option>
                            </select>
                        </div>

                        <!-- Date From -->
                        <div class="w-40">
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Vencimento - De</label>
                            <input type="date" id="due_date_from" name="due_date_from" value="{{ request('due_date_from') }}" 
                                   class="block w-full px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-xs bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-gray-500">
                        </div>

                        <!-- Date To -->
                        <div class="w-40">
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Vencimento - Até</label>
                            <input type="date" id="due_date_to" name="due_date_to" value="{{ request('due_date_to') }}" 
                                   class="block w-full px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-xs bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-gray-500">
                        </div>

                        <!-- Amount From -->
                        <div class="w-40">
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Valor - De</label>
                            <input type="number" id="amount_from" name="amount_from" value="{{ request('amount_from') }}" 
                                   step="0.01" min="0" placeholder="0,00"
                                   class="block w-full px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-xs bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-gray-500">
                        </div>

                        <!-- Amount To -->
                        <div class="w-40">
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Valor - Até</label>
                            <input type="number" id="amount_to" name="amount_to" value="{{ request('amount_to') }}" 
                                   step="0.01" min="0" placeholder="0,00"
                                   class="block w-full px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-xs bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-gray-500">
                        </div>

                        <!-- Filter Actions -->
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="applyFilters()" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md text-xs font-medium text-white bg-gray-800 dark:bg-gray-700 hover:bg-gray-700 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <i class="fas fa-search mr-1.5 text-xs"></i>
                                Aplicar
                            </button>
                            <button type="button" onclick="clearFilters()" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <i class="fas fa-times mr-1.5 text-xs"></i>
                                Limpar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                <!-- Resultados -->
                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $paymentInstallments->count() }} parcela(s) encontrada(s)
                        </div>
                        @if(request('search') || request('status') || request('due_date_from') || request('due_date_to') || request('amount_from') || request('amount_to'))
                            <div class="text-xs text-gray-400 dark:text-gray-500">
                                Filtros ativos
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Cliente</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Parcela</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Vencimento</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Valor</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($paymentInstallments ?? [] as $installment)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $installment->payment->client->name ?? ($installment->payment ? 'Cliente não encontrado' : 'Pagamento não encontrado') }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $installment->payment->motorcycle->name ?? ($installment->payment ? 'Moto não encontrada' : '') }}</div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $installment->installment_number ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm text-gray-900 dark:text-gray-100">{{ $installment->formatted_due_date ?? 'Data não definida' }}</div>
                                        @if($installment->payment && $installment->payment->periodicity == 'semanal')
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Domingo</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $installment->formatted_amount ?? 'R$ 0,00' }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                        @if($installment->status == 'pago') bg-green-100 text-green-800
                                        @elseif($installment->status == 'vencido') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($installment->status ?? 'pendente') }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        @if(($installment->status ?? 'pendente') == 'pendente')
                                        <button class="text-green-600 hover:text-green-900 dark:hover:text-green-400">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        @endif
                                        <button class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center">
                                    <div class="text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-credit-card text-4xl text-gray-400 dark:text-gray-500 mb-4"></i>
                                        <p class="text-lg">Nenhum pagamento encontrado</p>
                                         <a href="{{ route('payments.installment.register') }}" class="inline-flex items-center px-3 py-1.5 mt-4 border border-transparent rounded-md text-xs font-medium text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                             <i class="fas fa-plus mr-1.5 text-xs"></i>
                                             Registrar Primeiro Pagamento
                                         </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Carnês Tab -->
        <div id="content-carnes" class="tab-content hidden">
            <!-- Header Section -->
            <div class="mb-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Cronograma de Pagamento</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Maria Silva - Honda CB 600F</p>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-4 lg:mt-0">
                        <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <i class="fas fa-envelope mr-1.5 text-xs"></i>
                            Enviar por Email
                        </button>
                        <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <i class="fas fa-download mr-1.5 text-xs"></i>
                            Baixar PDF
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2">
                        <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">Cronograma de Pagamentos</h4>
                        <div class="space-y-3">
                            @for($i = 1; $i <= 10; $i++)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/40 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-medium text-blue-600 dark:text-blue-400">{{ $i }}</span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Parcela {{ $i }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            Vencimento: {{ date('d/m/Y', strtotime("+{$i} month")) }}
                                            @if($i <= 2)
                                                <br>Pago em: {{ date('d/m/Y', strtotime("+{$i} month -1 day")) }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">R$ 2.000,00</div>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $i <= 2 ? 'bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300' : ($i == 3 ? 'bg-red-100 dark:bg-red-900/40 text-red-800 dark:text-red-300' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300') }}">
                                        {{ $i <= 2 ? 'Pago' : ($i == 3 ? 'Vencido' : 'Pendente') }}
                                    </span>
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>

                    <div>
                        <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">Resumo da Venda</h4>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 space-y-3">
                            <div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Cliente:</div>
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Maria Silva</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">CPF:</div>
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">123.456.789-00</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Telefone:</div>
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">(11) 99999-9999</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Moto:</div>
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Honda CB 600F</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Placa:</div>
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">ABC-1234</div>
                            </div>
                            <hr class="border-gray-200 dark:border-gray-600">
                            <div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Valor Total:</div>
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">R$ 25.000,00</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Entrada:</div>
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">R$ 5.000,00</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Financiado:</div>
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">R$ 20.000,00</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Parcelas:</div>
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">10x</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Valor da Parcela:</div>
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">R$ 2.000,00</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Relatórios Tab -->
        <div id="content-relatorios" class="tab-content hidden">
            <!-- Header Section -->
            <div class="mb-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Relatórios</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Análise completa do desempenho financeiro</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Resumo Financeiro -->
                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Resumo Financeiro</h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                            <div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Receita Recebida</div>
                                <div class="text-lg font-semibold text-green-600 dark:text-green-400">R$ {{ number_format($stats['total_received'] ?? 6750, 2, ',', '.') }}</div>
                            </div>
                            <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
                        </div>
                        
                        <div class="flex justify-between items-center p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                            <div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Receita Pendente</div>
                                <div class="text-lg font-semibold text-yellow-600 dark:text-yellow-400">R$ {{ number_format($stats['pending_amount'] ?? 500, 2, ',', '.') }}</div>
                            </div>
                            <i class="fas fa-clock text-yellow-600 dark:text-yellow-400 text-xl"></i>
                        </div>
                        
                        <div class="flex justify-between items-center p-3 bg-red-50 dark:bg-red-900/20 rounded-lg">
                            <div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Receita em Atraso</div>
                                <div class="text-lg font-semibold text-red-600 dark:text-red-400">R$ {{ number_format($stats['overdue_amount'] ?? 2000, 2, ',', '.') }}</div>
                            </div>
                            <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 text-xl"></i>
                        </div>
                        
                        <div class="flex justify-between items-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Vendas Semanais</div>
                                <div class="text-lg font-semibold text-blue-600 dark:text-blue-400">R$ {{ number_format($weeklyRevenue ?? 20000, 2, ',', '.') }}</div>
                            </div>
                            <i class="fas fa-calendar-week text-blue-600 dark:text-blue-400 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Performance de Vendas -->
                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Performance de Vendas</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">85%</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Taxa de Conversão</div>
                        </div>
                        
                        <div class="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">R$ 16.082,67</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Ticket Médio</div>
                        </div>
                        
                        <div class="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="text-2xl font-bold text-red-600 dark:text-red-400">2.1%</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Taxa de Inadimplência</div>
                        </div>
                        
                        <div class="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">16.7%</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Vendas Concluídas</div>
                        </div>
                        
                        <div class="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg col-span-2">
                            <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">33.3%</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">% Vendas Semanais</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active state from all tab buttons
    const tabButtons = document.querySelectorAll('.tab-button');
    tabButtons.forEach(button => {
        button.classList.remove('border-gray-800', 'dark:border-gray-200', 'text-gray-800', 'dark:text-gray-200');
        button.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
    });
    
    // Show selected tab content
    const selectedContent = document.getElementById('content-' + tabName);
    if (selectedContent) {
        selectedContent.classList.remove('hidden');
    }
    
    // Add active state to selected tab button
    const selectedButton = document.getElementById('tab-' + tabName);
    if (selectedButton) {
        selectedButton.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
        selectedButton.classList.add('border-gray-800', 'dark:border-gray-200', 'text-gray-800', 'dark:text-gray-200');
    }
}

function toggleFilters() {
    const filters = document.getElementById('advancedFilters');
    filters.classList.toggle('hidden');
}

function togglePagamentosFilters() {
    const filters = document.getElementById('pagamentosAdvancedFilters');
    filters.classList.toggle('hidden');
}

// Funções para filtros da aba Pagamentos
function applyFilters() {
    const search = document.getElementById('search').value;
    const status = document.getElementById('status').value;
    const dueDateFrom = document.getElementById('due_date_from').value;
    const dueDateTo = document.getElementById('due_date_to').value;
    const amountFrom = document.getElementById('amount_from').value;
    const amountTo = document.getElementById('amount_to').value;

    // Construir URL com parâmetros
    const params = new URLSearchParams();
    if (search) params.append('search', search);
    if (status) params.append('status', status);
    if (dueDateFrom) params.append('due_date_from', dueDateFrom);
    if (dueDateTo) params.append('due_date_to', dueDateTo);
    if (amountFrom) params.append('amount_from', amountFrom);
    if (amountTo) params.append('amount_to', amountTo);
    
    // Preservar a aba atual
    params.append('tab', 'pagamentos');

    // Redirecionar para a mesma página com os filtros
    const currentUrl = window.location.pathname;
    const newUrl = params.toString() ? `${currentUrl}?${params.toString()}` : currentUrl;
    window.location.href = newUrl;
}

function clearFilters() {
    // Limpar todos os campos de filtro
    document.getElementById('search').value = '';
    document.getElementById('status').value = '';
    document.getElementById('due_date_from').value = '';
    document.getElementById('due_date_to').value = '';
    document.getElementById('amount_from').value = '';
    document.getElementById('amount_to').value = '';

    // Redirecionar para a página sem filtros, mas preservando a aba
    window.location.href = window.location.pathname + '?tab=pagamentos';
}

// Initialize with first tab active
document.addEventListener('DOMContentLoaded', function() {
    // Check if there's a specific tab in URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get('tab');
    
    // If no specific tab is requested, default to 'vendas'
    showTab(activeTab || 'vendas');
});
</script>
@endsection 