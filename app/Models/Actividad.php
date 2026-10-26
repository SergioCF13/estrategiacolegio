<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Actividad extends Model
{
    protected $table = 'actividades';

    protected $fillable = [
        'curso_id',
        'numero_semana',
        'mes',
        'anio',
        'titulo',
        'fecha_aplicacion',
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
        'estado',
        'logros_sesion',
        'dificultades_sesion',
    ];

    protected $casts = [
        'fecha_aplicacion' => 'date',
        'mes' => 'integer',
        'anio' => 'integer',
    ];

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }

    public function evaluaciones(): HasMany
    {
        return $this->hasMany(EvaluacionSemanal::class);
    }

    public function archivosEvidencia(): HasMany
    {
        return $this->hasMany(ArchivoEvidencia::class)->orderBy('numero_evidencia');
    }

    public function nombreMes(): string
    {
        return [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre',
        ][$this->mes] ?? 'Mes';
    }
}
