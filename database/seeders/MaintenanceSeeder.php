<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Maintenance;
use App\Models\Motorcycle;
use Carbon\Carbon;

class MaintenanceSeeder extends Seeder
{
    public function run()
    {
        $motorcycles = Motorcycle::all();

        if ($motorcycles->isEmpty()) {
            $this->command->info('Nenhuma motocicleta encontrada. Execute o MotorcycleSeeder primeiro.');
            return;
        }

        $maintenances = [
            [
                'motorcycle_id' => $motorcycles->where('name', 'Honda CB 250F')->first()->id ?? $motorcycles->first()->id,
                'type' => 'Preventiva',
                'description' => 'Troca de óleo, filtros e verificação geral do sistema de freios. Inspeção de pneus e suspensão.',
                'scheduled_date' => '2024-02-15',
                'completed_date' => '2024-02-15',
                'cost' => 150.00,
                'status' => 'Concluída',
                'priority' => 'Média',
                'technician' => 'João Silva',
                'notes' => 'Motocicleta em excelente estado. Próxima manutenção em 5000 km.',
                'parts_used' => 'Óleo de motor 10W30, filtro de óleo, filtro de ar',
                'labor_hours' => 2.5,
                'next_maintenance_date' => '2024-05-15',
                'mileage_at_service' => 15000
            ],
            [
                'motorcycle_id' => $motorcycles->where('name', 'Yamaha Factor 150')->first()->id ?? $motorcycles->first()->id,
                'type' => 'Corretiva',
                'description' => 'Reparo no sistema elétrico - problema com farol e indicadores. Substituição de cabos danificados.',
                'scheduled_date' => '2024-02-10',
                'completed_date' => '2024-02-12',
                'cost' => 280.00,
                'status' => 'Concluída',
                'priority' => 'Alta',
                'technician' => 'Carlos Santos',
                'notes' => 'Problema causado por umidade. Recomenda-se verificar vedação.',
                'parts_used' => 'Cabos elétricos, conectores, farol dianteiro',
                'labor_hours' => 4.0,
                'next_maintenance_date' => null,
                'mileage_at_service' => 8500
            ],
            [
                'motorcycle_id' => $motorcycles->where('name', 'Kawasaki Ninja 650')->first()->id ?? $motorcycles->first()->id,
                'type' => 'Preventiva',
                'description' => 'Manutenção preventiva completa: troca de óleo, filtros, verificação de corrente, ajuste de freios.',
                'scheduled_date' => '2024-02-20',
                'completed_date' => null,
                'cost' => 320.00,
                'status' => 'Agendada',
                'priority' => 'Média',
                'technician' => 'Pedro Costa',
                'notes' => 'Manutenção agendada conforme cronograma preventivo.',
                'parts_used' => null,
                'labor_hours' => null,
                'next_maintenance_date' => '2024-05-20',
                'mileage_at_service' => 22000
            ],
            [
                'motorcycle_id' => $motorcycles->where('name', 'Honda CB 600F Hornet')->first()->id ?? $motorcycles->first()->id,
                'type' => 'Emergencial',
                'description' => 'Reparo urgente no sistema de freios - vazamento de fluido. Substituição de pastilhas e fluido.',
                'scheduled_date' => '2024-02-05',
                'completed_date' => '2024-02-05',
                'cost' => 450.00,
                'status' => 'Concluída',
                'priority' => 'Crítica',
                'technician' => 'Roberto Lima',
                'notes' => 'Problema identificado durante inspeção de segurança. Reparo realizado com urgência.',
                'parts_used' => 'Pastilhas de freio dianteiras e traseiras, fluido de freio DOT4, mangueiras',
                'labor_hours' => 3.5,
                'next_maintenance_date' => null,
                'mileage_at_service' => 18500
            ],
            [
                'motorcycle_id' => $motorcycles->where('name', 'Honda CB 250F')->first()->id ?? $motorcycles->first()->id,
                'type' => 'Inspeção',
                'description' => 'Inspeção técnica completa para renovação de documentação. Verificação de todos os sistemas.',
                'scheduled_date' => '2024-02-25',
                'completed_date' => null,
                'cost' => 80.00,
                'status' => 'Agendada',
                'priority' => 'Baixa',
                'technician' => 'Fernando Oliveira',
                'notes' => 'Inspeção obrigatória para renovação do licenciamento.',
                'parts_used' => null,
                'labor_hours' => 1.0,
                'next_maintenance_date' => null,
                'mileage_at_service' => 16000
            ],
            [
                'motorcycle_id' => $motorcycles->where('name', 'Yamaha Factor 150')->first()->id ?? $motorcycles->first()->id,
                'type' => 'Revisão',
                'description' => 'Revisão completa do motor - ajuste de válvulas, sincronização de carburadores, verificação de compressão.',
                'scheduled_date' => '2024-02-08',
                'completed_date' => '2024-02-10',
                'cost' => 380.00,
                'status' => 'Concluída',
                'priority' => 'Alta',
                'technician' => 'João Silva',
                'notes' => 'Motor apresentava baixo rendimento. Após revisão, performance melhorou significativamente.',
                'parts_used' => 'Jogo de juntas, óleo de motor, filtros, velas de ignição',
                'labor_hours' => 6.0,
                'next_maintenance_date' => '2024-08-10',
                'mileage_at_service' => 9000
            ]
        ];

        foreach ($maintenances as $maintenance) {
            Maintenance::create($maintenance);
        }

        $this->command->info('Manutenções criadas com sucesso!');
    }
} 