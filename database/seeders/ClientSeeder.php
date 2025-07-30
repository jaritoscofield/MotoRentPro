<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            [
                'name' => 'João Silva',
                'email' => 'joao.silva@email.com',
                'phone' => '(11) 99999-9999',
                'cnh' => '12345678900',
                'status' => 'Ativo',
                'total_rentals' => 15,
                'total_spent' => 2400.00,
                'last_rental_date' => '2024-01-28',
                'address' => 'Rua das Flores, 123 - São Paulo, SP',
                'birth_date' => '1985-03-15',
                'notes' => 'Cliente fiel, sempre pontual'
            ],
            [
                'name' => 'Maria Santos',
                'email' => 'maria.santos@email.com',
                'phone' => '(11) 88888-8888',
                'cnh' => '98765432100',
                'status' => 'Ativo',
                'total_rentals' => 8,
                'total_spent' => 1200.00,
                'last_rental_date' => '2024-01-25',
                'address' => 'Av. Paulista, 456 - São Paulo, SP',
                'birth_date' => '1990-07-22',
                'notes' => 'Prefere motos pequenas'
            ],
            [
                'name' => 'Pedro Costa',
                'email' => 'pedro.costa@email.com',
                'phone' => '(11) 77777-7777',
                'cnh' => '45678912300',
                'status' => 'Inativo',
                'total_rentals' => 3,
                'total_spent' => 450.00,
                'last_rental_date' => '2023-12-15',
                'address' => 'Rua Augusta, 789 - São Paulo, SP',
                'birth_date' => '1988-11-10',
                'notes' => 'Não aluga há mais de 1 mês'
            ],
            [
                'name' => 'Ana Lima',
                'email' => 'ana.lima@email.com',
                'phone' => '(11) 66666-6666',
                'cnh' => '78912345600',
                'status' => 'Ativo',
                'total_rentals' => 22,
                'total_spent' => 3800.00,
                'last_rental_date' => '2024-01-30',
                'address' => 'Rua Oscar Freire, 321 - São Paulo, SP',
                'birth_date' => '1992-05-18',
                'notes' => 'Cliente VIP, aluga frequentemente'
            ]
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
} 