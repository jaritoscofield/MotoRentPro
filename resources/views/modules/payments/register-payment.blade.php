@extends('layouts.dashboard')

@section('title', 'Registrar Pagamento - MotoRentPro')
@section('page-title', 'Registrar Pagamento')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Registrar Pagamento</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Registre pagamentos de parcelas pendentes</p>
            </div>
            <div class="flex flex-wrap gap-2 mt-4 lg:mt-0">
                <a href="{{ route('payments.index') }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-arrow-left mr-1.5 text-xs"></i>
                    Voltar
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-4 py-3 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium">Erro ao registrar pagamento</h3>
                    <div class="mt-2 text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
        <form method="POST" action="{{ route('payments.installment.store') }}" id="paymentForm">
            @csrf
            
            <!-- Seleção da Venda -->
            <div class="mb-6">
                <label for="payment_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cliente</label>
                <select name="payment_id" id="payment_id" required
                        class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    <option value="">Selecione o cliente</option>
                    @foreach($payments as $payment)
                        <option value="{{ $payment->id }}" data-payment="{{ $payment->id }}">
                            {{ $payment->client->name }} - {{ $payment->motorcycle->name }} ({{ $payment->formatted_total_amount }})
                        </option>
                    @endforeach
                </select>
                @error('payment_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Seleção da Parcela -->
            <div class="mb-6">
                <label for="installment_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Número da Parcela</label>
                <select name="installment_id" id="installment_id" required
                        class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    <option value="">Selecione primeiro o cliente</option>
                </select>
                @error('installment_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Valor Pago -->
            <div class="mb-6">
                <label for="amount_paid" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Valor Pago</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 dark:text-gray-400 text-sm">R$</span>
                    </div>
                    <input type="number" 
                           name="amount_paid" 
                           id="amount_paid"
                           step="0.01"
                           min="0.01"
                           required
                           class="w-full pl-12 pr-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                           placeholder="0,00">
                </div>
                @error('amount_paid')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Forma de Pagamento -->
            <div class="mb-6">
                <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Forma de Pagamento</label>
                <select name="payment_method" id="payment_method" required
                        class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    <option value="">Selecione a forma de pagamento</option>
                    @foreach($paymentMethods as $value => $label)
                        <option value="{{ $value }}" {{ old('payment_method') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('payment_method')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Data do Pagamento -->
            <div class="mb-6">
                <label for="payment_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Data do Pagamento</label>
                <input type="date" 
                       name="payment_date" 
                       id="payment_date"
                       required
                       value="{{ old('payment_date', date('Y-m-d')) }}"
                       class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                @error('payment_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Observações -->
            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Observações</label>
                <textarea name="notes" 
                          id="notes"
                          rows="3"
                          class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                          placeholder="Informações sobre o pagamento...">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botões -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('payments.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Cancelar
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-check mr-2"></i>
                    Registrar Pagamento
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentSelect = document.getElementById('payment_id');
    const installmentSelect = document.getElementById('installment_id');
    const amountInput = document.getElementById('amount_paid');

    // Dados das parcelas (serão carregados via AJAX)
    let installmentsData = {};

    paymentSelect.addEventListener('change', function() {
        const paymentId = this.value;
        
        if (!paymentId) {
            installmentSelect.innerHTML = '<option value="">Selecione primeiro o cliente</option>';
            amountInput.value = '';
            return;
        }

        // Carregar parcelas pendentes via AJAX
        fetch(`/pagamentos/installment/pending?payment_id=${paymentId}`)
            .then(response => response.json())
            .then(data => {
                installmentSelect.innerHTML = '<option value="">Selecione a parcela</option>';
                installmentsData = {};
                
                data.forEach(installment => {
                    const option = document.createElement('option');
                    option.value = installment.id;
                    option.textContent = `Parcela ${installment.installment_number} - Vencimento: ${installment.formatted_due_date} - Valor: ${installment.formatted_amount}`;
                    installmentSelect.appendChild(option);
                    
                    installmentsData[installment.id] = installment;
                });
            })
            .catch(error => {
                console.error('Erro ao carregar parcelas:', error);
                installmentSelect.innerHTML = '<option value="">Erro ao carregar parcelas</option>';
            });
    });

    installmentSelect.addEventListener('change', function() {
        const installmentId = this.value;
        
        if (installmentId && installmentsData[installmentId]) {
            const installment = installmentsData[installmentId];
            amountInput.value = installment.amount;
        } else {
            amountInput.value = '';
        }
    });
});
</script>
@endsection 