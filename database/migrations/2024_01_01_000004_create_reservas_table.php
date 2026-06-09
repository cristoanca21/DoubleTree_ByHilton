<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->restrictOnDelete();
            $table->foreignId('habitacion_id')->constrained('habitaciones')->restrictOnDelete();
            $table->dateTime('fecha_ingreso');
            $table->dateTime('fecha_salida');
            $table->dateTime('check_in_real')->nullable();
            $table->dateTime('check_out_real')->nullable();
            $table->decimal('precio_noche_aplicado', 10, 2);
            $table->decimal('total', 10, 2);
            $table->enum('estado', ['pendiente', 'confirmada', 'en_curso', 'completada', 'cancelada'])
                  ->default('pendiente');
            $table->text('motivo_cancelacion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
