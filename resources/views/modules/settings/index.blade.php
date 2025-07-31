@extends('layouts.dashboard')

@section('title', 'Configurações - MotoRentPro')
@section('page-title', 'Configurações')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Configurações do Sistema</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Gerencie as configurações gerais do sistema</p>
            </div>
            <div class="flex space-x-3">
                <a href="/configuracoes/system-info" class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <i class="fas fa-info-circle mr-2"></i>
                    Informações do Sistema
                </a>
            </div>
        </div>
    </div>

    <!-- Settings Tabs -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <button onclick="showTab('company')" id="tab-company" class="tab-button active py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600 dark:text-blue-400">
                    <i class="fas fa-building mr-2"></i>
                    Empresa
                </button>
                <button onclick="showTab('system')" id="tab-system" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                    <i class="fas fa-cog mr-2"></i>
                    Sistema
                </button>
                <button onclick="showTab('notifications')" id="tab-notifications" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                    <i class="fas fa-bell mr-2"></i>
                    Notificações
                </button>
                <button onclick="showTab('backup')" id="tab-backup" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                    <i class="fas fa-database mr-2"></i>
                    Backup
                </button>
            </nav>
        </div>

        <!-- Company Settings Tab -->
        <div id="tab-content-company" class="tab-content p-6">
            <form method="POST" action="/configuracoes/update">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome da Empresa *</label>
                        <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $settings['company_name']) }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    </div>

                    <div>
                        <label for="company_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email da Empresa *</label>
                        <input type="email" name="company_email" id="company_email" value="{{ old('company_email', $settings['company_email']) }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    </div>

                    <div>
                        <label for="company_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Telefone</label>
                        <input type="text" name="company_phone" id="company_phone" value="{{ old('company_phone', $settings['company_phone']) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    </div>

                    <div>
                        <label for="company_cnpj" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">CNPJ</label>
                        <input type="text" name="company_cnpj" id="company_cnpj" value="{{ old('company_cnpj', $settings['company_cnpj']) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    </div>

                    <div class="md:col-span-2">
                        <label for="company_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Endereço</label>
                        <input type="text" name="company_address" id="company_address" value="{{ old('company_address', $settings['company_address']) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-save mr-2"></i>
                        Salvar Configurações
                    </button>
                </div>
            </form>
        </div>

        <!-- System Settings Tab -->
        <div id="tab-content-system" class="tab-content p-6 hidden">
            <form method="POST" action="/configuracoes/update">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="system_timezone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fuso Horário</label>
                        <select name="system_timezone" id="system_timezone" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="America/Sao_Paulo" {{ $settings['system_timezone'] == 'America/Sao_Paulo' ? 'selected' : '' }}>America/Sao_Paulo</option>
                            <option value="America/New_York" {{ $settings['system_timezone'] == 'America/New_York' ? 'selected' : '' }}>America/New_York</option>
                            <option value="Europe/London" {{ $settings['system_timezone'] == 'Europe/London' ? 'selected' : '' }}>Europe/London</option>
                        </select>
                    </div>

                    <div>
                        <label for="system_language" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Idioma</label>
                        <select name="system_language" id="system_language" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="pt_BR" {{ $settings['system_language'] == 'pt_BR' ? 'selected' : '' }}>Português (Brasil)</option>
                            <option value="en" {{ $settings['system_language'] == 'en' ? 'selected' : '' }}>English</option>
                            <option value="es" {{ $settings['system_language'] == 'es' ? 'selected' : '' }}>Español</option>
                        </select>
                    </div>

                    <div>
                        <label for="max_file_size" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tamanho Máximo de Arquivo (KB)</label>
                        <input type="number" name="max_file_size" id="max_file_size" value="{{ old('max_file_size', $settings['max_file_size']) }}" min="1" max="10240"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    </div>

                    <div>
                        <label for="allowed_file_types" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipos de Arquivo Permitidos</label>
                        <input type="text" name="allowed_file_types" id="allowed_file_types" value="{{ old('allowed_file_types', $settings['allowed_file_types']) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                               placeholder="jpg,jpeg,png,gif,pdf">
                    </div>

                    <div class="md:col-span-2">
                        <div class="flex items-center">
                            <input type="checkbox" name="maintenance_mode" id="maintenance_mode" value="1" {{ $settings['maintenance_mode'] ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="maintenance_mode" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                                Modo de Manutenção
                            </label>
                        </div>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Ativa o modo de manutenção do sistema</p>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-save mr-2"></i>
                        Salvar Configurações
                    </button>
                </div>
            </form>
        </div>

        <!-- Notifications Settings Tab -->
        <div id="tab-content-notifications" class="tab-content p-6 hidden">
            <form method="POST" action="/configuracoes/update">
                @csrf
                <div class="space-y-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="notifications_enabled" id="notifications_enabled" value="1" {{ $settings['notifications_enabled'] ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="notifications_enabled" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                            Habilitar Notificações
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="email_notifications" id="email_notifications" value="1" {{ $settings['email_notifications'] ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="email_notifications" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                            Notificações por Email
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="sms_notifications" id="sms_notifications" value="1" {{ $settings['sms_notifications'] ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="sms_notifications" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                            Notificações por SMS
                        </label>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-save mr-2"></i>
                        Salvar Configurações
                    </button>
                </div>
            </form>
        </div>

        <!-- Backup Settings Tab -->
        <div id="tab-content-backup" class="tab-content p-6 hidden">
            <div class="space-y-6">
                <div class="flex items-center">
                    <input type="checkbox" name="backup_enabled" id="backup_enabled" value="1" {{ $settings['backup_enabled'] ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="backup_enabled" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                        Habilitar Backup Automático
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="auto_backup" id="auto_backup" value="1" {{ $settings['auto_backup'] ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="auto_backup" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                        Backup Automático
                    </label>
                </div>

                <div>
                    <label for="backup_frequency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Frequência do Backup</label>
                    <select name="backup_frequency" id="backup_frequency" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="daily" {{ $settings['backup_frequency'] == 'daily' ? 'selected' : '' }}>Diário</option>
                        <option value="weekly" {{ $settings['backup_frequency'] == 'weekly' ? 'selected' : '' }}>Semanal</option>
                        <option value="monthly" {{ $settings['backup_frequency'] == 'monthly' ? 'selected' : '' }}>Mensal</option>
                    </select>
                </div>

                <div class="flex space-x-3">
                    <button type="button" onclick="initiateBackup()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-database mr-2"></i>
                        Iniciar Backup Manual
                    </button>
                    <button type="button" onclick="clearCache()" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <i class="fas fa-broom mr-2"></i>
                        Limpar Cache
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(content => content.classList.add('hidden'));

    // Remove active class from all tab buttons
    const tabButtons = document.querySelectorAll('.tab-button');
    tabButtons.forEach(button => {
        button.classList.remove('active', 'border-blue-500', 'text-blue-600', 'dark:text-blue-400');
        button.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
    });

    // Show selected tab content
    document.getElementById(`tab-content-${tabName}`).classList.remove('hidden');

    // Add active class to selected tab button
    const activeButton = document.getElementById(`tab-${tabName}`);
    activeButton.classList.add('active', 'border-blue-500', 'text-blue-600', 'dark:text-blue-400');
    activeButton.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
}

function initiateBackup() {
    if (confirm('Deseja iniciar um backup manual do sistema?')) {
        window.location.href = '/configuracoes/backup';
    }
}

function clearCache() {
    if (confirm('Deseja limpar o cache do sistema?')) {
        window.location.href = '/configuracoes/clear-cache';
    }
}
</script>
@endsection 