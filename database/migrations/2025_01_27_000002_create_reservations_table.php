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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('motorcycle_id')->constrained()->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('daily_rate', 8, 2);
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['Ativa', 'Confirmada', 'Pendente', 'Concluída', 'Cancelada'])->default('Pendente');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Índices para melhor performance
            $table->index(['start_date', 'end_date']);
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
}; 