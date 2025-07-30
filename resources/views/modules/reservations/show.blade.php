@extends('layouts.dashboard')

@section('title', 'Detalhes da Reserva - MotoRentPro')
@section('page-title', 'Detalhes da Reserva')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Reserva #{{ $reservation->id }}</h1>
                    <p class="text-gray-600 mt-1">Detalhes completos da reserva</p>
                </div>
                <div class="flex gap-2">
                    <a href="/reservas/{{ $reservation->id }}/edit" class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-edit mr-1.5 text-xs"></i>
                        Editar
                    </a>
                    <a href="/reservas" class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-arrow-left mr-1.5 text-xs"></i>
                        Voltar
                    </a>
                </div>
            </div>
        </div>

        <!-- Reservation Details -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
            <div class="p-6">
                <!-- Status Badge -->
                <div class="mb-6">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                        @if($reservation->status_color == 'green') bg-green-100 text-green-800
                        @elseif($reservation->status_color == 'blue') bg-blue-100 text-blue-800
                        @elseif($reservation->status_color == 'orange') bg-orange-100 text-orange-800
                        @elseif($reservation->status_color == 'red') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800 @endif">
                        <i class="fas fa-circle mr-2 text-xs"></i>
                        {{ $reservation->status }}
                    </span>
                </div>

                <!-- Main Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Client Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informações do Cliente</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nome</dt>
                                <dd class="text-sm text-gray-900">{{ $reservation->client->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="text-sm text-gray-900">{{ $reservation->client->email }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Telefone</dt>
                                <dd class="text-sm text-gray-900">{{ $reservation->client->phone }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">CNH</dt>
                                <dd class="text-sm text-gray-900">{{ $reservation->client->cnh }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Motorcycle Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informações da Motocicleta</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Modelo</dt>
                                <dd class="text-sm text-gray-900">{{ $reservation->motorcycle->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Ano</dt>
                                <dd class="text-sm text-gray-900">{{ $reservation->motorcycle->year }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Placa</dt>
                                <dd class="text-sm text-gray-900">{{ $reservation->motorcycle->license_plate }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="text-sm text-gray-900">{{ $reservation->motorcycle->status }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Reservation Details -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Detalhes da Reserva</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <dt class="text-sm font-medium text-gray-500">Período</dt>
                            <dd class="text-lg font-bold text-gray-900 mt-1">{{ $reservation->period_text }}</dd>
                            <dd class="text-sm text-gray-600">{{ $reservation->date_range }}</dd>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <dt class="text-sm font-medium text-gray-500">Taxa Diária</dt>
                            <dd class="text-lg font-bold text-gray-900 mt-1">{{ $reservation->formatted_daily_rate }}</dd>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4">
                            <dt class="text-sm font-medium text-gray-500">Valor Total</dt>
                            <dd class="text-2xl font-bold text-green-600 mt-1">{{ $reservation->formatted_total_amount }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                @if($reservation->notes)
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Observações</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-900">{{ $reservation->notes }}</p>
                    </div>
                </div>
                @endif

                <!-- System Information -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informações do Sistema</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">ID da Reserva</dt>
                            <dd class="text-sm text-gray-900">#{{ $reservation->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Data de Criação</dt>
                            <dd class="text-sm text-gray-900">{{ $reservation->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Última Atualização</dt>
                            <dd class="text-sm text-gray-900">{{ $reservation->updated_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Duração</dt>
                            <dd class="text-sm text-gray-900">{{ $reservation->duration_days }} dia(s)</dd>
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
                <button type="submit" class="px-4 py-2 text-sm font-medium text-red-700 bg-white border border-red-300 rounded-md hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <i class="fas fa-trash mr-1.5 text-xs"></i>
                    Excluir Reserva
                </button>
            </form>
            <a href="/reservas/{{ $reservation->id }}/edit" class="px-4 py-2 text-sm font-medium text-white bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <i class="fas fa-edit mr-1.5 text-xs"></i>
                Editar Reserva
            </a>
        </div>
    </div>
@endsection 