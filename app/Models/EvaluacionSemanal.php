<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluacionSemanal extends Model
{
    protected $table = 'evaluaciones_semanales';

    protected $fillable = [
        'actividad_id',
        'estudiante_id',
        'criterio_1',
        'criterio_2',
        'criterio_3',
        'criterio_4',
        'nivel_desempeno',
        'andamiaje_aplicado',
        'ev_1',
        'ev_2',
        'ev_3',
        'ev_4',
        'ev_5',
        'ev_6',
        'retroalimentacion',
    ];

    protected $casts = [
        'ev_1' => 'boolean',
        'ev_2' => 'boolean',
        'ev_3' => 'boolean',
        'ev_4' => 'boolean',
        'ev_5' => 'boolean',
        'ev_6' => 'boolean',
    ];

    public function actividad(): BelongsTo
    {
        return $this->belongsTo(Actividad::class);
    }

    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function totalEvidenciasCumplidas(): int
    {
        return (int) $this->ev_1 + (int) $this->ev_2 + (int) $this->ev_3 + (int) $this->ev_4 + (int) $this->ev_5 + (int) $this->ev_6;
    }

    public static function generarRetroalimentacionAutomatica(string $nivel, string $andamiaje, int $actividad): string
    {
        return match ($nivel) {
            'INICIAL' => "Actividad {$actividad}: Evidencia aprendizajes básicos y fragmentados. Se aplicó andamiaje individualizado ({$andamiaje}) y modelado paso a paso para comprender la consigna y estructurar los datos en tabla.",
            'EN_PROCESO' => "Actividad {$actividad}: Evidencia avances significativos en el planteamiento y cálculo. Con práctica guiada ({$andamiaje}) logra verificar resultados y redactar su conclusión técnica.",
            'LOGRADO' => "Actividad {$actividad}: Demuestra el aprendizaje esperado con autonomía y solidez ({$andamiaje}). Resuelve, verifica matemáticamente y sustenta oralmente sus resultados transfiriendo el modelo a nuevas situaciones.",
            default => "Participación registrada en la Actividad {$actividad}.",
        };
    }
}
