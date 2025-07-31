<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\PaymentInstallment;
use App\Models\Client;
use App\Models\Motorcycle;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $clients = Client::all();
        $motorcycles = Motorcycle::all();

        if ($clients->isEmpty() || $motorcycles->isEmpty()) {
            return;
        }

        // Create sample payments
        $payments = [
            [
                'client_id' => $clients->first()->id,
                'motorcycle_id' => $motorcycles->first()->id,
                'sale_type' => 'venda',
                'total_amount' => 25000.00,
                'down_payment' => 9000.00,
                'installments' => 6,
                'installment_amount' => 2666.67,
                'payment_method' => 'cartao_credito',
                'status' => 'ativa',
                'sale_date' => '2024-01-15',
                'due_date' => '2024-07-15',
                'notes' => 'Venda Honda CB 600F - Cliente Maria Silva'
            ],
            [
                'client_id' => $clients->skip(1)->first()->id,
                'motorcycle_id' => $motorcycles->skip(1)->first()->id,
                'sale_type' => 'venda',
                'total_amount' => 35000.00,
                'down_payment' => 11250.00,
                'installments' => 8,
                'installment_amount' => 2968.75,
                'payment_method' => 'pix',
                'status' => 'ativa',
                'sale_date' => '2024-02-01',
                'due_date' => '2024-10-01',
                'notes' => 'Venda Yamaha MT-07 - Cliente Pedro Costa'
            ],
            [
                'client_id' => $clients->skip(2)->first()->id,
                'motorcycle_id' => $motorcycles->skip(2)->first()->id,
                'sale_type' => 'venda',
                'total_amount' => 15000.00,
                'down_payment' => 3000.00,
                'installments' => 3,
                'installment_amount' => 4000.00,
                'payment_method' => 'dinheiro',
                'status' => 'concluida',
                'sale_date' => '2024-01-10',
                'due_date' => '2024-04-10',
                'paid_at' => '2024-04-10 14:30:00',
                'notes' => 'Venda Honda CB 250F - Cliente Carlos Oliveira'
            ],
            [
                'client_id' => $clients->first()->id,
                'motorcycle_id' => $motorcycles->skip(3)->first()->id,
                'sale_type' => 'aluguel',
                'total_amount' => 5000.00,
                'down_payment' => 1000.00,
                'installments' => 4,
                'installment_amount' => 1000.00,
                'payment_method' => 'transferencia',
                'status' => 'ativa',
                'sale_date' => '2024-03-01',
                'due_date' => '2024-07-01',
                'notes' => 'Aluguel Suzuki GSX-R 600 - Cliente Maria Silva'
            ]
        ];

        foreach ($payments as $paymentData) {
            $payment = Payment::create($paymentData);

            // Create installments if more than 1
            if ($payment->installments > 1) {
                $dueDate = Carbon::parse($payment->sale_date)->addMonth();
                
                for ($i = 1; $i <= $payment->installments; $i++) {
                    $status = 'pendente';
                    $paidAt = null;
                    
                    // Mark some installments as paid for completed sales
                    if ($payment->status === 'concluida' && $i <= 3) {
                        $status = 'pago';
                        $paidAt = $dueDate->copy()->addDays(rand(0, 5));
                    }
                    
                    // Mark some installments as overdue
                    if ($payment->status === 'ativa' && $i === 3 && $payment->id === 1) {
                        $status = 'atrasado';
                    }

                    PaymentInstallment::create([
                        'payment_id' => $payment->id,
                        'installment_number' => $i,
                        'amount' => $payment->installment_amount,
                        'due_date' => $dueDate->copy()->addMonths($i - 1),
                        'status' => $status,
                        'paid_at' => $paidAt
                    ]);
                }
            }
        }
    }
} 