<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('actividades', function (Blueprint $table) {
            $table->unsignedTinyInteger('mes')->nullable();
            $table->unsignedSmallInteger('anio')->nullable();
            $table->index(['curso_id', 'anio', 'mes']);
        });

        foreach (DB::table('actividades')->select('id', 'fecha_aplicacion')->get() as $actividad) {
            $fecha = $actividad->fecha_aplicacion
                ? new DateTimeImmutable($actividad->fecha_aplicacion)
                : new DateTimeImmutable();

            DB::table('actividades')->where('id', $actividad->id)->update([
                'mes' => (int) $fecha->format('n'),
                'anio' => (int) $fecha->format('Y'),
            ]);
        }

    }

    public function down(): void
    {
        Schema::table('actividades', function (Blueprint $table) {
            $table->dropIndex(['curso_id', 'anio', 'mes']);
            $table->dropColumn(['mes', 'anio']);
        });
    }
};
