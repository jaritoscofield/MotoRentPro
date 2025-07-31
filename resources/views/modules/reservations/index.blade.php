@extends('layouts.dashboard')

@section('title', 'Gestão de Reservas - MotoRentPro')
@section('page-title', 'Gestão de Reservas')

@section('content')
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Gestão de Reservas</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Gerencie todas as reservas e agendamentos</p>
            </div>
            <div class="flex flex-wrap gap-2 mt-4 lg:mt-0">
                <a href="/reservas/export" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-download mr-1.5 text-xs"></i>
                    Exportar
                </a>
                <a href="/reservas/create" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md text-xs font-medium text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-plus mr-1.5 text-xs"></i>
                    Nova Reserva
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-day text-blue-600 text-sm"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Reservas Hoje</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['today'] }}</p>
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
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Ativas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['active'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-orange-600 text-sm"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pendentes</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['pending'] }}</p>
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
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Receita Mensal</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">R$ {{ number_format($stats['monthly_revenue'], 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Bar -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 mb-6">
        <form method="GET" action="/reservas" id="filterForm">
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
                               placeholder="Buscar por cliente ou moto...">
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
                        <button type="button" onclick="bulkDelete()" class="p-1.5 text-red-500 hover:text-red-700 rounded">
                            <i class="fas fa-trash text-xs"></i>
                        </button>
                    </div>
                    
                    <!-- Sort Dropdown -->
                    <select name="sort" onchange="this.form.submit()" class="block px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500">
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Mais Recentes</option>
                        <option value="start_date" {{ request('sort') == 'start_date' ? 'selected' : '' }}>Data Início</option>
                        <option value="total_amount" {{ request('sort') == 'total_amount' ? 'selected' : '' }}>Maior Valor</option>
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
                            <option value="">Todos os Status</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date Filter -->
                    <div class="w-40">
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Período</label>
                        <select name="date_filter" class="block w-full px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-xs bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-gray-500">
                            <option value="">Todos</option>
                            <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Hoje</option>
                            <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>Esta Semana</option>
                            <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>Este Mês</option>
                        </select>
                    </div>
                </div>

                <!-- Filter Actions -->
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" onclick="clearFilters()" class="px-3 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-md">
                        Limpar Filtros
                    </button>
                    <button type="submit" class="px-3 py-1.5 text-xs font-medium text-white bg-gray-800 hover:bg-gray-700 rounded-md">
                        Aplicar Filtros
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Reservations Table -->
    <form id="bulkForm" method="POST" action="/reservas/bulk-delete">
        @csrf
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                <input type="checkbox" class="rounded border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 focus:ring-gray-500" onclick="toggleAllCheckboxes(this)">
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Cliente</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Moto</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Período</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Valor Total</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($reservations as $reservation)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-4 whitespace-nowrap">
                                <input type="checkbox" name="selected_reservations[]" value="{{ $reservation->id }}" class="rounded border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 focus:ring-gray-500">
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $reservation->client->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">ID: {{ $reservation->client->id }}</div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $reservation->motorcycle->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $reservation->motorcycle->license_plate }}</div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $reservation->period_text }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $reservation->date_range }}</div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500">Criado em {{ $reservation->formatted_created_at }}</div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $reservation->formatted_total_amount }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                    @if($reservation->status_color == 'green') bg-green-100 text-green-800
                                    @elseif($reservation->status_color == 'blue') bg-blue-100 text-blue-800
                                    @elseif($reservation->status_color == 'orange') bg-orange-100 text-orange-800
                                    @elseif($reservation->status_color == 'red') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $reservation->status }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="/reservas/{{ $reservation->id }}/edit" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="/reservas/{{ $reservation->id }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form method="POST" action="/reservas/{{ $reservation->id }}" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta reserva?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center">
                                <div class="text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-calendar-alt text-4xl text-gray-400 dark:text-gray-500 mb-4"></i>
                                    <p class="text-lg">Nenhuma reserva encontrada</p>
                                    <a href="/reservas/create" class="inline-flex items-center px-3 py-1.5 mt-4 text-xs font-medium text-white bg-gray-800 hover:bg-gray-700 rounded-md">
                                        <i class="fas fa-plus mr-1.5 text-xs"></i>
                                        Adicionar Primeira Reserva
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </form>

    <!-- Pagination -->
    @if($reservations->hasPages())
    <div class="mt-6">
        {{ $reservations->appends(request()->query())->links() }}
    </div>
    @endif
@endsection

@push('scripts')
<script>
    function toggleFilters() {
        const filters = document.getElementById('advancedFilters');
        filters.classList.toggle('hidden');
    }

    function clearFilters() {
        window.location.href = '/reservas';
    }

    function bulkDelete() {
        const checkboxes = document.querySelectorAll('input[name="selected_reservations[]"]:checked');
        if (checkboxes.length === 0) {
            alert('Selecione pelo menos uma reserva para excluir.');
            return;
        }

        if (confirm(`Tem certeza que deseja excluir ${checkboxes.length} reserva(s)?`)) {
            document.getElementById('bulkForm').submit();
        }
    }

    function toggleAllCheckboxes(checkbox) {
        const checkboxes = document.querySelectorAll('input[name="selected_reservations[]"]');
        checkboxes.forEach(cb => cb.checked = checkbox.checked);
    }

    // Auto-submit form when filters change
    document.querySelectorAll('select[name="status"], select[name="date_filter"]').forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
</script>
@endpush 