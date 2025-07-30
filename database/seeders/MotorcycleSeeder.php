<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Motorcycle;

class MotorcycleSeeder extends Seeder
{
    public function run()
    {
        $motorcycles = [
            [
                'name' => 'Honda CB 250F',
                'license_plate' => 'GHI-9012',
                'year' => 2021,
                'status' => 'Manutenção',
                'rating' => 4.5,
                'tags' => ['economica', 'iniciante'],
                'category' => 'Urbana',
                'fuel' => 'Flex',
                'mileage' => 22000,
                'daily_rate' => 80.00,
                'total_rentals' => 67
            ],
            [
                'name' => 'Honda CB 600F Hornet',
                'license_plate' => 'ABC-1234',
                'year' => 2022,
                'status' => 'Disponível',
                'rating' => 4.8,
                'tags' => ['popular', 'esportiva', 'iniciante'],
                'category' => 'Esportiva',
                'fuel' => 'Gasolina',
                'mileage' => 15000,
                'daily_rate' => 120.00,
                'total_rentals' => 45
            ],
            [
                'name' => 'Voltz Eco Plus',
                'license_plate' => 'ELT-0001',
                'year' => 2023,
                'status' => 'Disponível',
                'rating' => 4.6,
                'tags' => ['sustentavel', 'silenciosa', 'moderna'],
                'category' => 'Urbana',
                'fuel' => 'Elétrica',
                'mileage' => 3000,
                'daily_rate' => 110.00,
                'total_rentals' => 12
            ],
            [
                'name' => 'Yamaha Factor 150',
                'license_plate' => 'JKL-3456',
                'year' => 2023,
                'status' => 'Disponível',
                'rating' => 4.3,
                'tags' => ['economica', 'urbana'],
                'category' => 'Urbana',
                'fuel' => 'Flex',
                'mileage' => 5200,
                'daily_rate' => 60.00,
                'total_rentals' => 89
            ],
            [
                'name' => 'Kawasaki Ninja 650',
                'license_plate' => 'MNO-7890',
                'year' => 2022,
                'status' => 'Alugada',
                'rating' => 4.7,
                'tags' => ['esportiva', 'potente', 'experiente'],
                'category' => 'Esportiva',
                'fuel' => 'Gasolina',
                'mileage' => 8500,
                'daily_rate' => 150.00,
                'total_rentals' => 34
            ],
            [
                'name' => 'Harley Davidson Street 750',
                'license_plate' => 'PQR-1111',
                'year' => 2021,
                'status' => 'Disponível',
                'rating' => 4.9,
                'tags' => ['custom', 'luxo', 'potente'],
                'category' => 'Custom',
                'fuel' => 'Gasolina',
                'mileage' => 12000,
                'daily_rate' => 200.00,
                'total_rentals' => 23
            ]
        ];

        foreach ($motorcycles as $motorcycle) {
            Motorcycle::create($motorcycle);
        }
    }
}
