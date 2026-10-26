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
            ->get(['id', 'curso_id', 'logros_sesion', 'dificultades_sesion']);

        foreach ($origenes as $origen) {
            $destino = DB::table('actividades')
                ->where('curso_id', $origen->curso_id)
                ->where('mes', 10)
                ->where('anio', 2026)
                ->where('numero_semana', 1)
                ->where('titulo', 'Modelación matemática para contratación de Internet y Servidores Cloud')
                ->first(['id', 'logros_sesion', 'dificultades_sesion']);

            if (!$destino) {
                continue;
            }

            $actualizar = [];
            if (blank($destino->logros_sesion)) {
                $actualizar['logros_sesion'] = $origen->logros_sesion;
            }
            if (blank($destino->dificultades_sesion)) {
                $actualizar['dificultades_sesion'] = $origen->dificultades_sesion;
            }

            if ($actualizar !== []) {
                DB::table('actividades')->where('id', $destino->id)->update($actualizar);
            }
        }
    }

    public function down(): void
    {
    }
};
