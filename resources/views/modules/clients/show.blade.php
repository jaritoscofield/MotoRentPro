@extends('layouts.dashboard')

@section('title', 'Detalhes do Cliente - MotoRentPro')
@section('page-title', 'Detalhes do Cliente')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $client->name }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Detalhes completos do cliente</p>
                </div>
                <div class="flex gap-2">
                    <a href="/clientes/{{ $client->id }}/edit" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <i class="fas fa-edit mr-1.5 text-xs"></i>
                        Editar
                    </a>
                    <a href="/clientes" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <i class="fas fa-arrow-left mr-1.5 text-xs"></i>
                        Voltar
                    </a>
                </div>
            </div>
        </div>

        <!-- Client Details -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="p-6">
                <!-- Status Badge -->
                <div class="mb-6">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                        @if($client->status_color == 'green') bg-green-100 text-green-800
                        @elseif($client->status_color == 'orange') bg-orange-100 text-orange-800
                        @elseif($client->status_color == 'red') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800 @endif">
                        <i class="fas fa-circle mr-2 text-xs"></i>
                        {{ $client->status }}
                    </span>
                </div>

                <!-- Main Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Personal Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informações Pessoais</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nome Completo</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $client->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $client->email }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Telefone</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $client->phone }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">CNH</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $client->cnh }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Data de Nascimento</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $client->formatted_birth_date }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Rental Statistics -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Estatísticas de Aluguel</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total de Aluguéis</dt>
                                <dd class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $client->total_rentals }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Gasto</dt>
                                <dd class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $client->formatted_total_spent }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Último Aluguel</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $client->formatted_last_rental_date }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Address -->
                @if($client->address)
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Endereço</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <p class="text-sm text-gray-900 dark:text-gray-100">{{ $client->address }}</p>
                    </div>
                </div>
                @endif

                <!-- Notes -->
                @if($client->notes)
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Observações</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <p class="text-sm text-gray-900 dark:text-gray-100">{{ $client->notes }}</p>
                    </div>
                </div>
                @endif

                <!-- System Information -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informações do Sistema</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ID do Cliente</dt>
                            <dd class="text-sm text-gray-900 dark:text-gray-100">#{{ $client->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Data de Cadastro</dt>
                            <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $client->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Última Atualização</dt>
                            <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $client->updated_at->format('d/m/Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 mt-6">
            <form method="POST" action="/clientes/{{ $client->id }}" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este cliente?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-sm font-medium text-red-700 dark:text-red-400 bg-white dark:bg-gray-800 border border-red-300 dark:border-red-600 rounded-md hover:bg-red-50 dark:hover:bg-red-900/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <i class="fas fa-trash mr-1.5 text-xs"></i>
                    Excluir Cliente
                </button>
            </form>
            <a href="/clientes/{{ $client->id }}/edit" class="px-4 py-2 text-sm font-medium text-white bg-gray-800 dark:bg-gray-700 border border-transparent rounded-md hover:bg-gray-700 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <i class="fas fa-edit mr-1.5 text-xs"></i>
                Editar Cliente
            </a>
        </div>
    </div>
@endsection 