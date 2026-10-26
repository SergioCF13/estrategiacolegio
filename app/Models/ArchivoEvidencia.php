<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArchivoEvidencia extends Model
{
    protected $table = 'archivos_evidencia';

    protected $fillable = [
        'actividad_id',
        'estudiante_id',
        'numero_evidencia',
        'tipo_archivo',
        'titulo',
        'ruta_archivo',
        'mime_type',
    ];

    public function actividad(): BelongsTo
    {
        return $this->belongsTo(Actividad::class);
    }

    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function nombreTipoEvidencia(): string
    {
        return match ((int) $this->numero_evidencia) {
            1 => 'Evidencia 1: Interpretación de Textos y Datos',
            2 => 'Evidencia 2: Resolución de Problemas',
            3 => 'Evidencia 3: Registros de Indagación',
            4 => 'Evidencia 4: Producciones Escritas',
            5 => 'Evidencia 5: Exposiciones y Argumentaciones',
            6 => 'Evidencia 6: Informes y Proyectos',
            default => 'Evidencia General',
        };
    }

    /**
     * Devuelve la imagen en formato Base64 para incrustarla de forma 100% compatible en DomPDF
     */
    public function obtenerImagenBase64ParaPdf(): ?string
    {
        if ($this->tipo_archivo !== 'IMAGEN') {
            return null;
        }
        $fullPath = public_path($this->ruta_archivo);
        if (!file_exists($fullPath)) {
            return null;
        }
        $contenido = file_get_contents($fullPath);
        if ($contenido === false) {
            return null;
        }

        $mime = (new \finfo(FILEINFO_MIME_TYPE))->buffer($contenido);
        if (!is_string($mime) || !str_starts_with($mime, 'image/')) {
            return null;
        }

        if (in_array($mime, ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'], true)) {
            return "data:{$mime};base64," . base64_encode($contenido);
        }

        if (!function_exists('imagecreatefromstring')) {
            return null;
        }

        $imagen = @\imagecreatefromstring($contenido);
        if ($imagen === false) {
            return null;
        }

        $ancho = \imagesx($imagen);
        $alto = \imagesy($imagen);
        $fondo = \imagecreatetruecolor($ancho, $alto);
        if ($fondo === false) {
            \imagedestroy($imagen);
            return null;
        }

        $blanco = \imagecolorallocate($fondo, 255, 255, 255);
        \imagefill($fondo, 0, 0, $blanco);
        \imagecopy($fondo, $imagen, 0, 0, 0, 0, $ancho, $alto);
        \imagedestroy($imagen);

        ob_start();
        $convertida = \imagejpeg($fondo, null, 90);
        \imagedestroy($fondo);
        $jpeg = ob_get_clean();
        if (!$convertida || !is_string($jpeg)) {
            return null;
        }

        return 'data:image/jpeg;base64,' . base64_encode($jpeg);
    }
}
