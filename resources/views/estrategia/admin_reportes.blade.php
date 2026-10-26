@extends('layouts.admin')

@section('title', 'Centro de Reportes PDF — Panel de Administración')
@section('page_title', 'Centro Oficial de Reportes y Exportación en PDF')
@section('page_subtitle', 'Selecciona el mes y la actividad para generar informes únicamente de esa actividad.')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 mb-6">
    <form method="GET" action="{{ route('estrategia.admin.reportes') }}" class="flex flex-wrap items-end gap-3">
        <input type="hidden" name="curso_id" value="{{ $cursoActivo?->id }}">
        <label class="text-xs font-bold text-slate-600">Mes
            <select name="mes" class="block mt-1 rounded-lg border-slate-300 text-xs">
                @foreach(range(1, 12) as $numeroMes)
                    <option value="{{ $numeroMes }}" @selected($mes === $numeroMes)>{{ \Carbon\Carbon::createFromDate($anio, $numeroMes, 1)->locale('es')->translatedFormat('F') }}</option>
                @endforeach
            </select>
        </label>
        <label class="text-xs font-bold text-slate-600">Año
            <input type="number" name="anio" min="2020" max="2100" value="{{ $anio }}" class="block mt-1 w-24 rounded-lg border-slate-300 text-xs">
        </label>
        <label class="text-xs font-bold text-slate-600">Actividad
            <select name="actividad" class="block mt-1 rounded-lg border-slate-300 text-xs">
                @for($numeroActividad = 1; $numeroActividad <= 4; $numeroActividad++)
                    <option value="{{ $numeroActividad }}" @selected($actividadSeleccionada === $numeroActividad)>Actividad {{ $numeroActividad }}</option>
                @endfor
            </select>
        </label>
        <button class="rounded-lg bg-slate-900 px-4 py-2 text-xs font-bold text-white">Ver informes</button>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @foreach($cursos as $c)
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="bg-slate-900 text-white p-4 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold uppercase text-amber-400 block">{{ $c->distrito }}</span>
                        <h3 class="text-base font-extrabold">🎓 {{ $c->nombre }} — Paralelo "{{ $c->paralelo }}"</h3>
                    </div>
                    <span class="bg-slate-800 text-amber-300 text-xs font-bold px-3 py-1 rounded-lg border border-slate-700">
                        {{ $c->estudiantes->count() }} Estudiantes
                    </span>
                </div>

                <div class="p-5 space-y-3 text-xs">
                    <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-200 flex items-center justify-between gap-3">
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-sm">1. Informe General — Actividad {{ $actividadSeleccionada }}, {{ $nombreMes }} {{ $anio }} (PDF)</h4>
                            <p class="text-slate-600 mt-0.5">
                                Incluye únicamente esta actividad, sus evidencias, evaluaciones y archivos multimedia.
                            </p>
                        </div>
                        <a href="{{ route('estrategia.pdf.curso', ['curso' => $c->id, 'mes' => $mes, 'anio' => $anio, 'actividad' => $actividadSeleccionada]) }}"
                           class="bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold px-4 py-2.5 rounded-lg shadow shrink-0">
                            📊 Descargar PDF
                        </a>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between gap-3">
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-sm">2. Informes Individuales — Actividad {{ $actividadSeleccionada }}, {{ $nombreMes }} {{ $anio }} (PDF)</h4>
                            <p class="text-slate-600 mt-0.5">
                                Genera un informe por estudiante solo con la evaluación y las evidencias de esta actividad.
                            </p>
                        </div>
                        <a href="{{ route('estrategia.pdf.estudiantes', ['curso' => $c->id, 'mes' => $mes, 'anio' => $anio, 'actividad' => $actividadSeleccionada]) }}"
                           class="bg-slate-900 hover:bg-slate-800 text-white font-extrabold px-4 py-2.5 rounded-lg shadow shrink-0">
                            📑 Descargar Lote
                        </a>
                    </div>

                    <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-between gap-3">
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-sm">3. Cuadernillo de las 4 Actividades para el Aula (PDF)</h4>
                            <p class="text-slate-600 mt-0.5">
                                Fichas de trabajo listas para imprimir con problemas, gráficos, las 6 evidencias paso a paso y solucionario docente.
                            </p>
                        </div>
                        <a href="{{ asset(str_contains($c->nombre, '5') ? 'cuadernillos/Cuadernillo_Actividades_5to_Secundaria.pdf' : 'cuadernillos/Cuadernillo_Actividades_6to_Secundaria.pdf') }}"
                           target="_blank"
                           class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold px-4 py-2.5 rounded-lg shadow shrink-0">
                            📘 Ver Cuadernillo
                        </a>
                    </div>
                </div>
            </div>

            <div class="px-5 py-3 bg-slate-50 border-t border-slate-200 text-xs flex items-center justify-between">
                <span class="text-slate-500">Docente: <strong>Sergio Canaviri Felix</strong></span>
                <a href="{{ route('estrategia.admin.estudiantes', ['curso_id' => $c->id]) }}" class="font-bold text-amber-700 hover:underline">
                    Ver fichas individuales por alumno →
                </a>
            </div>
        </div>
    @endforeach
</div>
@endsection
