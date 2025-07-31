@extends('layouts.dashboard')

@section('title', 'Nova Manutenção - MotoRentPro')
@section('page-title', 'Nova Manutenção')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Cadastrar Nova Manutenção</h2>
        </div>
        
        <form method="POST" action="/manutencao" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informações Básicas -->
                <div class="space-y-4">
                    <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">Informações Básicas</h3>
                    
                    <div>
                        <label for="motorcycle_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Motocicleta *</label>
                        <select name="motorcycle_id" id="motorcycle_id" required 
                                class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">Selecione uma motocicleta</option>
                            @foreach($motorcycles as $motorcycle)
                                <option value="{{ $motorcycle->id }}" {{ old('motorcycle_id') == $motorcycle->id ? 'selected' : '' }}>
                                    {{ $motorcycle->name }} - {{ $motorcycle->license_plate }}
                                </option>
                            @endforeach
                        </select>
                        @error('motorcycle_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo *</label>
                        <select name="type" id="type" required 
                                class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">Selecione o tipo</option>
                            @foreach($types as $type)
                                <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="scheduled_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data Agendada *</label>
                        <input type="date" name="scheduled_date" id="scheduled_date" 
                               value="{{ old('scheduled_date') }}" required
                               class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        @error('scheduled_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status *</label>
                        <select name="status" id="status" required 
                                class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">Selecione o status</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Prioridade *</label>
                        <select name="priority" id="priority" required 
                                class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">Selecione a prioridade</option>
                            @foreach($priorities as $priority)
                                <option value="{{ $priority }}" {{ old('priority') == $priority ? 'selected' : '' }}>
                                    {{ $priority }}
                                </option>
                            @endforeach
                        </select>
                        @error('priority')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Detalhes Adicionais -->
                <div class="space-y-4">
                    <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">Detalhes Adicionais</h3>
                    
                    <div>
                        <label for="technician" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Técnico Responsável</label>
                        <input type="text" name="technician" id="technician" 
                               value="{{ old('technician') }}"
                               class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400"
                               placeholder="Nome do técnico">
                        @error('technician')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="cost" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Custo Estimado</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400 text-xs">R$</span>
                            </div>
                            <input type="number" name="cost" id="cost" step="0.01" min="0"
                                   value="{{ old('cost') }}"
                                   class="w-full pl-10 px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400"
                                   placeholder="0,00">
                        </div>
                        @error('cost')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="completed_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data de Conclusão</label>
                        <input type="date" name="completed_date" id="completed_date" 
                               value="{{ old('completed_date') }}"
                               class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        @error('completed_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="labor_hours" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Horas de Trabalho</label>
                        <input type="number" name="labor_hours" id="labor_hours" step="0.5" min="0"
                               value="{{ old('labor_hours') }}"
                               class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400"
                               placeholder="0.0">
                        @error('labor_hours')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="mileage_at_service" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Quilometragem no Serviço</label>
                        <input type="number" name="mileage_at_service" id="mileage_at_service" min="0"
                               value="{{ old('mileage_at_service') }}"
                               class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400"
                               placeholder="0 km">
                        @error('mileage_at_service')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="next_maintenance_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Próxima Data de Manutenção</label>
                        <input type="date" name="next_maintenance_date" id="next_maintenance_date" 
                               value="{{ old('next_maintenance_date') }}"
                               class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        @error('next_maintenance_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Descrição -->
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descrição *</label>
                <textarea name="description" id="description" rows="4" required
                          class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400"
                          placeholder="Descreva os detalhes da manutenção...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Peças Utilizadas -->
            <div class="mt-4">
                <label for="parts_used" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Peças Utilizadas</label>
                <textarea name="parts_used" id="parts_used" rows="3"
                          class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400"
                          placeholder="Liste as peças utilizadas na manutenção...">{{ old('parts_used') }}</textarea>
                @error('parts_used')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Observações -->
            <div class="mt-4">
                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Observações</label>
                <textarea name="notes" id="notes" rows="3"
                          class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400"
                          placeholder="Observações adicionais...">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="/manutencao" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Cancelar
                </a>
                <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md text-xs font-medium text-white bg-gray-800 dark:bg-gray-700 hover:bg-gray-700 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-save mr-1.5 text-xs"></i>
                    Salvar Manutenção
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Set minimum date for scheduled_date to today
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('scheduled_date').min = today;
    
    // Set minimum date for completed_date to scheduled_date
    const scheduledDateInput = document.getElementById('scheduled_date');
    const completedDateInput = document.getElementById('completed_date');
    
    scheduledDateInput.addEventListener('change', function() {
        completedDateInput.min = this.value;
    });
    
    // Set minimum date for next_maintenance_date to scheduled_date
    const nextMaintenanceInput = document.getElementById('next_maintenance_date');
    
    scheduledDateInput.addEventListener('change', function() {
        nextMaintenanceInput.min = this.value;
    });
});
</script>
@endsection 