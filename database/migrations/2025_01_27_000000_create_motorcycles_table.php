<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('motorcycles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('license_plate')->unique();
            $table->integer('year');
            $table->enum('status', ['Disponível', 'Alugada', 'Manutenção', 'Inativa'])->default('Disponível');
            $table->decimal('rating', 2, 1)->default(0.0);
            $table->json('tags')->nullable();
            $table->enum('category', ['Urbana', 'Esportiva', 'Custom', 'Trail'])->default('Urbana');
            $table->enum('fuel', ['Flex', 'Gasolina', 'Elétrica', 'Híbrida'])->default('Flex');
            $table->integer('mileage')->default(0);
            $table->decimal('daily_rate', 8, 2);
            $table->integer('total_rentals')->default(0);
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('motorcycles');
    }
}; 