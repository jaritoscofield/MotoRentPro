<?php

namespace App\Http\Controllers;

use App\Models\Motorcycle;
use App\Models\Client;
use App\Models\Reservation;
use App\Models\Maintenance;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 30);
        $startDate = null;
        $endDate = null;

        if ($period === 'custom') {
            $startDate = $request->get('start_date');
            $endDate = $request->get('end_date');
        } else {
            $endDate = Carbon::now();
            $startDate = Carbon::now()->subDays($period);
        }

        // Estatísticas gerais
        $stats = [
            'total_motorcycles' => Motorcycle::count(),
            'active_motorcycles' => Motorcycle::where('status', 'Disponível')->count(),
            'maintenance_motorcycles' => Motorcycle::where('status', 'Manutenção')->count(),
            'total_clients' => Client::count(),
            'active_clients' => Client::where('status', 'Ativo')->count(),
            'total_reservations' => Reservation::count(),
            'active_reservations' => Reservation::where('status', 'Ativa')->count(),
            'completed_reservations' => Reservation::where('status', 'Concluída')->count(),
            'total_maintenances' => Maintenance::count(),
            'active_maintenances' => Maintenance::where('status', 'Em Andamento')->count(),
            'completed_maintenances' => Maintenance::where('status', 'Concluída')->count(),
            'total_payments' => Payment::count(),
            'total_revenue' => Payment::sum('total_amount'),
            'total_received' => Payment::where('status', 'concluida')->sum('total_amount'),
            'pending_amount' => Payment::where('status', 'ativa')->sum('total_amount'),
        ];

        // Dados para gráficos
        $revenueChart = $this->getRevenueChartData($startDate, $endDate);
        $reservationsChart = $this->getReservationsChartData($startDate, $endDate);
        $maintenanceChart = $this->getMaintenanceChartData($startDate, $endDate);

        // Top performers
        $topMotorcycles = Motorcycle::withCount('reservations')
            ->orderBy('reservations_count', 'desc')
            ->limit(5)
            ->get();

        $topClients = Client::withCount('reservations')
            ->orderBy('reservations_count', 'desc')
            ->limit(5)
            ->get();

        $topRevenueMotorcycles = Payment::select('motorcycle_id', DB::raw('SUM(total_amount) as total_revenue'))
            ->with('motorcycle')
            ->groupBy('motorcycle_id')
            ->orderBy('total_revenue', 'desc')
            ->limit(5)
            ->get();

        // Atividade recente
        $recentActivity = collect();

        // Reservas recentes
        $recentReservations = Reservation::with(['client', 'motorcycle'])
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($reservation) {
                return [
                    'type' => 'reservation',
                    'title' => 'Nova Reserva',
                    'description' => "Cliente {$reservation->client->name} reservou {$reservation->motorcycle->name}",
                    'date' => $reservation->created_at,
                    'status' => $reservation->status,
                    'amount' => $reservation->total_amount
                ];
            });

        // Manutenções recentes
        $recentMaintenances = Maintenance::with(['motorcycle'])
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($maintenance) {
                return [
                    'type' => 'maintenance',
                    'title' => 'Manutenção',
                    'description' => "Manutenção em {$maintenance->motorcycle->name}",
                    'date' => $maintenance->created_at,
                    'status' => $maintenance->status,
                    'amount' => $maintenance->cost
                ];
            });

        // Pagamentos recentes
        $recentPayments = Payment::with(['client', 'motorcycle'])
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($payment) {
                return [
                    'type' => 'payment',
                    'title' => 'Pagamento',
                    'description' => "Pagamento de {$payment->client->name} - {$payment->motorcycle->name}",
                    'date' => $payment->created_at,
                    'status' => $payment->status,
                    'amount' => $payment->total_amount
                ];
            });

        $recentActivity = $recentReservations->concat($recentMaintenances)->concat($recentPayments)
            ->sortByDesc('date')
            ->take(10);

        return view('modules.reports.index', compact(
            'stats',
            'revenueChart',
            'reservationsChart',
            'maintenanceChart',
            'topMotorcycles',
            'topClients',
            'topRevenueMotorcycles',
            'recentActivity',
            'period',
            'startDate',
            'endDate'
        ));
    }

    private function getRevenueChartData($startDate, $endDate)
    {
        if (!$startDate || !$endDate) {
            return ['labels' => [], 'data' => []];
        }

        $data = Payment::selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = [];
        $revenue = [];

        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $labels[] = $currentDate->format('d/m');
            $dayData = $data->where('date', $currentDate->format('Y-m-d'))->first();
            $revenue[] = $dayData ? $dayData->revenue : 0;
            $currentDate->addDay();
        }

        return [
            'labels' => $labels,
            'data' => $revenue
        ];
    }

    private function getReservationsChartData($startDate, $endDate)
    {
        if (!$startDate || !$endDate) {
            return ['labels' => [], 'data' => []];
        }

        $data = Reservation::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = [];
        $counts = [];

        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $labels[] = $currentDate->format('d/m');
            $dayData = $data->where('date', $currentDate->format('Y-m-d'))->first();
            $counts[] = $dayData ? $dayData->count : 0;
            $currentDate->addDay();
        }

        return [
            'labels' => $labels,
            'data' => $counts
        ];
    }

    private function getMaintenanceChartData($startDate, $endDate)
    {
        if (!$startDate || !$endDate) {
            return ['labels' => [], 'data' => []];
        }

        $data = Maintenance::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = [];
        $counts = [];

        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $labels[] = $currentDate->format('d/m');
            $dayData = $data->where('date', $currentDate->format('Y-m-d'))->first();
            $counts[] = $dayData ? $dayData->count : 0;
            $currentDate->addDay();
        }

        return [
            'labels' => $labels,
            'data' => $counts
        ];
    }
} 