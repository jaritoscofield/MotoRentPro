<?php

namespace App\Http\Controllers;

use App\Models\Motorcycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MotorcycleController extends Controller
{
    public function index(Request $request)
    {
        $query = Motorcycle::query();

        // Filtro de busca
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('license_plate', 'like', "%{$search}%")
                  ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        // Filtro de status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro de categoria
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filtro de combustível
        if ($request->filled('fuel')) {
            $query->where('fuel', $request->fuel);
        }

        // Filtro de preço
        if ($request->filled('min_price')) {
            $query->where('daily_rate', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('daily_rate', '<=', $request->max_price);
        }

        // Ordenação
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');
        
        switch ($sort) {
            case 'name':
                $query->orderBy('name', $direction);
                break;
            case 'price':
                $query->orderBy('daily_rate', $direction);
                break;
            case 'year':
                $query->orderBy('year', $direction);
                break;
            case 'mileage':
                $query->orderBy('mileage', $direction);
                break;
            case 'rating':
                $query->orderBy('rating', $direction);
                break;
            default:
                $query->orderBy('name', 'asc');
        }

        $motorcycles = $query->paginate(12);

        // Dados para filtros
        $statuses = Motorcycle::distinct()->pluck('status');
        $categories = Motorcycle::distinct()->pluck('category');
        $fuels = Motorcycle::distinct()->pluck('fuel');

        return view('modules.motorcycles.index', compact('motorcycles', 'statuses', 'categories', 'fuels'));
    }

    public function create()
    {
        $statuses = ['Disponível', 'Alugada', 'Manutenção', 'Inativa'];
        $categories = ['Urbana', 'Esportiva', 'Custom', 'Trail'];
        $fuels = ['Flex', 'Gasolina', 'Elétrica', 'Híbrida'];
        $tags = ['economica', 'iniciante', 'popular', 'esportiva', 'sustentavel', 'silenciosa', 'moderna', 'urbana', 'potente', 'experiente', 'custom', 'luxo'];

        return view('modules.motorcycles.create', compact('statuses', 'categories', 'fuels', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'license_plate' => 'required|string|max:20|unique:motorcycles',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'status' => 'required|in:Disponível,Alugada,Manutenção,Inativa',
            'rating' => 'nullable|numeric|min:0|max:5',
            'tags' => 'nullable|array',
            'category' => 'required|in:Urbana,Esportiva,Custom,Trail',
            'fuel' => 'required|in:Flex,Gasolina,Elétrica,Híbrida',
            'mileage' => 'required|integer|min:0',
            'daily_rate' => 'required|numeric|min:0',
            'total_rentals' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $data = $request->all();
        
        // Upload da imagem
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('motorcycles', 'public');
            $data['image'] = $imagePath;
            
            // Copiar para pasta public
            $imageName = basename($imagePath);
            $sourcePath = storage_path('app/public/' . $imagePath);
            $destPath = public_path('motorcycles/' . $imageName);
            
            if (!is_dir(public_path('motorcycles'))) {
                mkdir(public_path('motorcycles'), 0755, true);
            }
            
            copy($sourcePath, $destPath);
            
            // Log para debug
            \Log::info('Imagem salva:', [
                'path' => $imagePath,
                'full_path' => storage_path('app/public/' . $imagePath),
                'public_path' => $destPath,
                'exists' => file_exists(storage_path('app/public/' . $imagePath))
            ]);
        }

        Motorcycle::create($data);

        return redirect('/frota')->with('success', 'Motocicleta cadastrada com sucesso!');
    }

    public function show(Motorcycle $motorcycle)
    {
        return view('modules.motorcycles.show', compact('motorcycle'));
    }

    public function edit(Motorcycle $motorcycle)
    {
        $statuses = ['Disponível', 'Alugada', 'Manutenção', 'Inativa'];
        $categories = ['Urbana', 'Esportiva', 'Custom', 'Trail'];
        $fuels = ['Flex', 'Gasolina', 'Elétrica', 'Híbrida'];
        $tags = ['economica', 'iniciante', 'popular', 'esportiva', 'sustentavel', 'silenciosa', 'moderna', 'urbana', 'potente', 'experiente', 'custom', 'luxo'];

        return view('modules.motorcycles.edit', compact('motorcycle', 'statuses', 'categories', 'fuels', 'tags'));
    }

    public function update(Request $request, Motorcycle $motorcycle)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'license_plate' => 'required|string|max:20|unique:motorcycles,license_plate,' . $motorcycle->id,
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'status' => 'required|in:Disponível,Alugada,Manutenção,Inativa',
            'rating' => 'nullable|numeric|min:0|max:5',
            'tags' => 'nullable|array',
            'category' => 'required|in:Urbana,Esportiva,Custom,Trail',
            'fuel' => 'required|in:Flex,Gasolina,Elétrica,Híbrida',
            'mileage' => 'required|integer|min:0',
            'daily_rate' => 'required|numeric|min:0',
            'total_rentals' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $data = $request->all();
        
        // Upload da nova imagem
        if ($request->hasFile('image')) {
            // Remove imagem antiga
            if ($motorcycle->image) {
                Storage::disk('public')->delete($motorcycle->image);
                $oldImageName = basename($motorcycle->image);
                $oldPublicPath = public_path('motorcycles/' . $oldImageName);
                if (file_exists($oldPublicPath)) {
                    unlink($oldPublicPath);
                }
            }
            
            $imagePath = $request->file('image')->store('motorcycles', 'public');
            $data['image'] = $imagePath;
            
            // Copiar para pasta public
            $imageName = basename($imagePath);
            $sourcePath = storage_path('app/public/' . $imagePath);
            $destPath = public_path('motorcycles/' . $imageName);
            
            if (!is_dir(public_path('motorcycles'))) {
                mkdir(public_path('motorcycles'), 0755, true);
            }
            
            copy($sourcePath, $destPath);
            
            // Log para debug
            \Log::info('Imagem atualizada:', [
                'path' => $imagePath,
                'full_path' => storage_path('app/public/' . $imagePath),
                'public_path' => $destPath,
                'exists' => file_exists(storage_path('app/public/' . $imagePath))
            ]);
        }

        $motorcycle->update($data);

        return redirect('/frota')->with('success', 'Motocicleta atualizada com sucesso!');
    }

    public function destroy(Motorcycle $motorcycle)
    {
        // Remove imagem se existir
        if ($motorcycle->image) {
            Storage::disk('public')->delete($motorcycle->image);
        }

        $motorcycle->delete();

        return redirect('/frota')->with('success', 'Motocicleta removida com sucesso!');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('selected_motorcycles', []);
        
        if (empty($ids)) {
            return redirect('/frota')->with('error', 'Nenhuma motocicleta selecionada.');
        }

        $motorcycles = Motorcycle::whereIn('id', $ids)->get();
        
        foreach ($motorcycles as $motorcycle) {
            if ($motorcycle->image) {
                Storage::disk('public')->delete($motorcycle->image);
            }
            $motorcycle->delete();
        }

        return redirect('/frota')->with('success', count($ids) . ' motocicleta(s) removida(s) com sucesso!');
    }

    public function export()
    {
        $motorcycles = Motorcycle::all();
        
        $filename = 'motorcycles_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($motorcycles) {
            $file = fopen('php://output', 'w');
            
            // Cabeçalho
            fputcsv($file, [
                'ID', 'Nome', 'Placa', 'Ano', 'Status', 'Avaliação', 'Tags', 
                'Categoria', 'Combustível', 'Quilometragem', 'Diária', 'Total Aluguéis'
            ]);

            // Dados
            foreach ($motorcycles as $motorcycle) {
                fputcsv($file, [
                    $motorcycle->id,
                    $motorcycle->name,
                    $motorcycle->license_plate,
                    $motorcycle->year,
                    $motorcycle->status,
                    $motorcycle->rating,
                    implode(', ', $motorcycle->tags ?? []),
                    $motorcycle->category,
                    $motorcycle->fuel,
                    $motorcycle->mileage,
                    $motorcycle->daily_rate,
                    $motorcycle->total_rentals
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
} 