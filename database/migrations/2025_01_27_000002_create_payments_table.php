<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('motorcycle_id')->constrained()->onDelete('cascade');
            $table->enum('sale_type', ['venda', 'aluguel'])->default('venda');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('down_payment', 10, 2)->default(0);
            $table->integer('installments')->default(1);
            $table->decimal('installment_amount', 10, 2)->default(0);
            $table->enum('payment_method', ['dinheiro', 'cartao_credito', 'cartao_debito', 'pix', 'transferencia'])->default('dinheiro');
            $table->enum('status', ['ativa', 'concluida', 'cancelada', 'pendente'])->default('ativa');
            $table->date('sale_date');
            $table->date('due_date')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
}; 