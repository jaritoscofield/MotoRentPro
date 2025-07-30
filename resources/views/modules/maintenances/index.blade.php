@extends('layouts.dashboard')

@section('title', 'Gestão de Manutenção - MotoRentPro')
@section('page-title', 'Gestão de Manutenção')

@section('content')
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Gestão de Manutenção</h1>
                <p class="text-gray-600 mt-1">Gerencie todas as manutenções da frota</p>
            </div>
            <div class="flex flex-wrap gap-2 mt-4 lg:mt-0">
                <a href="/manutencao/export" class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-download mr-1.5 text-xs"></i>
                    Exportar
                </a>
                <a href="/manutencao/create" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md text-xs font-medium text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-plus mr-1.5 text-xs"></i>
                    Nova Manutenção
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-tools text-blue-600 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-500">Total</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-clock text-orange-600 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-500">Pendentes</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $stats['pending'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-500">Atrasadas</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $stats['overdue'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-500">Custo Total</p>
                    <p class="text-lg font-semibold text-gray-900">R$ {{ number_format($stats['total_cost'], 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Bar -->
    <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
        <form method="GET" action="/manutencao" id="filterForm">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <!-- Search Bar -->
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" 
                               name="search"
                               value="{{ request('search') }}"
                               class="block w-full pl-10 pr-3 py-1.5 border border-gray-300 rounded-md text-xs placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500" 
                               placeholder="Buscar por descrição, técnico ou motocicleta...">
                    </div>
                </div>
                
                <!-- Filters and Controls -->
                <div class="flex items-center gap-3">
                    <!-- Filter Button -->
                    <button type="button" onclick="toggleFilters()" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 rounded-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-filter mr-1.5 text-xs"></i>
                        Filtros
                    </button>
                    
                    <!-- View Options -->
                    <div class="flex items-center bg-gray-100 rounded-md p-0.5">
                        <button type="button" class="p-1.5 text-gray-500 hover:text-gray-700 rounded">
                            <i class="fas fa-cog text-xs"></i>
                        </button>
                        <button type="button" class="p-1.5 text-gray-900 bg-white rounded shadow-sm">
                            <i class="fas fa-th text-xs"></i>
                        </button>
                        <button type="button" class="p-1.5 text-gray-500 hover:text-gray-700 rounded">
                            <i class="fas fa-list text-xs"></i>
                        </button>
                        <button type="button" onclick="bulkDelete()" class="p-1.5 text-red-500 hover:text-red-700 rounded">
                            <i class="fas fa-trash text-xs"></i>
                        </button>
                    </div>
                    
                    <!-- Sort Dropdown -->
                    <select name="sort" onchange="this.form.submit()" class="block px-3 py-1.5 border border-gray-300 rounded-md text-xs bg-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500">
                        <option value="scheduled_date" {{ request('sort') == 'scheduled_date' ? 'selected' : '' }}>Data Agendada ↑</option>
                        <option value="scheduled_date" {{ request('sort') == 'scheduled_date' && request('direction') == 'desc' ? 'selected' : '' }}>Data Agendada ↓</option>
                        <option value="priority" {{ request('sort') == 'priority' ? 'selected' : '' }}>Prioridade</option>
                        <option value="cost" {{ request('sort') == 'cost' ? 'selected' : '' }}>Custo</option>
                    </select>
                </div>
            </div>

            <!-- Advanced Filters (Hidden by default) -->
            <div id="advancedFilters" class="hidden mt-4 pt-4 border-t border-gray-200">
                <div class="flex flex-wrap items-end gap-4">
                    <!-- Status Filter -->
                    <div class="w-40">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="block w-full px-2 py-1 border border-gray-300 rounded text-xs bg-white focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-gray-500">
                            <option value="">Todos</option>
                            <option value="Agendada" {{ request('status') == 'Agendada' ? 'selected' : '' }}>Agendada</option>
                            <option value="Em Andamento" {{ request('status') == 'Em Andamento' ? 'selected' : '' }}>Em Andamento</option>
                            <option value="Concluída" {{ request('status') == 'Concluída' ? 'selected' : '' }}>Concluída</option>
                            <option value="Cancelada" {{ request('status') == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                    </div>

                    <!-- Type Filter -->
                    <div class="w-40">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Tipo</label>
                        <select name="type" class="block w-full px-2 py-1 border border-gray-300 rounded text-xs bg-white focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-gray-500">
                            <option value="">Todos</option>
                            <option value="Preventiva" {{ request('type') == 'Preventiva' ? 'selected' : '' }}>Preventiva</option>
                            <option value="Corretiva" {{ request('type') == 'Corretiva' ? 'selected' : '' }}>Corretiva</option>
                            <option value="Emergencial" {{ request('type') == 'Emergencial' ? 'selected' : '' }}>Emergencial</option>
                            <option value="Inspeção" {{ request('type') == 'Inspeção' ? 'selected' : '' }}>Inspeção</option>
                            <option value="Revisão" {{ request('type') == 'Revisão' ? 'selected' : '' }}>Revisão</option>
                        </select>
                    </div>

                    <!-- Priority Filter -->
                    <div class="w-40">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Prioridade</label>
                        <select name="priority" class="block w-full px-2 py-1 border border-gray-300 rounded text-xs bg-white focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-gray-500">
                            <option value="">Todas</option>
                            <option value="Baixa" {{ request('priority') == 'Baixa' ? 'selected' : '' }}>Baixa</option>
                            <option value="Média" {{ request('priority') == 'Média' ? 'selected' : '' }}>Média</option>
                            <option value="Alta" {{ request('priority') == 'Alta' ? 'selected' : '' }}>Alta</option>
                            <option value="Crítica" {{ request('priority') == 'Crítica' ? 'selected' : '' }}>Crítica</option>
                        </select>
                    </div>

                    <!-- Date Range -->
                    <div class="w-40">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Data de</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" 
                               class="block w-full px-2 py-1 border border-gray-300 rounded text-xs bg-white focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-gray-500">
                    </div>

                    <div class="w-40">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Data até</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" 
                               class="block w-full px-2 py-1 border border-gray-300 rounded text-xs bg-white focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-gray-500">
                    </div>
                </div>

                <!-- Filter Actions -->
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" onclick="clearFilters()" class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        Limpar Filtros
                    </button>
                    <button type="submit" class="px-3 py-1.5 text-xs font-medium text-white bg-gray-800 hover:bg-gray-700 rounded-md">
                        Aplicar Filtros
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Bulk Actions -->
    <div class="bg-white rounded-lg border border-gray-200 mb-6">
        <div class="px-4 py-3 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <input type="checkbox" id="selectAll" onchange="toggleAllCheckboxes()" class="rounded border-gray-300 text-gray-600 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50">
                    <label for="selectAll" class="text-sm font-medium text-gray-700">Selecionar Todos</label>
                </div>
                <button onclick="bulkDelete()" id="bulkDeleteBtn" class="hidden inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <i class="fas fa-trash mr-1.5 text-xs"></i>
                    Excluir Selecionados
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" class="rounded border-gray-300 text-gray-600 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50">
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motocicleta</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descrição</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Agendada</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioridade</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Custo</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Técnico</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($maintenances as $maintenance)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap">
                            <input type="checkbox" name="selected[]" value="{{ $maintenance->id }}" class="maintenance-checkbox rounded border-gray-300 text-gray-600 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50">
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $maintenance->motorcycle->name }}</div>
                                <div class="text-xs text-gray-500">{{ $maintenance->motorcycle->license_plate }}</div>
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <i class="{{ $maintenance->type_icon }} text-gray-400 mr-2 text-xs"></i>
                                <span class="text-sm text-gray-900">{{ $maintenance->type }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $maintenance->description }}">
                                {{ $maintenance->description }}
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $maintenance->formatted_scheduled_date }}</div>
                            @if($maintenance->is_overdue)
                                <div class="text-xs text-red-600">Atrasada</div>
                            @elseif($maintenance->is_upcoming)
                                <div class="text-xs text-blue-600">Próxima</div>
                            @endif
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $maintenance->status_color }}-100 text-{{ $maintenance->status_color }}-800">
                                {{ $maintenance->status }}
                            </span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $maintenance->priority_color }}-100 text-{{ $maintenance->priority_color }}-800">
                                {{ $maintenance->priority }}
                            </span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $maintenance->formatted_cost }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $maintenance->technician ?? '-' }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="/manutencao/{{ $maintenance->id }}/edit" class="text-gray-600 hover:text-gray-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="/manutencao/{{ $maintenance->id }}" class="text-gray-600 hover:text-gray-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form method="POST" action="/manutencao/{{ $maintenance->id }}" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta manutenção?')">
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
                        <td colspan="10" class="px-4 py-8 text-center text-gray-500">
                            <i class="fas fa-tools text-4xl mb-4 block"></i>
                            <p class="text-lg font-medium">Nenhuma manutenção encontrada</p>
                            <p class="text-sm">Crie sua primeira manutenção para começar.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($maintenances->hasPages())
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $maintenances->appends(request()->query())->links() }}
        </div>
        @endif
    </div>



<script>
function toggleFilters() {
    const filters = document.getElementById('advancedFilters');
    filters.classList.toggle('hidden');
}

function clearFilters() {
    window.location.href = '/manutencao';
}

function toggleAllCheckboxes() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.maintenance-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
    
    updateBulkDeleteButton();
}

function updateBulkDeleteButton() {
    const checkboxes = document.querySelectorAll('.maintenance-checkbox:checked');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    
    if (checkboxes.length > 0) {
        bulkDeleteBtn.classList.remove('hidden');
    } else {
        bulkDeleteBtn.classList.add('hidden');
    }
}

function bulkDelete() {
    const checkboxes = document.querySelectorAll('.maintenance-checkbox:checked');
    const ids = Array.from(checkboxes).map(cb => cb.value);
    
    if (ids.length === 0) return;
    
    if (confirm(`Tem certeza que deseja excluir ${ids.length} manutenção(ões)?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/manutencao/bulk-delete';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfToken);
        
        ids.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = id;
            form.appendChild(input);
        });
        
        document.body.appendChild(form);
        form.submit();
    }
}



// Add event listeners for checkboxes
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.maintenance-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkDeleteButton);
    });
});
</script>
@endsection 