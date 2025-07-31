@extends('layouts.dashboard')

@section('title', 'Gestão de Clientes - MotoRentPro')
@section('page-title', 'Gestão de Clientes')

@section('content')
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Gestão de Clientes</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Gerencie todos os clientes cadastrados</p>
            </div>
            <div class="flex flex-wrap gap-2 mt-4 lg:mt-0">
                <a href="/clientes/export" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-download mr-1.5 text-xs"></i>
                    Exportar
                </a>
                <a href="/clientes/create" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md text-xs font-medium text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-plus mr-1.5 text-xs"></i>
                    Novo Cliente
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filter Bar -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 mb-6">
        <form method="GET" action="/clientes" id="filterForm">
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
                               placeholder="Buscar por nome, email ou telefone...">
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
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nome A-Z</option>
                        <option value="name" {{ request('sort') == 'name' && request('direction') == 'desc' ? 'selected' : '' }}>Nome Z-A</option>
                        <option value="total_rentals" {{ request('sort') == 'total_rentals' ? 'selected' : '' }}>Mais Aluguéis</option>
                        <option value="total_rentals" {{ request('sort') == 'total_rentals' && request('direction') == 'desc' ? 'selected' : '' }}>Menos Aluguéis</option>
                        <option value="total_spent" {{ request('sort') == 'total_spent' ? 'selected' : '' }}>Maior Gasto</option>
                        <option value="total_spent" {{ request('sort') == 'total_spent' && request('direction') == 'desc' ? 'selected' : '' }}>Menor Gasto</option>
                        <option value="last_rental_date" {{ request('sort') == 'last_rental_date' ? 'selected' : '' }}>Último Aluguel</option>
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
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
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

    <!-- Clients Table -->
    <form id="bulkForm" method="POST" action="/clientes/bulk-delete">
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
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Contato</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">CNH</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aluguéis</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Gasto</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($clients as $client)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-4 whitespace-nowrap">
                                <input type="checkbox" name="selected_clients[]" value="{{ $client->id }}" class="rounded border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 focus:ring-gray-500">
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $client->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Último aluguel: {{ $client->formatted_last_rental_date }}</div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm text-gray-900 dark:text-gray-100">{{ $client->email }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $client->phone }}</div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ $client->cnh }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ $client->total_rentals }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ $client->formatted_total_spent }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                    @if($client->status_color == 'green') bg-green-100 text-green-800
                                    @elseif($client->status_color == 'orange') bg-orange-100 text-orange-800
                                    @elseif($client->status_color == 'red') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $client->status }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="/clientes/{{ $client->id }}/edit" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="/clientes/{{ $client->id }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form method="POST" action="/clientes/{{ $client->id }}" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este cliente?')">
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
                            <td colspan="8" class="px-4 py-8 text-center">
                                <div class="text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-users text-4xl text-gray-400 dark:text-gray-500 mb-4"></i>
                                    <p class="text-lg">Nenhum cliente encontrado</p>
                                    <a href="/clientes/create" class="inline-flex items-center px-3 py-1.5 mt-4 text-xs font-medium text-white bg-gray-800 hover:bg-gray-700 rounded-md">
                                        <i class="fas fa-plus mr-1.5 text-xs"></i>
                                        Adicionar Primeiro Cliente
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
    @if($clients->hasPages())
    <div class="mt-6">
        {{ $clients->appends(request()->query())->links() }}
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
        window.location.href = '/clientes';
    }

    function bulkDelete() {
        const checkboxes = document.querySelectorAll('input[name="selected_clients[]"]:checked');
        if (checkboxes.length === 0) {
            alert('Selecione pelo menos um cliente para excluir.');
            return;
        }

        if (confirm(`Tem certeza que deseja excluir ${checkboxes.length} cliente(s)?`)) {
            document.getElementById('bulkForm').submit();
        }
    }

    function toggleAllCheckboxes(checkbox) {
        const checkboxes = document.querySelectorAll('input[name="selected_clients[]"]');
        checkboxes.forEach(cb => cb.checked = checkbox.checked);
    }

    // Auto-submit form when filters change
    document.querySelectorAll('select[name="status"]').forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
</script>
@endpush 