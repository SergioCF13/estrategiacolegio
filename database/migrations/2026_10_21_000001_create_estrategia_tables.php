<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Ej: 5.º de Secundaria
            $table->string('paralelo')->default('A');
            $table->string('area')->default('Técnica Tecnológica Especializada: Sistemas Informáticos');
            $table->string('capacidad')->default('Pensamiento Lógico - Matemático');
            $table->string('unidad_educativa')->default('Unidad Educativa');
            $table->string('distrito')->default('Dirección Distrital de Educación de Mineros (7036)');
            $table->string('docente')->default('Prof. de Sistemas Informáticos');
            $table->string('director')->default('Director/a de Unidad Educativa');
            $table->string('trimestre')->default('Tercer Trimestre - Gestión 2026');
            $table->text('diagnostico_curso')->nullable();
            $table->timestamps();
        });

        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos')->cascadeOnDelete();
            $table->string('nombres_apellidos');
            $table->string('rude')->nullable();
            $table->enum('diagnostico_inicial', ['INICIAL', 'EN_PROCESO', 'LOGRADO'])->default('INICIAL');
            $table->string('dificultad_detectada')->nullable();
            $table->timestamps();
        });

        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos')->cascadeOnDelete();
            $table->unsignedTinyInteger('numero_semana'); // 1, 2, 3, 4
            $table->string('titulo');
            $table->date('fecha_aplicacion')->nullable();
            $table->unsignedSmallInteger('tiempo_minutos')->default(25);
            $table->text('orientacion_didactica');
            $table->text('habilidades');
            $table->text('planteamiento');
            $table->text('solucionario_docente')->nullable();
            // Los 6 tipos de evidencia oficiales de la actividad
            $table->text('ev_1_detalle'); // Interpretación de textos, tablas y gráficos
            $table->text('ev_2_detalle'); // Resolución de problemas
            $table->text('ev_3_detalle'); // Registros de indagación y verificación
            $table->text('ev_4_detalle'); // Producciones escritas
            $table->text('ev_5_detalle'); // Exposiciones y argumentaciones
            $table->text('ev_6_detalle'); // Informes, proyectos y valoración formativa
            $table->enum('estado', ['PLANIFICADA', 'EJECUTADA'])->default('EJECUTADA');
            $table->text('logros_sesion')->nullable();
            $table->text('dificultades_sesion')->nullable();
            $table->timestamps();
        });

        Schema::create('evaluaciones_semanales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actividad_id')->constrained('actividades')->cascadeOnDelete();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->cascadeOnDelete();
            // 4 Criterios oficiales de Pensamiento Lógico - Matemático (Sección 5.1, pág. 5)
            $table->enum('criterio_1', ['INICIAL', 'EN_PROCESO', 'LOGRADO'])->default('EN_PROCESO'); // Comprende y representa problemas
            $table->enum('criterio_2', ['INICIAL', 'EN_PROCESO', 'LOGRADO'])->default('EN_PROCESO'); // Aplica estrategias y algoritmos
            $table->enum('criterio_3', ['INICIAL', 'EN_PROCESO', 'LOGRADO'])->default('EN_PROCESO'); // Verifica y comunica resultados
            $table->enum('criterio_4', ['INICIAL', 'EN_PROCESO', 'LOGRADO'])->default('EN_PROCESO'); // Transfiere a nuevas situaciones
            $table->enum('nivel_desempeno', ['INICIAL', 'EN_PROCESO', 'LOGRADO'])->default('EN_PROCESO');
            $table->enum('andamiaje_aplicado', ['APOYO_ALTO', 'APOYO_MEDIO', 'APOYO_BAJO'])->default('APOYO_MEDIO');
            // Los 6 tipos de evidencia cumplidos por el estudiante en la actividad
            $table->boolean('ev_1')->default(true);
            $table->boolean('ev_2')->default(true);
            $table->boolean('ev_3')->default(true);
            $table->boolean('ev_4')->default(true);
            $table->boolean('ev_5')->default(true);
            $table->boolean('ev_6')->default(true);
            $table->text('retroalimentacion')->nullable();
            $table->timestamps();

            $table->unique(['actividad_id', 'estudiante_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluaciones_semanales');
        Schema::dropIfExists('actividades');
        Schema::dropIfExists('estudiantes');
        Schema::dropIfExists('cursos');
    }
};
