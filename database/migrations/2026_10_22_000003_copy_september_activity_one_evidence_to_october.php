<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $origenes = DB::table('actividades')
            ->where('mes', 9)
            ->where('anio', 2026)
            ->where('numero_semana', 1)
            ->get(['id', 'curso_id']);

        foreach ($origenes as $origen) {
            $destino = DB::table('actividades')
                ->where('curso_id', $origen->curso_id)
                ->where('mes', 10)
                ->where('anio', 2026)
                ->where('numero_semana', 1)
                ->first(['id']);

            if (!$destino) {
                continue;
            }

            $archivos = DB::table('archivos_evidencia')
                ->where('actividad_id', $origen->id)
                ->get();

            foreach ($archivos as $archivo) {
                $yaCopiado = DB::table('archivos_evidencia')
                    ->where('actividad_id', $destino->id)
                    ->where('estudiante_id', $archivo->estudiante_id)
                    ->where('numero_evidencia', $archivo->numero_evidencia)
                    ->where('tipo_archivo', $archivo->tipo_archivo)
                    ->where('titulo', $archivo->titulo)
                    ->where('ruta_archivo', $archivo->ruta_archivo)
                    ->exists();

                if ($yaCopiado) {
                    continue;
                }

                DB::table('archivos_evidencia')->insert([
                    'actividad_id' => $destino->id,
                    'estudiante_id' => $archivo->estudiante_id,
                    'numero_evidencia' => $archivo->numero_evidencia,
                    'tipo_archivo' => $archivo->tipo_archivo,
                    'titulo' => $archivo->titulo,
                    'ruta_archivo' => $archivo->ruta_archivo,
                    'mime_type' => $archivo->mime_type,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
    }
};
