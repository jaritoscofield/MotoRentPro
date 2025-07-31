@extends('layouts.dashboard')

@section('title', 'Editar Venda - MotoRentPro')
@section('page-title', 'Editar Venda')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Editar Venda</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Atualize os dados da venda</p>
                </div>
                <a href="/pagamentos" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-arrow-left mr-1.5 text-xs"></i>
                    Voltar
                </a>
            </div>
        </div>
        
        <form method="POST" action="/pagamentos/{{ $payment->id }}" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informações Básicas -->
                <div class="space-y-4">
                    <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">Informações Básicas</h3>
                    
                    <div>
                        <label for="client_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cliente *</label>
                        <select name="client_id" id="client_id" required 
                                class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">Selecione um cliente</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id', $payment->client_id) == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }} - {{ $client->email }}
                                </option>
                            @endforeach
                        </select>
                        @error('client_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="motorcycle_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Motocicleta *</label>
                        <select name="motorcycle_id" id="motorcycle_id" required 
                                class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">Selecione uma motocicleta</option>
                            @foreach($motorcycles as $motorcycle)
                                <option value="{{ $motorcycle->id }}" {{ old('motorcycle_id', $payment->motorcycle_id) == $motorcycle->id ? 'selected' : '' }}>
                                    {{ $motorcycle->name }} - {{ $motorcycle->license_plate }} (R$ {{ number_format($motorcycle->daily_rate, 2, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                        @error('motorcycle_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="sale_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo *</label>
                        <select name="sale_type" id="sale_type" required 
                                class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">Selecione o tipo</option>
                            @foreach($saleTypes as $value => $label)
                                <option value="{{ $value }}" {{ old('sale_type', $payment->sale_type) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('sale_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Método de Pagamento *</label>
                        <select name="payment_method" id="payment_method" required 
                                class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">Selecione o método</option>
                            @foreach($paymentMethods as $value => $label)
                                <option value="{{ $value }}" {{ old('payment_method', $payment->payment_method) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('payment_method')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status *</label>
                        <select name="status" id="status" required 
                                class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">Selecione o status</option>
                            @foreach($statuses as $value => $label)
                                <option value="{{ $value }}" {{ old('status', $payment->status) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Informações Financeiras -->
                <div class="space-y-4">
                    <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">Informações Financeiras</h3>
                    
                    <div>
                        <label for="total_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Valor Total *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400 text-xs">R$</span>
                            </div>
                            <input type="number" name="total_amount" id="total_amount" step="0.01" min="0" required
                                   value="{{ old('total_amount', $payment->total_amount) }}"
                                   class="w-full pl-10 px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400"
                                   placeholder="0,00">
                        </div>
                        @error('total_amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="down_payment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Entrada *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400 text-xs">R$</span>
                            </div>
                            <input type="number" name="down_payment" id="down_payment" step="0.01" min="0" required
                                   value="{{ old('down_payment', $payment->down_payment) }}"
                                   class="w-full pl-10 px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400"
                                   placeholder="0,00">
                        </div>
                        @error('down_payment')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="installments" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Número de Parcelas *</label>
                        <input type="number" name="installments" id="installments" min="1" max="500" required
                               value="{{ old('installments', $payment->installments) }}"
                               class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400"
                               placeholder="1">
                        @error('installments')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="periodicity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Periodicidade *</label>
                        <select name="periodicity" id="periodicity" required 
                                class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">Selecione a periodicidade</option>
                            @foreach($periodicities as $value => $label)
                                <option value="{{ $value }}" {{ old('periodicity', $payment->periodicity) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('periodicity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="sale_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data da Venda *</label>
                        <input type="date" name="sale_date" id="sale_date" required
                               value="{{ old('sale_date', $payment->sale_date ? $payment->sale_date->format('Y-m-d') : '') }}"
                               class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        @error('sale_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data de Vencimento</label>
                        <input type="date" name="due_date" id="due_date"
                               value="{{ old('due_date', $payment->due_date ? $payment->due_date->format('Y-m-d') : '') }}"
                               class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        @error('due_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Cálculo Automático -->
            <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-3">Cálculo Automático</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">Valor Total:</span>
                        <span id="display-total" class="ml-2 font-medium text-gray-900 dark:text-gray-100">R$ 0,00</span>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">Entrada:</span>
                        <span id="display-down" class="ml-2 font-medium text-gray-900 dark:text-gray-100">R$ 0,00</span>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">Valor das Parcelas:</span>
                        <span id="display-installment" class="ml-2 font-medium text-gray-900 dark:text-gray-100">R$ 0,00</span>
                    </div>
                </div>
            </div>

            <!-- Observações -->
            <div class="mt-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Observações</label>
                <textarea name="notes" id="notes" rows="3"
                          class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400"
                          placeholder="Observações adicionais sobre a venda...">{{ old('notes', $payment->notes) }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="/pagamentos" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Cancelar
                </a>
                <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md text-xs font-medium text-white bg-gray-800 dark:bg-gray-700 hover:bg-gray-700 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-save mr-1.5 text-xs"></i>
                    Atualizar Venda
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const totalAmount = document.getElementById('total_amount');
    const downPayment = document.getElementById('down_payment');
    const installments = document.getElementById('installments');
    const displayTotal = document.getElementById('display-total');
    const displayDown = document.getElementById('display-down');
    const displayInstallment = document.getElementById('display-installment');

    function updateCalculations() {
        const total = parseFloat(totalAmount.value) || 0;
        const down = parseFloat(downPayment.value) || 0;
        const install = parseInt(installments.value) || 1;
        
        displayTotal.textContent = `R$ ${total.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.')}`;
        displayDown.textContent = `R$ ${down.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.')}`;
        
        const installmentValue = install > 1 ? (total - down) / install : 0;
        displayInstallment.textContent = `R$ ${installmentValue.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.')}`;
    }

    totalAmount.addEventListener('input', updateCalculations);
    downPayment.addEventListener('input', updateCalculations);
    installments.addEventListener('input', updateCalculations);

    // Set minimum date for due_date to sale_date
    const saleDate = document.getElementById('sale_date');
    const dueDate = document.getElementById('due_date');
    
    saleDate.addEventListener('change', function() {
        dueDate.min = this.value;
    });

    // Initial calculation
    updateCalculations();
});
</script>
@endsection 