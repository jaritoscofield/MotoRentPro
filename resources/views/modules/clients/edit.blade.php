@extends('layouts.dashboard')

@section('title', 'Editar Cliente - MotoRentPro')
@section('page-title', 'Editar Cliente')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Editar Cliente</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Atualize as informações do cliente</p>
                </div>
                <a href="/clientes" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-1.5 text-xs"></i>
                    Voltar
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
            <form method="POST" action="/clientes/{{ $client->id }}" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nome -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome Completo *</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $client->name) }}"
                               class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 @error('name') border-red-500 @enderror"
                               placeholder="Digite o nome completo">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email *</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $client->email) }}"
                               class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 @error('email') border-red-500 @enderror"
                               placeholder="exemplo@email.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Telefone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Telefone *</label>
                        <input type="text" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone', $client->phone) }}"
                               class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 @error('phone') border-red-500 @enderror"
                               placeholder="(11) 99999-9999">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- CNH -->
                    <div>
                        <label for="cnh" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">CNH *</label>
                        <input type="text" 
                               id="cnh" 
                               name="cnh" 
                               value="{{ old('cnh', $client->cnh) }}"
                               class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 @error('cnh') border-red-500 @enderror"
                               placeholder="12345678900">
                        @error('cnh')
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
                                <option value="{{ $status }}" {{ old('status', $client->status) == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Data de Nascimento -->
                    <div>
                        <label for="birth_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data de Nascimento</label>
                        <input type="date" 
                               id="birth_date" 
                               name="birth_date" 
                               value="{{ old('birth_date', $client->birth_date ? $client->birth_date->format('Y-m-d') : '') }}"
                               class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 @error('birth_date') border-red-500 @enderror">
                        @error('birth_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Endereço -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Endereço</label>
                        <textarea id="address" 
                                  name="address" 
                                  rows="3"
                                  class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 @error('address') border-red-500 @enderror"
                                  placeholder="Digite o endereço completo">{{ old('address', $client->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Observações -->
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Observações</label>
                        <textarea id="notes" 
                                  name="notes" 
                                  rows="4"
                                  class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 @error('notes') border-red-500 @enderror"
                                  placeholder="Informações adicionais sobre o cliente">{{ old('notes', $client->notes) }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="/clientes" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-gray-800 dark:bg-gray-700 border border-transparent rounded-md hover:bg-gray-700 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <i class="fas fa-save mr-1.5 text-xs"></i>
                        Atualizar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection 