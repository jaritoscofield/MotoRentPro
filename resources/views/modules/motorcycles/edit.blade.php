@extends('layouts.dashboard')

@section('title', 'Editar Motocicleta - MotoRentPro')
@section('page-title', 'Editar Motocicleta')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Editar Motocicleta</h2>
        </div>
        
        <form method="POST" action="/frota/{{ $motorcycle->id }}" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informações Básicas -->
                <div class="space-y-4">
                    <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">Informações Básicas</h3>
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome/Modelo *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $motorcycle->name) }}" required
                               class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400"
                               placeholder="Ex: Honda CG 160">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="license_plate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Placa *</label>
                        <input type="text" id="license_plate" name="license_plate" value="{{ old('license_plate', $motorcycle->license_plate) }}" required
                               class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400"
                               placeholder="Ex: ABC-1234">
                        @error('license_plate')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ano *</label>
                        <input type="number" id="year" name="year" value="{{ old('year', $motorcycle->year) }}" min="1900" max="{{ date('Y') + 1 }}" required
                               class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400"
                               placeholder="Ex: 2023">
                        @error('year')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status *</label>
                        <select id="status" name="status" required
                                class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">Selecione...</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ old('status', $motorcycle->status) == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Especificações -->
                <div class="space-y-4">
                    <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">Especificações</h3>
                    
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Categoria *</label>
                        <select id="category" name="category" required
                                class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">Selecione...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ old('category', $motorcycle->category) == $category ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="fuel" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Combustível *</label>
                        <select id="fuel" name="fuel" required
                                class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">Selecione...</option>
                            @foreach($fuels as $fuel)
                                <option value="{{ $fuel }}" {{ old('fuel', $motorcycle->fuel) == $fuel ? 'selected' : '' }}>{{ $fuel }}</option>
                            @endforeach
                        </select>
                        @error('fuel')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="mileage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Quilometragem (km) *</label>
                        <input type="number" id="mileage" name="mileage" value="{{ old('mileage', $motorcycle->mileage) }}" min="0" required
                               class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400"
                               placeholder="Ex: 15000">
                        @error('mileage')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="daily_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Diária (R$) *</label>
                        <input type="number" id="daily_rate" name="daily_rate" value="{{ old('daily_rate', $motorcycle->daily_rate) }}" min="0" step="0.01" required
                               class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400"
                               placeholder="Ex: 80.00">
                        @error('daily_rate')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Informações Adicionais -->
            <div class="mt-6 space-y-4">
                <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">Informações Adicionais</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Avaliação</label>
                        <input type="number" id="rating" name="rating" value="{{ old('rating', $motorcycle->rating) }}" min="0" max="5" step="0.1"
                               class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400"
                               placeholder="Ex: 4.5">
                        @error('rating')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="total_rentals" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Total de Aluguéis</label>
                        <input type="number" id="total_rentals" name="total_rentals" value="{{ old('total_rentals', $motorcycle->total_rentals) }}" min="0"
                               class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400"
                               placeholder="Ex: 25">
                        @error('total_rentals')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tags</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                        @foreach($tags as $tag)
                            <label class="flex items-center">
                                <input type="checkbox" name="tags[]" value="{{ $tag }}" 
                                       {{ in_array($tag, old('tags', $motorcycle->tags ?? [])) ? 'checked' : '' }}
                                       class="rounded border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 focus:ring-gray-500">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ ucfirst($tag) }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('tags')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descrição</label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400"
                              placeholder="Descreva as características da motocicleta...">{{ old('description', $motorcycle->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload de Imagens</label>
                    @if($motorcycle->image)
                        <div class="mb-3">
                            @php
                                $imageName = basename($motorcycle->image);
                            @endphp
                            <img src="/motorcycles/{{ $imageName }}" alt="{{ $motorcycle->name }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200 dark:border-gray-600">
                        </div>
                    @endif
                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center hover:border-gray-400 dark:hover:border-gray-500 transition-colors cursor-pointer" onclick="document.getElementById('image').click()">
                        <i class="fas fa-camera text-4xl text-gray-400 dark:text-gray-500 mb-3"></i>
                        <p class="text-sm text-gray-700 dark:text-gray-300 mb-1">Clique para adicionar fotos da moto</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Máximo 10 imagens, até 5MB cada</p>
                    </div>
                    <input type="file" id="image" name="image[]" accept="image/*" multiple
                           class="hidden"
                           onchange="handleImageUpload(this)">
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Actions -->
            <div class="flex justify-end gap-2 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="/frota" class="px-3 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-md">
                Cancelar
            </a>
                <button type="submit" class="px-3 py-1.5 text-xs font-medium text-white bg-gray-800 dark:bg-gray-700 hover:bg-gray-700 dark:hover:bg-gray-600 rounded-md">
                    Atualizar Motocicleta
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function handleImageUpload(input) {
    const files = input.files;
    const maxFiles = 10;
    const maxSize = 5 * 1024 * 1024; // 5MB (5120 KB)
    
    if (files.length > maxFiles) {
        alert(`Máximo de ${maxFiles} imagens permitidas.`);
        input.value = '';
        return;
    }
    
    for (let i = 0; i < files.length; i++) {
        if (files[i].size > maxSize) {
            alert(`A imagem "${files[i].name}" excede o tamanho máximo de 5MB.`);
            input.value = '';
            return;
        }
    }
    
    // Opcional: Mostrar preview das imagens selecionadas
    if (files.length > 0) {
        const uploadArea = input.previousElementSibling;
        uploadArea.innerHTML = `
            <i class="fas fa-check-circle text-4xl text-green-500 mb-3"></i>
            <p class="text-sm text-gray-700 mb-1">${files.length} imagem(ns) selecionada(s)</p>
            <p class="text-xs text-gray-500">Clique para alterar</p>
        `;
    }
}
</script>
@endpush
@endsection 