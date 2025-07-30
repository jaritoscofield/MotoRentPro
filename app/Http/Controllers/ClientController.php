<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::query();

        // Filtro de busca
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filtro de status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Ordenação
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');
        
        switch ($sort) {
            case 'name':
                $query->orderBy('name', $direction);
                break;
            case 'total_rentals':
                $query->orderBy('total_rentals', $direction);
                break;
            case 'total_spent':
                $query->orderBy('total_spent', $direction);
                break;
            case 'last_rental_date':
                $query->orderBy('last_rental_date', $direction);
                break;
            default:
                $query->orderBy('name', 'asc');
        }

        $clients = $query->paginate(12);

        // Dados para filtros
        $statuses = Client::distinct()->pluck('status');

        return view('modules.clients.index', compact('clients', 'statuses'));
    }

    public function create()
    {
        $statuses = ['Ativo', 'Inativo', 'Bloqueado'];

        return view('modules.clients.create', compact('statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients',
            'phone' => 'required|string|max:20',
            'cnh' => 'required|string|max:20|unique:clients',
            'status' => 'required|in:Ativo,Inativo,Bloqueado',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        $data = $request->all();
        $data['total_rentals'] = 0;
        $data['total_spent'] = 0.00;

        Client::create($data);

        return redirect('/clientes')->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function show(Client $client)
    {
        return view('modules.clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        $statuses = ['Ativo', 'Inativo', 'Bloqueado'];

        return view('modules.clients.edit', compact('client', 'statuses'));
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'phone' => 'required|string|max:20',
            'cnh' => 'required|string|max:20|unique:clients,cnh,' . $client->id,
            'status' => 'required|in:Ativo,Inativo,Bloqueado',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        $client->update($request->all());

        return redirect('/clientes')->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect('/clientes')->with('success', 'Cliente removido com sucesso!');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('selected_clients', []);
        
        if (empty($ids)) {
            return redirect('/clientes')->with('error', 'Nenhum cliente selecionado.');
        }

        Client::whereIn('id', $ids)->delete();

        return redirect('/clientes')->with('success', count($ids) . ' cliente(s) removido(s) com sucesso!');
    }

    public function export()
    {
        $clients = Client::all();
        
        $filename = 'clients_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($clients) {
            $file = fopen('php://output', 'w');
            
            // Cabeçalho
            fputcsv($file, [
                'ID', 'Nome', 'Email', 'Telefone', 'CNH', 'Status', 
                'Total Aluguéis', 'Total Gasto', 'Último Aluguel'
            ]);

            // Dados
            foreach ($clients as $client) {
                fputcsv($file, [
                    $client->id,
                    $client->name,
                    $client->email,
                    $client->phone,
                    $client->cnh,
                    $client->status,
                    $client->total_rentals,
                    $client->total_spent,
                    $client->last_rental_date
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
} 