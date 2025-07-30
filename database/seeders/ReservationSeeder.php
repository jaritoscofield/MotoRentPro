<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\Client;
use App\Models\Motorcycle;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        // Buscar clientes e motos existentes
        $clients = Client::all();
        $motorcycles = Motorcycle::all();

        if ($clients->isEmpty() || $motorcycles->isEmpty()) {
            return; // Não criar reservas se não houver clientes ou motos
        }

        $reservations = [
            [
                'client_id' => $clients->where('name', 'João Silva')->first()->id ?? $clients->first()->id,
                'motorcycle_id' => $motorcycles->where('name', 'Honda CB 600F Hornet')->first()->id ?? $motorcycles->first()->id,
                'start_date' => '2024-01-31',
                'end_date' => '2024-02-04',
                'daily_rate' => 120.00,
                'total_amount' => 600.00,
                'status' => 'Ativa',
                'notes' => 'Reserva para viagem de negócios'
            ],
            [
                'client_id' => $clients->where('name', 'Maria Santos')->first()->id ?? $clients->first()->id,
                'motorcycle_id' => $motorcycles->where('name', 'Kawasaki Ninja 650')->first()->id ?? $motorcycles->first()->id,
                'start_date' => '2024-02-02',
                'end_date' => '2024-02-09',
                'daily_rate' => 150.00,
                'total_amount' => 1200.00,
                'status' => 'Confirmada',
                'notes' => 'Reserva confirmada com pagamento antecipado'
            ],
            [
                'client_id' => $clients->where('name', 'Pedro Costa')->first()->id ?? $clients->first()->id,
                'motorcycle_id' => $motorcycles->where('name', 'Honda CB 250F')->first()->id ?? $motorcycles->first()->id,
                'start_date' => '2024-02-04',
                'end_date' => '2024-02-07',
                'daily_rate' => 80.00,
                'total_amount' => 320.00,
                'status' => 'Pendente',
                'notes' => 'Aguardando confirmação do cliente'
            ],
            [
                'client_id' => $clients->where('name', 'Ana Lima')->first()->id ?? $clients->first()->id,
                'motorcycle_id' => $motorcycles->where('name', 'Yamaha Factor 150')->first()->id ?? $motorcycles->first()->id,
                'start_date' => '2024-01-19',
                'end_date' => '2024-01-24',
                'daily_rate' => 60.00,
                'total_amount' => 360.00,
                'status' => 'Concluída',
                'notes' => 'Reserva finalizada com sucesso'
            ]
        ];

        foreach ($reservations as $reservation) {
            Reservation::create($reservation);
        }
    }
} 