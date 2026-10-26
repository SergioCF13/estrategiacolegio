<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estudiante extends Model
{
    protected $table = 'estudiantes';

    protected $fillable = [
        'curso_id',
        'nombres_apellidos',
        'rude',
        'diagnostico_inicial',
        'dificultad_detectada',
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
        return $this->hasMany(ArchivoEvidencia::class);
    }

    /**
     * Genera automáticamente el informe cualitativo integral del proceso de aprendizaje
     * del estudiante a lo largo de las 4 semanas, siguiendo los lineamientos del Ministerio
     * de Educación (Secciones 5.1, 5.2, 5.3 y 5.4).
     */
    public function ResumenProceso(): array
    {
        $evals = $this->evaluaciones()->with('actividad')->get()->sortBy(fn($e) => $e->actividad->numero_semana ?? 0)->values();

        $totalPosibles = max(1, $evals->count() * 6);
        $totalCumplidas = $evals->sum(fn($e) => $e->totalEvidenciasCumplidas());
        $porcentajeEvidencias = round(($totalCumplidas / $totalPosibles) * 100);

        $primera = $evals->first();
        $ultima = $evals->last();

        $nivelInicial = $primera ? $primera->nivel_desempeno : $this->diagnostico_inicial;
        $nivelFinal = $ultima ? $ultima->nivel_desempeno : $this->diagnostico_inicial;

        $etiquetaNivel = [
            'INICIAL' => 'INICIAL',
            'EN_PROCESO' => 'EN PROCESO',
            'LOGRADO' => 'LOGRADO',
        ];

        $etiquetaApoyo = [
            'APOYO_ALTO' => 'Apoyo Alto (modelado paso a paso y andamiaje directo)',
            'APOYO_MEDIO' => 'Apoyo Medio (práctica guiada y preguntas orientadoras)',
            'APOYO_BAJO' => 'Apoyo Bajo / Autónomo (transferencia a nuevas situaciones)',
        ];

        $apoyoInicial = $primera ? ($etiquetaApoyo[$primera->andamiaje_aplicado] ?? 'Apoyo Medio') : 'Apoyo Alto';
        $apoyoFinal = $ultima ? ($etiquetaApoyo[$ultima->andamiaje_aplicado] ?? 'Apoyo Bajo') : 'Apoyo Medio';

        $dificultad = $this->dificultad_detectada ?: 'la interpretación inicial de datos y formulación algebraica del problema';

        // Redacción automática del proceso de aprendizaje (4 párrafos estructurados)
        $diagnosticoTexto = "Al inicio del ciclo de fortalecimiento (Diagnóstico), el/la estudiante se ubicó en el nivel {$etiquetaNivel[$this->diagnostico_inicial]}, identificándose como eslabón a fortalecer {$dificultad}. En la primera sesión requirió {$apoyoInicial}.";

        if ($nivelFinal === 'LOGRADO') {
            $evolucionTexto = "A lo largo de las 4 sesiones semanales de la rutina pedagógica en el área de Sistemas Informáticos, demostró una progresión altamente favorable hasta consolidar el nivel LOGRADO. Actualmente comprende y representa problemas tecnológicos, aplica fórmulas y modelos matemáticos (ecuaciones lineales, recurso limitante, lógica de conjuntos y conversión de unidades TB/GB/MB), verifica sus resultados mediante pruebas de escritorio y sustenta sus decisiones técnicas con autonomía.";
            $recomendacionTexto = "Promover actividades de profundización, retos de transferencia hacia proyectos complejos de programación/redes y asignarle roles de tutoría o monitoreo colaborativo entre pares (Acción pedagógica consecuente - Sección 5.2).";
        } elseif ($nivelFinal === 'EN_PROCESO') {
            $evolucionTexto = "Durante el desarrollo de las 4 actividades semanales evidenció avances significativos, situándose al cierre del ciclo en el nivel EN PROCESO con {$apoyoFinal}. Logra extraer datos en tablas y aplicar los procedimientos matemáticos principales con orientación general del docente, requiriendo aún reforzar la argumentación escrita y la verificación autónoma en escenarios nuevos.";
            $recomendacionTexto = "Continuar brindando retroalimentación descriptiva oportuna, fomentar el uso de listas de autoevaluación en la verificación de cálculos y proponer ejercicios de dificultad gradual en el laboratorio (Sección 5.2).";
        } else {
            $evolucionTexto = "Durante la implementación de las rutinas semanales el/la estudiante se mantiene en el nivel INICIAL, evidenciando aprendizajes básicos y fragmentados. Realiza la extracción de datos y operaciones elementales con acompañamiento frecuente y directo del maestro.";
            $recomendacionTexto = "Mantener el andamiaje individualizado (Apoyo Alto), modelado explícito paso a paso en pizarra y asignar tutoría entre pares para recuperar aprendizajes base de razonamiento lógico-matemático (Sección 5.2).";
        }

        $evidenciasTexto = "En cuanto a la recolección de los 6 tipos de evidencia establecidos en la Sección 5.3 (Interpretación de datos, Resolución de problemas, Registros de indagación, Producciones escritas, Exposiciones orales e Informes integradores), cumplió con {$totalCumplidas} de {$totalPosibles} evidencias registradas ({$porcentajeEvidencias}% de cumplimiento en aula).";

        return [
            'nivel_inicial' => $etiquetaNivel[$nivelInicial] ?? 'INICIAL',
            'nivel_final' => $etiquetaNivel[$nivelFinal] ?? 'EN PROCESO',
            'nivel_final_raw' => $nivelFinal,
            'total_cumplidas' => $totalCumplidas,
            'total_posibles' => $totalPosibles,
            'porcentaje_evidencias' => $porcentajeEvidencias,
            'parrafo_diagnostico' => $diagnosticoTexto,
            'parrafo_evolucion' => $evolucionTexto,
            'parrafo_evidencias' => $evidenciasTexto,
            'parrafo_recomendacion' => $recomendacionTexto,
        ];
    }
}
