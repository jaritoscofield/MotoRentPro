<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Client;
use App\Models\Motorcycle;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with(['client', 'motorcycle']);

        // Filtro de busca
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('client', function($clientQuery) use ($search) {
                    $clientQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('motorcycle', function($motoQuery) use ($search) {
                    $motoQuery->where('name', 'like', "%{$search}%")
                              ->orWhere('license_plate', 'like', "%{$search}%");
                });
            });
        }

        // Filtro de status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro de data
        if ($request->filled('date_filter')) {
            switch ($request->date_filter) {
                case 'today':
                    $query->today();
                    break;
                case 'this_week':
                    $query->whereBetween('start_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('start_date', now()->month)->whereYear('start_date', now()->year);
                    break;
            }
        }

        // Ordenação
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        
        switch ($sort) {
            case 'client_name':
                $query->join('clients', 'reservations.client_id', '=', 'clients.id')
                      ->orderBy('clients.name', $direction)
                      ->select('reservations.*');
                break;
            case 'motorcycle_model':
                $query->join('motorcycles', 'reservations.motorcycle_id', '=', 'motorcycles.id')
                      ->orderBy('motorcycles.name', $direction)
                      ->select('reservations.*');
                break;
            case 'start_date':
                $query->orderBy('start_date', $direction);
                break;
            case 'total_amount':
                $query->orderBy('total_amount', $direction);
                break;
            case 'status':
                $query->orderBy('status', $direction);
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $reservations = $query->paginate(12);

        // Estatísticas
        $stats = [
            'today' => Reservation::today()->count(),
            'active' => Reservation::active()->count(),
            'pending' => Reservation::pending()->count(),
            'monthly_revenue' => Reservation::thisMonth()->sum('total_amount')
        ];

        // Dados para filtros
        $statuses = Reservation::distinct()->pluck('status');

        return view('modules.reservations.index', compact('reservations', 'statuses', 'stats'));
    }

    public function create()
    {
        $clients = Client::where('status', 'Ativo')->orderBy('name')->get();
        $motorcycles = Motorcycle::where('status', 'Disponível')->orderBy('name')->get();
        $statuses = ['Pendente', 'Ativa', 'Confirmada', 'Concluída', 'Cancelada'];

        return view('modules.reservations.create', compact('clients', 'motorcycles', 'statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'motorcycle_id' => 'required|exists:motorcycles,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'daily_rate' => 'required|numeric|min:0',
            'status' => 'required|in:Pendente,Ativa,Confirmada,Concluída,Cancelada',
            'notes' => 'nullable|string'
        ]);

        // Calcular total
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $days = $startDate->diffInDays($endDate) + 1;
        $totalAmount = $days * $request->daily_rate;

        $data = $request->all();
        $data['total_amount'] = $totalAmount;

        Reservation::create($data);

        return redirect('/reservas')->with('success', 'Reserva criada com sucesso!');
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['client', 'motorcycle']);
        return view('modules.reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        $clients = Client::where('status', 'Ativo')->orderBy('name')->get();
        $motorcycles = Motorcycle::where('status', 'Disponível')->orderBy('name')->get();
        $statuses = ['Pendente', 'Ativa', 'Confirmada', 'Concluída', 'Cancelada'];

        return view('modules.reservations.edit', compact('reservation', 'clients', 'motorcycles', 'statuses'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'motorcycle_id' => 'required|exists:motorcycles,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'daily_rate' => 'required|numeric|min:0',
            'status' => 'required|in:Pendente,Ativa,Confirmada,Concluída,Cancelada',
            'notes' => 'nullable|string'
        ]);

        // Calcular total
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $days = $startDate->diffInDays($endDate) + 1;
        $totalAmount = $days * $request->daily_rate;

        $data = $request->all();
        $data['total_amount'] = $totalAmount;

        $reservation->update($data);

        return redirect('/reservas')->with('success', 'Reserva atualizada com sucesso!');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect('/reservas')->with('success', 'Reserva removida com sucesso!');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('selected_reservations', []);
        
        if (empty($ids)) {
            return redirect('/reservas')->with('error', 'Nenhuma reserva selecionada.');
        }

        Reservation::whereIn('id', $ids)->delete();

        return redirect('/reservas')->with('success', count($ids) . ' reserva(s) removida(s) com sucesso!');
    }

    public function export()
    {
        $reservations = Reservation::with(['client', 'motorcycle'])->get();
        
        $filename = 'reservations_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($reservations) {
            $file = fopen('php://output', 'w');
            
            // Cabeçalho
            fputcsv($file, [
                'ID', 'Cliente', 'Moto', 'Data Início', 'Data Fim', 
                'Dias', 'Valor/Dia', 'Total', 'Status', 'Criado em'
            ]);

            // Dados
            foreach ($reservations as $reservation) {
                fputcsv($file, [
                    $reservation->id,
                    $reservation->client->name,
                    $reservation->motorcycle->name,
                    $reservation->start_date->format('d/m/Y'),
                    $reservation->end_date->format('d/m/Y'),
                    $reservation->duration_days,
                    $reservation->daily_rate,
                    $reservation->total_amount,
                    $reservation->status,
                    $reservation->created_at->format('d/m/Y')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function getMotorcycleRate(Request $request)
    {
        $motorcycle = Motorcycle::find($request->motorcycle_id);
        return response()->json(['daily_rate' => $motorcycle ? $motorcycle->daily_rate : 0]);
    }
} 