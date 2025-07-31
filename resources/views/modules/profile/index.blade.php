@extends('layouts.dashboard')

@section('title', 'Meu Perfil - MotoRentPro')
@section('page-title', 'Meu Perfil')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center space-x-4">
            <div class="relative">
                <div class="w-20 h-20 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center overflow-hidden">
                    @if($user->avatar)
                        <img src="{{ asset('avatars/' . $user->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-user text-gray-600 dark:text-gray-400 text-2xl"></i>
                    @endif
                </div>
                <button onclick="document.getElementById('avatar-input').click()" class="absolute -bottom-1 -right-1 w-6 h-6 bg-blue-500 hover:bg-blue-600 rounded-full flex items-center justify-center text-white text-xs">
                    <i class="fas fa-camera"></i>
                </button>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $user->name }}</h2>
                <p class="text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ ucfirst($user->role) }}</p>
            </div>
        </div>
    </div>

    <!-- Avatar Upload Form (Hidden) -->
    <form id="avatar-form" method="POST" action="/perfil/avatar" enctype="multipart/form-data" class="hidden">
        @csrf
        <input type="file" id="avatar-input" name="avatar" accept="image/*" onchange="this.form.submit()">
    </form>

    <!-- Profile Information -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Informações Pessoais</h3>
        </div>
        <div class="p-6">
            <form method="POST" action="/perfil/update">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome Completo *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email *</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Telefone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                               placeholder="(11) 99999-9999">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="birth_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data de Nascimento</label>
                        <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $user->birth_date ? $user->birth_date->format('Y-m-d') : '') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        @error('birth_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Endereço</label>
                        <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                               placeholder="Rua, número, bairro, cidade - estado">
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Biografia</label>
                        <textarea name="bio" id="bio" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                  placeholder="Conte um pouco sobre você...">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-save mr-2"></i>
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Change Password -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Alterar Senha</h3>
        </div>
        <div class="p-6">
            <form method="POST" action="/perfil/password">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Senha Atual *</label>
                        <input type="password" name="current_password" id="current_password" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nova Senha *</label>
                        <input type="password" name="password" id="password" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirmar Nova Senha *</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-key mr-2"></i>
                        Alterar Senha
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Account Information -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Informações da Conta</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">ID do Usuário</label>
                    <p class="text-sm text-gray-900 dark:text-gray-100">{{ $user->id }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo de Conta</label>
                    <p class="text-sm text-gray-900 dark:text-gray-100">{{ ucfirst($user->role) }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Membro Desde</label>
                    <p class="text-sm text-gray-900 dark:text-gray-100">{{ $user->created_at->format('d/m/Y') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Última Atualização</label>
                    <p class="text-sm text-gray-900 dark:text-gray-100">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-submit avatar form when file is selected
document.getElementById('avatar-input').addEventListener('change', function() {
    if (this.files.length > 0) {
        this.form.submit();
    }
});
</script>
@endsection 