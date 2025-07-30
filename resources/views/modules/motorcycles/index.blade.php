@extends('layouts.dashboard')

@section('title', 'Gestão de Frota - MotoRentPro')
@section('page-title', 'Gestão de Frota')

@section('content')
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Gestão de Frota</h1>
                <p class="text-gray-600 mt-1">Controle completo da sua frota de motos</p>
            </div>
            <div class="flex flex-wrap gap-2 mt-4 lg:mt-0">
                <a href="{{ route('motorcycles.export') }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-download mr-1.5 text-xs"></i>
                    Exportar
                </a>
                <a href="{{ route('motorcycles.create') }}" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md text-xs font-medium text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-plus mr-1.5 text-xs"></i>
                    Nova Moto
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filter Bar -->
    <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
        <form method="GET" action="{{ route('motorcycles.index') }}" id="filterForm">
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
                               placeholder="Buscar por modelo, marca, placa ou tags...">
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
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Modelo A-Z</option>
                        <option value="name" {{ request('sort') == 'name' && request('direction') == 'desc' ? 'selected' : '' }}>Modelo Z-A</option>
                        <option value="daily_rate" {{ request('sort') == 'daily_rate' ? 'selected' : '' }}>Preço Menor</option>
                        <option value="daily_rate" {{ request('sort') == 'daily_rate' && request('direction') == 'desc' ? 'selected' : '' }}>Preço Maior</option>
                        <option value="year" {{ request('sort') == 'year' ? 'selected' : '' }}>Mais Recentes</option>
                        <option value="year" {{ request('sort') == 'year' && request('direction') == 'desc' ? 'selected' : '' }}>Mais Antigos</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Melhor Avaliação</option>
                    </select>
                </div>
            </div>

            <!-- Advanced Filters (Hidden by default) -->
            <div id="advancedFilters" class="hidden mt-4 pt-4 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                    <!-- Status Filter -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="block w-full px-2 py-1 border border-gray-300 rounded text-xs bg-white focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-gray-500">
                            <option value="">Todos</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Categoria</label>
                        <select name="category" class="block w-full px-2 py-1 border border-gray-300 rounded text-xs bg-white focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-gray-500">
                            <option value="">Todas</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Fuel Filter -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Combustível</label>
                        <select name="fuel" class="block w-full px-2 py-1 border border-gray-300 rounded text-xs bg-white focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-gray-500">
                            <option value="">Todos</option>
                            @foreach($fuels as $fuel)
                                <option value="{{ $fuel }}" {{ request('fuel') == $fuel ? 'selected' : '' }}>{{ $fuel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Faixa de Preço</label>
                        <div class="flex gap-1">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="flex-1 px-2 py-1 border border-gray-300 rounded text-xs focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-gray-500">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="flex-1 px-2 py-1 border border-gray-300 rounded text-xs focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-gray-500">
                        </div>
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

    <!-- Motorcycle Cards Grid -->
    <form id="bulkForm" method="POST" action="{{ route('motorcycles.bulk-delete') }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($motorcycles as $motorcycle)
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <!-- Card Header -->
                <div class="relative p-4">
                    <!-- Checkbox -->
                    <div class="absolute top-4 right-4">
                        <input type="checkbox" name="selected_motorcycles[]" value="{{ $motorcycle->id }}" class="rounded border-gray-300 text-gray-600 focus:ring-gray-500">
                    </div>
                    
                    <!-- Status Tag -->
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                            @if($motorcycle->status_color == 'green') bg-green-100 text-green-800
                            @elseif($motorcycle->status_color == 'orange') bg-orange-100 text-orange-800
                            @elseif($motorcycle->status_color == 'blue') bg-blue-100 text-blue-800
                            @elseif($motorcycle->status_color == 'red') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ $motorcycle->status }}
                        </span>
                    </div>
                    
                    <!-- Image -->
                    <div class="flex justify-center items-center h-32 bg-gray-100 rounded-lg mb-3">
                        @if($motorcycle->image)
                            <img src="{{ Storage::url($motorcycle->image) }}" alt="{{ $motorcycle->name }}" class="h-full w-full object-cover rounded-lg">
                        @else
                            <i class="fas fa-camera text-3xl text-gray-400"></i>
                        @endif
                    </div>
                    
                    <!-- Rating and QR Code -->
                    <div class="flex justify-between items-center mb-3">
                        <div class="flex items-center">
                            <i class="fas fa-star text-yellow-400 text-sm mr-1"></i>
                            <span class="text-sm font-medium text-gray-900">{{ $motorcycle->rating }}</span>
                        </div>
                        <i class="fas fa-qrcode text-gray-400 text-sm"></i>
                    </div>
                    
                    <!-- Motorcycle Info -->
                    <div class="mb-3">
                        <h3 class="text-sm font-semibold text-gray-900 mb-1">{{ $motorcycle->name }}</h3>
                        <p class="text-xs text-gray-500">{{ $motorcycle->license_plate }} • {{ $motorcycle->year }}</p>
                    </div>
                    
                    <!-- Tags -->
                    <div class="flex flex-wrap gap-1 mb-3">
                        @if($motorcycle->tags)
                            @foreach($motorcycle->tags as $tag)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-700">
                                {{ $tag }}
                            </span>
                            @endforeach
                        @endif
                    </div>
                    
                    <!-- Specifications -->
                    <div class="space-y-2 text-xs text-gray-600">
                        <div class="flex items-center">
                            <i class="{{ $motorcycle->category_icon }} mr-2 w-4"></i>
                            <span><strong>Categoria:</strong> {{ $motorcycle->category }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="{{ $motorcycle->fuel_icon }} mr-2 w-4"></i>
                            <span><strong>Combustível:</strong> {{ $motorcycle->fuel }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-tachometer-alt mr-2 w-4"></i>
                            <span><strong>Quilometragem:</strong> {{ $motorcycle->formatted_mileage }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-dollar-sign mr-2 w-4"></i>
                            <span><strong>Diária:</strong> {{ $motorcycle->formatted_daily_rate }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-calendar-check mr-2 w-4"></i>
                            <span><strong>Total aluguéis:</strong> {{ $motorcycle->total_rentals }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex border-t border-gray-200">
                    <a href="{{ route('motorcycles.edit', $motorcycle) }}" class="flex-1 flex items-center justify-center px-3 py-2 text-xs text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-edit mr-1"></i>
                        Editar
                    </a>
                    <a href="{{ route('motorcycles.show', $motorcycle) }}" class="flex-1 flex items-center justify-center px-3 py-2 text-xs text-gray-600 hover:bg-gray-50 hover:text-gray-900 border-l border-gray-200">
                        <i class="fas fa-eye"></i>
                    </a>
                    <form method="POST" action="{{ route('motorcycles.destroy', $motorcycle) }}" class="flex-1" onsubmit="return confirm('Tem certeza que deseja excluir esta motocicleta?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full flex items-center justify-center px-3 py-2 text-xs text-red-600 hover:bg-red-50 hover:text-red-700 border-l border-gray-200">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-motorcycle text-4xl text-gray-400 mb-4"></i>
                <p class="text-gray-500 text-lg">Nenhuma motocicleta encontrada</p>
                <a href="{{ route('motorcycles.create') }}" class="inline-flex items-center px-3 py-1.5 mt-4 text-xs font-medium text-white bg-gray-800 hover:bg-gray-700 rounded-md">
                    <i class="fas fa-plus mr-1.5 text-xs"></i>
                    Adicionar Primeira Moto
                </a>
            </div>
            @endforelse
        </div>
    </form>

    <!-- Pagination -->
    @if($motorcycles->hasPages())
    <div class="mt-6">
        {{ $motorcycles->appends(request()->query())->links() }}
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
        window.location.href = '{{ route('motorcycles.index') }}';
    }

    function bulkDelete() {
        const checkboxes = document.querySelectorAll('input[name="selected_motorcycles[]"]:checked');
        if (checkboxes.length === 0) {
            alert('Selecione pelo menos uma motocicleta para excluir.');
            return;
        }

        if (confirm(`Tem certeza que deseja excluir ${checkboxes.length} motocicleta(s)?`)) {
            document.getElementById('bulkForm').submit();
        }
    }

    // Auto-submit form when filters change
    document.querySelectorAll('select[name="status"], select[name="category"], select[name="fuel"]').forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
</script>
@endpush 