<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archivos_evidencia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actividad_id')->constrained('actividades')->cascadeOnDelete();
            $table->foreignId('estudiante_id')->nullable()->constrained('estudiantes')->nullOnDelete();
            $table->unsignedTinyInteger('numero_evidencia')->default(1); // 1 al 6 (Los 6 tipos de evidencia)
            $table->enum('tipo_archivo', ['IMAGEN', 'VIDEO'])->default('IMAGEN');
            $table->string('titulo')->nullable();
            $table->string('ruta_archivo'); // Ruta en public/evidencias/... o URL externa
            $table->string('mime_type')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archivos_evidencia');
    }
};
