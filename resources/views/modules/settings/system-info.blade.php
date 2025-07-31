@extends('layouts.dashboard')

@section('title', 'Informações do Sistema - MotoRentPro')
@section('page-title', 'Informações do Sistema')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Informações do Sistema</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Detalhes técnicos e configurações do sistema</p>
            </div>
            <a href="/configuracoes" class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i>
                Voltar
            </a>
        </div>
    </div>

    <!-- System Information -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Application Information -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Informações da Aplicação</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Versão do PHP</span>
                        <span class="text-sm text-gray-900 dark:text-gray-100">{{ $info['php_version'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Versão do Laravel</span>
                        <span class="text-sm text-gray-900 dark:text-gray-100">{{ $info['laravel_version'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Servidor Web</span>
                        <span class="text-sm text-gray-900 dark:text-gray-100">{{ $info['server'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Fuso Horário</span>
                        <span class="text-sm text-gray-900 dark:text-gray-100">{{ $info['timezone'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Idioma</span>
                        <span class="text-sm text-gray-900 dark:text-gray-100">{{ $info['locale'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Modo Debug</span>
                        <span class="text-sm">
                            @if($info['debug_mode'])
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/40 text-yellow-800 dark:text-yellow-300">
                                    Ativado
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300">
                                    Desativado
                                </span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Database Information -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Banco de Dados</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Tipo</span>
                        <span class="text-sm text-gray-900 dark:text-gray-100">{{ ucfirst($info['database']) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Host</span>
                        <span class="text-sm text-gray-900 dark:text-gray-100">{{ config('database.connections.' . $info['database'] . '.host', 'N/A') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Porta</span>
                        <span class="text-sm text-gray-900 dark:text-gray-100">{{ config('database.connections.' . $info['database'] . '.port', 'N/A') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Nome do Banco</span>
                        <span class="text-sm text-gray-900 dark:text-gray-100">{{ config('database.connections.' . $info['database'] . '.database', 'N/A') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- File System Information -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Sistema de Arquivos</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Storage Path</span>
                        <span class="text-sm text-gray-900 dark:text-gray-100">{{ $info['storage_path'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Public Path</span>
                        <span class="text-sm text-gray-900 dark:text-gray-100">{{ $info['public_path'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Tamanho Máximo de Upload</span>
                        <span class="text-sm text-gray-900 dark:text-gray-100">{{ $info['upload_max_filesize'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Tamanho Máximo de POST</span>
                        <span class="text-sm text-gray-900 dark:text-gray-100">{{ $info['post_max_size'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Information -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Performance</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Limite de Memória</span>
                        <span class="text-sm text-gray-900 dark:text-gray-100">{{ $info['memory_limit'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Tempo Máximo de Execução</span>
                        <span class="text-sm text-gray-900 dark:text-gray-100">{{ $info['max_execution_time'] }}s</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Status do Sistema</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/40 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-check text-green-600 dark:text-green-400 text-xl"></i>
                    </div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">Sistema Online</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Funcionando normalmente</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/40 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-database text-blue-600 dark:text-blue-400 text-xl"></i>
                    </div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">Banco de Dados</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Conectado</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/40 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-shield-alt text-yellow-600 dark:text-yellow-400 text-xl"></i>
                    </div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">Segurança</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Configurada</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Ações Rápidas</h3>
        </div>
        <div class="p-6">
            <div class="flex flex-wrap gap-3">
                <button onclick="clearCache()" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <i class="fas fa-broom mr-2"></i>
                    Limpar Cache
                </button>
                <button onclick="optimizeSystem()" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <i class="fas fa-tools mr-2"></i>
                    Otimizar Sistema
                </button>
                <button onclick="checkUpdates()" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <i class="fas fa-sync mr-2"></i>
                    Verificar Atualizações
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function clearCache() {
    if (confirm('Deseja limpar o cache do sistema?')) {
        window.location.href = '/configuracoes/clear-cache';
    }
}

function optimizeSystem() {
    alert('Funcionalidade de otimização será implementada');
}

function checkUpdates() {
    alert('Funcionalidade de verificação de atualizações será implementada');
}
</script>
@endsection 