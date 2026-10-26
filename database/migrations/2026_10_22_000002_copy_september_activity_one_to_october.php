<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $campos = [
            'titulo',
            'tiempo_minutos',
            'orientacion_didactica',
            'habilidades',
            'planteamiento',
            'solucionario_docente',
            'ev_1_detalle',
            'ev_2_detalle',
            'ev_3_detalle',
            'ev_4_detalle',
            'ev_5_detalle',
            'ev_6_detalle',
        ];

        $actividadesSeptiembre = DB::table('actividades')
            ->where('mes', 9)
            ->where('anio', 2026)
            ->where('numero_semana', 1)
            ->get();

        foreach ($actividadesSeptiembre as $origen) {
            $destino = DB::table('actividades')
                ->where('curso_id', $origen->curso_id)
                ->where('mes', 10)
                ->where('anio', 2026)
                ->where('numero_semana', 1)
                ->first();

            if (!$destino || $destino->titulo !== 'Actividad 1') {
                continue;
            }

            $datos = [];
            foreach ($campos as $campo) {
                $datos[$campo] = $origen->$campo;
            }

            DB::table('actividades')->where('id', $destino->id)->update($datos);
        }
    }

    public function down(): void
    {
        $camposCopiados = [
            'titulo',
            'tiempo_minutos',
            'orientacion_didactica',
            'habilidades',
            'planteamiento',
            'solucionario_docente',
            'ev_1_detalle',
            'ev_2_detalle',
            'ev_3_detalle',
            'ev_4_detalle',
            'ev_5_detalle',
            'ev_6_detalle',
        ];

        foreach (DB::table('actividades')
            ->where('mes', 9)
            ->where('anio', 2026)
            ->where('numero_semana', 1)
            ->get() as $origen) {
            $destino = DB::table('actividades')
                ->where('curso_id', $origen->curso_id)
                ->where('mes', 10)
                ->where('anio', 2026)
                ->where('numero_semana', 1)
                ->first();

            if (!$destino) {
                continue;
            }

            foreach ($camposCopiados as $campo) {
                if ($destino->$campo !== $origen->$campo) {
                    continue 2;
                }
            }

            DB::table('actividades')->where('id', $destino->id)->update([
                'titulo' => 'Actividad 1',
                'tiempo_minutos' => 25,
                'orientacion_didactica' => '',
                'habilidades' => '',
                'planteamiento' => '',
                'solucionario_docente' => null,
                'ev_1_detalle' => '',
                'ev_2_detalle' => '',
                'ev_3_detalle' => '',
                'ev_4_detalle' => '',
                'ev_5_detalle' => '',
                'ev_6_detalle' => '',
            ]);
        }
    }
};
