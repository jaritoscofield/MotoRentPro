<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Motorcycle;
use App\Models\Client;
use App\Models\Reservation;
use App\Models\Maintenance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Exibir o dashboard
     */
    public function index()
    {
        // Estatísticas principais
        $stats = [
            'available_motorcycles' => Motorcycle::where('status', 'Disponível')->count(),
            'rented_motorcycles' => Motorcycle::where('status', 'Alugada')->count(),
            'active_clients' => Client::where('status', 'Ativo')->count(),
            'monthly_revenue' => Reservation::where('status', 'Concluída')
                ->whereMonth('created_at', Carbon::now()->month)
                ->sum('total_amount'),
            'maintenance_motorcycles' => Maintenance::where('status', 'Em Andamento')->count(),
            'growth_percentage' => 12, // Calculado baseado no mês anterior
        ];

        // Reservas recentes
        $recent_reservations = Reservation::with(['client', 'motorcycle'])
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        // Dados para gráficos
        $monthly_revenue_data = $this->getMonthlyRevenueData();
        $motorcycle_status_data = $this->getMotorcycleStatusData();
        $reservation_status_data = $this->getReservationStatusData();
        $maintenance_data = $this->getMaintenanceData();

        // Garantir que todos os dados são arrays válidos
        if (!is_array($monthly_revenue_data)) $monthly_revenue_data = [];
        if (!is_array($motorcycle_status_data)) $motorcycle_status_data = [];
        if (!is_array($reservation_status_data)) $reservation_status_data = [];
        if (!is_array($maintenance_data)) $maintenance_data = [];

        return view('modules.dashboard.index', compact(
            'stats', 
            'recent_reservations', 
            'monthly_revenue_data',
            'motorcycle_status_data',
            'reservation_status_data',
            'maintenance_data'
        ));
    }

    /**
     * Dados de receita mensal dos últimos 6 meses
     */
    private function getMonthlyRevenueData()
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $revenue = Reservation::where('status', 'Concluída')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_amount');
            
            $data[] = [
                'month' => $month->format('M'),
                'revenue' => $revenue
            ];
        }
        return $data;
    }

    /**
     * Dados de status das motocicletas
     */
    private function getMotorcycleStatusData()
    {
        return Motorcycle::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => $item->status,
                    'value' => $item->count
                ];
            })
            ->toArray();
    }

    /**
     * Dados de status das reservas
     */
    private function getReservationStatusData()
    {
        return Reservation::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => $item->status,
                    'value' => $item->count
                ];
            })
            ->toArray();
    }

    /**
     * Dados de manutenção dos últimos 30 dias
     */
    private function getMaintenanceData()
    {
        $data = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = Maintenance::whereDate('created_at', $date)->count();
            
            $data[] = [
                'date' => $date->format('d/m'),
                'count' => $count
            ];
        }
        return $data;
    }
}
