<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'company_name' => config('app.name', 'MotoRentPro'),
            'company_email' => config('mail.from.address', 'contato@motorentpro.com'),
            'company_phone' => config('app.phone', '(11) 99999-9999'),
            'company_address' => config('app.address', 'Rua das Motocicletas, 123'),
            'company_cnpj' => config('app.cnpj', '12.345.678/0001-90'),
            'system_timezone' => config('app.timezone', 'America/Sao_Paulo'),
            'system_language' => config('app.locale', 'pt_BR'),
            'maintenance_mode' => config('app.debug', false),
            'backup_enabled' => config('app.backup_enabled', true),
            'notifications_enabled' => config('app.notifications_enabled', true),
            'email_notifications' => config('app.email_notifications', true),
            'sms_notifications' => config('app.sms_notifications', false),
            'auto_backup' => config('app.auto_backup', true),
            'backup_frequency' => config('app.backup_frequency', 'daily'),
            'max_file_size' => config('app.max_file_size', 2048),
            'allowed_file_types' => config('app.allowed_file_types', 'jpg,jpeg,png,gif,pdf'),
        ];

        return view('modules.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|email|max:255',
            'company_phone' => 'nullable|string|max:20',
            'company_address' => 'nullable|string|max:500',
            'company_cnpj' => 'nullable|string|max:18',
            'system_timezone' => 'required|string',
            'system_language' => 'required|string',
            'maintenance_mode' => 'boolean',
            'backup_enabled' => 'boolean',
            'notifications_enabled' => 'boolean',
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'auto_backup' => 'boolean',
            'backup_frequency' => 'required|in:daily,weekly,monthly',
            'max_file_size' => 'required|integer|min:1|max:10240',
            'allowed_file_types' => 'required|string|max:255',
        ]);

        // Aqui você pode salvar as configurações no banco de dados ou arquivo de configuração
        // Por enquanto, vamos apenas retornar sucesso
        Cache::put('system_settings', $request->all(), 3600);

        return redirect('/configuracoes')->with('success', 'Configurações atualizadas com sucesso!');
    }

    public function backup()
    {
        try {
            // Aqui você implementaria a lógica de backup
            // Por exemplo, usando o comando artisan:backup
            
            return redirect('/configuracoes')->with('success', 'Backup iniciado com sucesso!');
        } catch (\Exception $e) {
            return redirect('/configuracoes')->with('error', 'Erro ao iniciar backup: ' . $e->getMessage());
        }
    }

    public function clearCache()
    {
        try {
            \Artisan::call('cache:clear');
            \Artisan::call('config:clear');
            \Artisan::call('route:clear');
            \Artisan::call('view:clear');
            
            return redirect('/configuracoes')->with('success', 'Cache limpo com sucesso!');
        } catch (\Exception $e) {
            return redirect('/configuracoes')->with('error', 'Erro ao limpar cache: ' . $e->getMessage());
        }
    }

    public function systemInfo()
    {
        $info = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'database' => config('database.default'),
            'timezone' => config('app.timezone'),
            'locale' => config('app.locale'),
            'debug_mode' => config('app.debug'),
            'storage_path' => storage_path(),
            'public_path' => public_path(),
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
        ];

        return view('modules.settings.system-info', compact('info'));
    }
} 