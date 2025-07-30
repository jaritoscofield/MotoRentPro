@extends('layouts.dashboard')

@section('title', 'Detalhes do Cliente - MotoRentPro')
@section('page-title', 'Detalhes do Cliente')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $client->name }}</h1>
                    <p class="text-gray-600 mt-1">Detalhes completos do cliente</p>
                </div>
                <div class="flex gap-2">
                    <a href="/clientes/{{ $client->id }}/edit" class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-edit mr-1.5 text-xs"></i>
                        Editar
                    </a>
                    <a href="/clientes" class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-arrow-left mr-1.5 text-xs"></i>
                        Voltar
                    </a>
                </div>
            </div>
        </div>

        <!-- Client Details -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
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
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informações Pessoais</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nome Completo</dt>
                                <dd class="text-sm text-gray-900">{{ $client->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="text-sm text-gray-900">{{ $client->email }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Telefone</dt>
                                <dd class="text-sm text-gray-900">{{ $client->phone }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">CNH</dt>
                                <dd class="text-sm text-gray-900">{{ $client->cnh }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Data de Nascimento</dt>
                                <dd class="text-sm text-gray-900">{{ $client->formatted_birth_date }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Rental Statistics -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Estatísticas de Aluguel</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Total de Aluguéis</dt>
                                <dd class="text-2xl font-bold text-gray-900">{{ $client->total_rentals }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Total Gasto</dt>
                                <dd class="text-2xl font-bold text-green-600">{{ $client->formatted_total_spent }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Último Aluguel</dt>
                                <dd class="text-sm text-gray-900">{{ $client->formatted_last_rental_date }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Address -->
                @if($client->address)
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Endereço</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-900">{{ $client->address }}</p>
                    </div>
                </div>
                @endif

                <!-- Notes -->
                @if($client->notes)
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Observações</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-900">{{ $client->notes }}</p>
                    </div>
                </div>
                @endif

                <!-- System Information -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informações do Sistema</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">ID do Cliente</dt>
                            <dd class="text-sm text-gray-900">#{{ $client->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Data de Cadastro</dt>
                            <dd class="text-sm text-gray-900">{{ $client->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Última Atualização</dt>
                            <dd class="text-sm text-gray-900">{{ $client->updated_at->format('d/m/Y H:i') }}</dd>
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
                <button type="submit" class="px-4 py-2 text-sm font-medium text-red-700 bg-white border border-red-300 rounded-md hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <i class="fas fa-trash mr-1.5 text-xs"></i>
                    Excluir Cliente
                </button>
            </form>
            <a href="/clientes/{{ $client->id }}/edit" class="px-4 py-2 text-sm font-medium text-white bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <i class="fas fa-edit mr-1.5 text-xs"></i>
                Editar Cliente
            </a>
        </div>
    </div>
@endsection 