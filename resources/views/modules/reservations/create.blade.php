@extends('layouts.dashboard')

@section('title', 'Nova Reserva - MotoRentPro')
@section('page-title', 'Nova Reserva')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Nova Reserva</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Crie uma nova reserva no sistema</p>
                </div>
                <a href="/reservas" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-1.5 text-xs"></i>
                    Voltar
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
            <form method="POST" action="/reservas" class="p-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Cliente -->
                    <div>
                        <label for="client_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cliente *</label>
                        <select id="client_id" 
                                name="client_id"
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 @error('client_id') border-red-500 @enderror">
                            <option value="">Selecione um cliente</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }} ({{ $client->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('client_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Motocicleta -->
                    <div>
                        <label for="motorcycle_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Motocicleta *</label>
                        <select id="motorcycle_id" 
                                name="motorcycle_id"
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 @error('motorcycle_id') border-red-500 @enderror">
                            <option value="">Selecione uma motocicleta</option>
                            @foreach($motorcycles as $motorcycle)
                                <option value="{{ $motorcycle->id }}" 
                                        data-daily-rate="{{ $motorcycle->daily_rate }}"
                                        {{ old('motorcycle_id') == $motorcycle->id ? 'selected' : '' }}>
                                    {{ $motorcycle->name }} - R$ {{ number_format($motorcycle->daily_rate, 2, ',', '.') }}/dia
                                </option>
                            @endforeach
                        </select>
                        @error('motorcycle_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Data de Início -->
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data de Início *</label>
                        <input type="date" 
                               id="start_date" 
                               name="start_date" 
                               value="{{ old('start_date') }}"
                               min="{{ date('Y-m-d') }}"
                               class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 @error('start_date') border-red-500 @enderror">
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Data de Fim -->
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data de Fim *</label>
                        <input type="date" 
                               id="end_date" 
                               name="end_date" 
                               value="{{ old('end_date') }}"
                               class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 @error('end_date') border-red-500 @enderror">
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Taxa Diária -->
                    <div>
                        <label for="daily_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Taxa Diária (R$) *</label>
                        <input type="number" 
                               id="daily_rate" 
                               name="daily_rate" 
                               value="{{ old('daily_rate') }}"
                               step="0.01"
                               min="0"
                               class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 @error('daily_rate') border-red-500 @enderror"
                               placeholder="0.00">
                        @error('daily_rate')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status *</label>
                        <select id="status" 
                                name="status"
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 @error('status') border-red-500 @enderror">
                            <option value="">Selecione um status</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cálculo Automático -->
                    <div class="md:col-span-2">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Cálculo Automático</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Duração</p>
                                    <p id="duration" class="text-sm font-medium text-gray-900 dark:text-gray-100">-</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Taxa Diária</p>
                                    <p id="daily_rate_display" class="text-sm font-medium text-gray-900 dark:text-gray-100">R$ 0,00</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Valor Total</p>
                                    <p id="total_amount" class="text-lg font-bold text-green-600 dark:text-green-400">R$ 0,00</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Observações -->
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Observações</label>
                        <textarea id="notes" 
                                  name="notes" 
                                  rows="4"
                                  class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 @error('notes') border-red-500 @enderror"
                                  placeholder="Informações adicionais sobre a reserva">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="/reservas" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-gray-800 dark:bg-gray-700 border border-transparent rounded-md hover:bg-gray-700 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <i class="fas fa-save mr-1.5 text-xs"></i>
                        Criar Reserva
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Auto-calcular valores quando moto for selecionada
    document.getElementById('motorcycle_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const dailyRate = selectedOption.dataset.dailyRate || 0;
        
        document.getElementById('daily_rate').value = dailyRate;
        document.getElementById('daily_rate_display').textContent = `R$ ${parseFloat(dailyRate).toFixed(2).replace('.', ',')}`;
        
        calculateTotal();
    });

    // Auto-calcular valores quando datas ou taxa mudarem
    document.getElementById('start_date').addEventListener('change', calculateTotal);
    document.getElementById('end_date').addEventListener('change', calculateTotal);
    document.getElementById('daily_rate').addEventListener('input', calculateTotal);

    function calculateTotal() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        const dailyRate = parseFloat(document.getElementById('daily_rate').value) || 0;

        if (startDate && endDate && dailyRate > 0) {
            const start = new Date(startDate);
            const end = new Date(endDate);
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            const total = diffDays * dailyRate;

            document.getElementById('duration').textContent = `${diffDays} dia(s)`;
            document.getElementById('total_amount').textContent = `R$ ${total.toFixed(2).replace('.', ',')}`;
        } else {
            document.getElementById('duration').textContent = '-';
            document.getElementById('total_amount').textContent = 'R$ 0,00';
        }
    }

    // Validar data de fim
    document.getElementById('start_date').addEventListener('change', function() {
        const startDate = this.value;
        const endDateInput = document.getElementById('end_date');
        
        if (startDate) {
            endDateInput.min = startDate;
            if (endDateInput.value && endDateInput.value <= startDate) {
                endDateInput.value = '';
            }
        }
    });
</script>
@endpush 