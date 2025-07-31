@extends('layouts.dashboard')

@section('title', 'Detalhes da Reserva - MotoRentPro')
@section('page-title', 'Detalhes da Reserva')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Reserva #{{ $reservation->id }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Detalhes completos da reserva</p>
                </div>
                <div class="flex gap-2">
                    <a href="/reservas/{{ $reservation->id }}/edit" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <i class="fas fa-edit mr-1.5 text-xs"></i>
                        Editar
                    </a>
                    <a href="/reservas" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <i class="fas fa-arrow-left mr-1.5 text-xs"></i>
                        Voltar
                    </a>
                </div>
            </div>
        </div>

        <!-- Reservation Details -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="p-6">
                <!-- Status Badge -->
                <div class="mb-6">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                        @if($reservation->status_color == 'green') bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300
                        @elseif($reservation->status_color == 'blue') bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300
                        @elseif($reservation->status_color == 'orange') bg-orange-100 dark:bg-orange-900/40 text-orange-800 dark:text-orange-300
                        @elseif($reservation->status_color == 'red') bg-red-100 dark:bg-red-900/40 text-red-800 dark:text-red-300
                        @else bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 @endif">
                        <i class="fas fa-circle mr-2 text-xs"></i>
                        {{ $reservation->status }}
                    </span>
                </div>

                <!-- Main Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Client Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informações do Cliente</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nome</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $reservation->client->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $reservation->client->email }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Telefone</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $reservation->client->phone }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">CNH</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $reservation->client->cnh }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Motorcycle Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informações da Motocicleta</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Modelo</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $reservation->motorcycle->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ano</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $reservation->motorcycle->year }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Placa</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $reservation->motorcycle->license_plate }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $reservation->motorcycle->status }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Reservation Details -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Detalhes da Reserva</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Período</dt>
                            <dd class="text-lg font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $reservation->period_text }}</dd>
                            <dd class="text-sm text-gray-600 dark:text-gray-400">{{ $reservation->date_range }}</dd>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Taxa Diária</dt>
                            <dd class="text-lg font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $reservation->formatted_daily_rate }}</dd>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/40 rounded-lg p-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Valor Total</dt>
                            <dd class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">{{ $reservation->formatted_total_amount }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                @if($reservation->notes)
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Observações</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <p class="text-sm text-gray-900 dark:text-gray-100">{{ $reservation->notes }}</p>
                    </div>
                </div>
                @endif

                <!-- System Information -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informações do Sistema</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ID da Reserva</dt>
                            <dd class="text-sm text-gray-900 dark:text-gray-100">#{{ $reservation->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Data de Criação</dt>
                            <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $reservation->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Última Atualização</dt>
                            <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $reservation->updated_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Duração</dt>
                            <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $reservation->duration_days }} dia(s)</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 mt-6">
            <form method="POST" action="/reservas/{{ $reservation->id }}" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta reserva?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-sm font-medium text-red-700 dark:text-red-400 bg-white dark:bg-gray-800 border border-red-300 dark:border-red-600 rounded-md hover:bg-red-50 dark:hover:bg-red-900/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <i class="fas fa-trash mr-1.5 text-xs"></i>
                    Excluir Reserva
                </button>
            </form>
            <a href="/reservas/{{ $reservation->id }}/edit" class="px-4 py-2 text-sm font-medium text-white bg-gray-800 dark:bg-gray-700 border border-transparent rounded-md hover:bg-gray-700 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <i class="fas fa-edit mr-1.5 text-xs"></i>
                Editar Reserva
            </a>
        </div>
    </div>
@endsection 