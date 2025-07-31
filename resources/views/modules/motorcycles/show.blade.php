@extends('layouts.dashboard')

@section('title', $motorcycle->name . ' - MotoRentPro')
@section('page-title', 'Detalhes da Motocicleta')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $motorcycle->name }}</h2>
                <div class="flex items-center gap-2">
                                    <a href="/frota/{{ $motorcycle->id }}/edit" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-md">
                    <i class="fas fa-edit mr-1.5 text-xs"></i>
                    Editar
                </a>
                <a href="/frota" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-md">
                    <i class="fas fa-arrow-left mr-1.5 text-xs"></i>
                    Voltar
                </a>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Imagem -->
                <div>
                    @if($motorcycle->image)
                        @php
                            $imageName = basename($motorcycle->image);
                        @endphp
                        <img src="/motorcycles/{{ $imageName }}" alt="{{ $motorcycle->name }}" class="w-full h-80 object-cover rounded-lg border border-gray-200 dark:border-gray-600">
                    @else
                        <div class="w-full h-80 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 flex items-center justify-center">
                            <i class="fas fa-camera text-4xl text-gray-400 dark:text-gray-500"></i>
                        </div>
                    @endif
                </div>
                
                <!-- Informações -->
                <div class="space-y-6">
                    <!-- Status e Rating -->
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            @if($motorcycle->status_color == 'green') bg-green-100 text-green-800
                            @elseif($motorcycle->status_color == 'orange') bg-orange-100 text-orange-800
                            @elseif($motorcycle->status_color == 'blue') bg-blue-100 text-blue-800
                            @elseif($motorcycle->status_color == 'red') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ $motorcycle->status }}
                        </span>
                        <div class="flex items-center">
                            <i class="fas fa-star text-yellow-400 mr-1"></i>
                            <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $motorcycle->rating }}</span>
                        </div>
                    </div>
                    
                    <!-- Informações Básicas -->
                    <div class="space-y-3">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Informações Básicas</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Placa:</span>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $motorcycle->license_plate }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Ano:</span>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $motorcycle->year }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Categoria:</span>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $motorcycle->category }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Combustível:</span>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $motorcycle->fuel }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Especificações -->
                    <div class="space-y-3">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Especificações</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Quilometragem:</span>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $motorcycle->formatted_mileage }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Diária:</span>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $motorcycle->formatted_daily_rate }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Total de Aluguéis:</span>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $motorcycle->total_rentals }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Cadastrada em:</span>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $motorcycle->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tags -->
                    @if($motorcycle->tags)
                    <div class="space-y-3">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($motorcycle->tags as $tag)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                    {{ ucfirst($tag) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Descrição -->
                    @if($motorcycle->description)
                    <div class="space-y-3">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Descrição</h3>
                        <p class="text-gray-700 dark:text-gray-300">{{ $motorcycle->description }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 