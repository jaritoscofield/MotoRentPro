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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('motorcycle_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['Preventiva', 'Corretiva', 'Emergencial', 'Inspeção', 'Revisão']);
            $table->text('description');
            $table->date('scheduled_date');
            $table->date('completed_date')->nullable();
            $table->decimal('cost', 10, 2)->default(0.00);
            $table->enum('status', ['Agendada', 'Em Andamento', 'Concluída', 'Cancelada', 'Atrasada'])->default('Agendada');
            $table->enum('priority', ['Baixa', 'Média', 'Alta', 'Crítica'])->default('Média');
            $table->string('technician')->nullable();
            $table->text('notes')->nullable();
            $table->text('parts_used')->nullable();
            $table->decimal('labor_hours', 4, 1)->nullable();
            $table->date('next_maintenance_date')->nullable();
            $table->integer('mileage_at_service')->nullable();
            $table->timestamps();

            $table->index(['scheduled_date', 'status']);
            $table->index('status');
            $table->index('priority');
            $table->index('type');
            $table->index('completed_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
