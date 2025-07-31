@extends('layouts.dashboard')

@section('title', 'Detalhes da Venda - MotoRentPro')
@section('page-title', 'Detalhes da Venda')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Venda #{{ $payment->id }}</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Detalhes completos da venda</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="/pagamentos/{{ $payment->id }}/edit" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md text-xs font-medium text-white bg-gray-800 dark:bg-gray-700 hover:bg-gray-700 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <i class="fas fa-edit mr-1.5 text-xs"></i>
                        Editar
                    </a>
                    <a href="/pagamentos" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <i class="fas fa-arrow-left mr-1.5 text-xs"></i>
                        Voltar
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <!-- Status Badge -->
            <div class="mb-6">
                <div class="flex items-center space-x-4">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $payment->status_color }}-100 dark:bg-{{ $payment->status_color }}-900/40 text-{{ $payment->status_color }}-800 dark:text-{{ $payment->status_color }}-300">
                        <i class="{{ $payment->sale_type_icon }} mr-1.5 text-xs"></i>
                        {{ ucfirst($payment->status) }}
                    </span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300">
                        <i class="{{ $payment->payment_method_icon }} mr-1.5 text-xs"></i>
                        {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                    </span>
                    @if($payment->is_overdue)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/40 text-red-800 dark:text-red-300">
                            <i class="fas fa-exclamation-triangle mr-1.5 text-xs"></i>
                            Atrasada
                        </span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-600">
                            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100">Informações Básicas</h3>
                        </div>
                        <div class="px-4 py-3">
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Tipo</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100 flex items-center">
                                        <i class="{{ $payment->sale_type_icon }} text-gray-400 dark:text-gray-500 mr-2 text-xs"></i>
                                        {{ ucfirst($payment->sale_type) }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Data da Venda</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $payment->formatted_sale_date }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Data de Vencimento</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $payment->formatted_due_date }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Método de Pagamento</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100 flex items-center">
                                        <i class="{{ $payment->payment_method_icon }} text-gray-400 dark:text-gray-500 mr-2 text-xs"></i>
                                        {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Financial Information -->
                    <div class="bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-600">
                            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100">Informações Financeiras</h3>
                        </div>
                        <div class="px-4 py-3">
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Valor Total</dt>
                                    <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $payment->formatted_total_amount }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Entrada</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $payment->formatted_down_payment }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Número de Parcelas</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $payment->installments }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Periodicidade</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ ucfirst($payment->periodicity) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Valor da Parcela</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $payment->formatted_installment_amount }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Progresso</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $payment->progress_percentage }}%</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Valor Restante</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $payment->formatted_remaining_amount }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Progresso do Pagamento</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $payment->progress_percentage }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                            <div class="bg-blue-600 dark:bg-blue-500 h-2 rounded-full" style="width: {{ $payment->progress_percentage }}%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-2">
                            <span>R$ {{ number_format($payment->down_payment + $payment->installments()->where('status', 'pago')->sum('amount'), 2, ',', '.') }} pago</span>
                            <span>{{ $payment->formatted_total_amount }} total</span>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($payment->notes)
                    <div class="bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-600">
                            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100">Observações</h3>
                        </div>
                        <div class="px-4 py-3">
                            <p class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $payment->notes }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Client Information -->
                    <div class="bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-600">
                            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100">Cliente</h3>
                        </div>
                        <div class="px-4 py-3">
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Nome</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $payment->client->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $payment->client->email }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Telefone</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $payment->client->phone ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Status</dt>
                                    <dd class="text-sm">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $payment->client->status_color }}-100 dark:bg-{{ $payment->client->status_color }}-900/40 text-{{ $payment->client->status_color }}-800 dark:text-{{ $payment->client->status_color }}-300">
                                            {{ ucfirst($payment->client->status) }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Motorcycle Information -->
                    <div class="bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-600">
                            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100">Motocicleta</h3>
                        </div>
                        <div class="px-4 py-3">
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Modelo</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $payment->motorcycle->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Placa</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $payment->motorcycle->license_plate }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Ano</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $payment->motorcycle->year }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Status</dt>
                                    <dd class="text-sm">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $payment->motorcycle->status_color }}-100 dark:bg-{{ $payment->motorcycle->status_color }}-900/40 text-{{ $payment->motorcycle->status_color }}-800 dark:text-{{ $payment->motorcycle->status_color }}-300">
                                            {{ ucfirst($payment->motorcycle->status) }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Quilometragem</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $payment->motorcycle->formatted_mileage }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- System Information -->
                    <div class="bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-600">
                            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100">Informações do Sistema</h3>
                        </div>
                        <div class="px-4 py-3">
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Criado em</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $payment->formatted_created_at }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Última atualização</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $payment->updated_at->format('d/m/Y H:i') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-600">
                            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100">Ações</h3>
                        </div>
                        <div class="px-4 py-3 space-y-3">
                            <a href="/pagamentos/{{ $payment->id }}/edit" class="w-full inline-flex items-center justify-center px-3 py-1.5 border border-transparent rounded-md text-xs font-medium text-white bg-gray-800 dark:bg-gray-700 hover:bg-gray-700 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <i class="fas fa-edit mr-1.5 text-xs"></i>
                                Editar Venda
                            </a>
                            <button onclick="deletePayment({{ $payment->id }})" class="w-full inline-flex items-center justify-center px-3 py-1.5 border border-transparent rounded-md text-xs font-medium text-white bg-red-600 dark:bg-red-700 hover:bg-red-700 dark:hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <i class="fas fa-trash mr-1.5 text-xs"></i>
                                Excluir Venda
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deletePayment(id) {
    if (confirm('Tem certeza que deseja excluir esta venda? Esta ação não pode ser desfeita.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/pagamentos/${id}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfToken);
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection 