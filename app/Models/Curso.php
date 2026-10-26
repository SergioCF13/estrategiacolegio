<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curso extends Model
{
    protected $table = 'cursos';

    protected $fillable = [
        'nombre',
        'paralelo',
        'area',
        'capacidad',
        'unidad_educativa',
        'distrito',
        'docente',
        'director',
        'trimestre',
        'diagnostico_curso',
    ];

    public function estudiantes(): HasMany
    {
        return $this->hasMany(Estudiante::class)->orderBy('nombres_apellidos');
    }

    public function actividades(): HasMany
    {
        return $this->hasMany(Actividad::class)
            ->orderBy('anio')
            ->orderBy('mes')
            ->orderBy('numero_semana');
    }
}
