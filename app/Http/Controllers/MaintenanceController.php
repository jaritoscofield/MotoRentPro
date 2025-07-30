<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Motorcycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Maintenance::with('motorcycle');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('technician', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%")
                  ->orWhereHas('motorcycle', function($motoQuery) use ($search) {
                      $motoQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('license_plate', 'like', "%{$search}%");
                  });
            });
        }

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('date_from')) {
            $query->where('scheduled_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('scheduled_date', '<=', $request->date_to);
        }

        // Sorting
        $sortBy = $request->get('sort', 'scheduled_date');
        $direction = $request->get('direction', 'asc');

        switch ($sortBy) {
            case 'motorcycle_name':
                $query->join('motorcycles', 'maintenances.motorcycle_id', '=', 'motorcycles.id')
                      ->orderBy('motorcycles.name', $direction)
                      ->select('maintenances.*');
                break;
            case 'motorcycle_plate':
                $query->join('motorcycles', 'maintenances.motorcycle_id', '=', 'motorcycles.id')
                      ->orderBy('motorcycles.license_plate', $direction)
                      ->select('maintenances.*');
                break;
            default:
                $query->orderBy($sortBy, $direction);
        }

        $maintenances = $query->paginate(10);

        // Statistics
        $stats = [
            'total' => Maintenance::count(),
            'pending' => Maintenance::pending()->count(),
            'completed' => Maintenance::completed()->count(),
            'overdue' => Maintenance::overdue()->count(),
            'this_month' => Maintenance::thisMonth()->count(),
            'total_cost' => Maintenance::completed()->sum('cost'),
            'avg_cost' => Maintenance::completed()->avg('cost') ?? 0,
        ];

        return view('modules.maintenances.index', compact('maintenances', 'stats'));
    }

    public function create()
    {
        $motorcycles = Motorcycle::orderBy('name')->get();
        $types = ['Preventiva', 'Corretiva', 'Emergencial', 'Inspeção', 'Revisão'];
        $statuses = ['Agendada', 'Em Andamento', 'Concluída', 'Cancelada'];
        $priorities = ['Baixa', 'Média', 'Alta', 'Crítica'];

        return view('modules.maintenances.create', compact('motorcycles', 'types', 'statuses', 'priorities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'motorcycle_id' => 'required|exists:motorcycles,id',
            'type' => 'required|in:Preventiva,Corretiva,Emergencial,Inspeção,Revisão',
            'description' => 'required|string|max:1000',
            'scheduled_date' => 'required|date',
            'completed_date' => 'nullable|date|after_or_equal:scheduled_date',
            'cost' => 'nullable|numeric|min:0',
            'status' => 'required|in:Agendada,Em Andamento,Concluída,Cancelada',
            'priority' => 'required|in:Baixa,Média,Alta,Crítica',
            'technician' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'parts_used' => 'nullable|string|max:1000',
            'labor_hours' => 'nullable|numeric|min:0',
            'next_maintenance_date' => 'nullable|date|after:scheduled_date',
            'mileage_at_service' => 'nullable|integer|min:0',
        ]);

        $maintenance = Maintenance::create($request->all());

        return redirect('/manutencao')->with('success', 'Manutenção criada com sucesso!');
    }

    public function show(Maintenance $maintenance)
    {
        $maintenance->load('motorcycle');
        return view('modules.maintenances.show', compact('maintenance'));
    }

    public function edit(Maintenance $maintenance)
    {
        $motorcycles = Motorcycle::orderBy('name')->get();
        $types = ['Preventiva', 'Corretiva', 'Emergencial', 'Inspeção', 'Revisão'];
        $statuses = ['Agendada', 'Em Andamento', 'Concluída', 'Cancelada'];
        $priorities = ['Baixa', 'Média', 'Alta', 'Crítica'];

        return view('modules.maintenances.edit', compact('maintenance', 'motorcycles', 'types', 'statuses', 'priorities'));
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        $request->validate([
            'motorcycle_id' => 'required|exists:motorcycles,id',
            'type' => 'required|in:Preventiva,Corretiva,Emergencial,Inspeção,Revisão',
            'description' => 'required|string|max:1000',
            'scheduled_date' => 'required|date',
            'completed_date' => 'nullable|date|after_or_equal:scheduled_date',
            'cost' => 'nullable|numeric|min:0',
            'status' => 'required|in:Agendada,Em Andamento,Concluída,Cancelada',
            'priority' => 'required|in:Baixa,Média,Alta,Crítica',
            'technician' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'parts_used' => 'nullable|string|max:1000',
            'labor_hours' => 'nullable|numeric|min:0',
            'next_maintenance_date' => 'nullable|date|after:scheduled_date',
            'mileage_at_service' => 'nullable|integer|min:0',
        ]);

        $maintenance->update($request->all());

        return redirect('/manutencao')->with('success', 'Manutenção atualizada com sucesso!');
    }

    public function destroy(Maintenance $maintenance)
    {
        $maintenance->delete();
        return redirect('/manutencao')->with('success', 'Manutenção excluída com sucesso!');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:maintenances,id'
        ]);

        Maintenance::whereIn('id', $request->ids)->delete();

        return redirect('/manutencao')->with('success', 'Manutenções excluídas com sucesso!');
    }

    public function export()
    {
        $maintenances = Maintenance::with('motorcycle')->get();

        $filename = 'manutencoes_' . date('Y-m-d_H-i-s') . '.csv';
        $filepath = storage_path('app/public/' . $filename);

        $file = fopen($filepath, 'w');

        // Header
        fputcsv($file, [
            'ID',
            'Motocicleta',
            'Placa',
            'Tipo',
            'Descrição',
            'Data Agendada',
            'Data Conclusão',
            'Custo',
            'Status',
            'Prioridade',
            'Técnico',
            'Horas Trabalho',
            'Próxima Manutenção',
            'Quilometragem',
            'Criado em'
        ]);

        // Data
        foreach ($maintenances as $maintenance) {
            fputcsv($file, [
                $maintenance->id,
                $maintenance->motorcycle->name,
                $maintenance->motorcycle->license_plate,
                $maintenance->type,
                $maintenance->description,
                $maintenance->scheduled_date->format('d/m/Y'),
                $maintenance->completed_date ? $maintenance->completed_date->format('d/m/Y') : '-',
                $maintenance->cost,
                $maintenance->status,
                $maintenance->priority,
                $maintenance->technician ?? '-',
                $maintenance->labor_hours ?? '-',
                $maintenance->next_maintenance_date ? $maintenance->next_maintenance_date->format('d/m/Y') : '-',
                $maintenance->mileage_at_service ?? '-',
                $maintenance->created_at->format('d/m/Y H:i')
            ]);
        }

        fclose($file);

        return response()->download($filepath)->deleteFileAfterSend();
    }
} 