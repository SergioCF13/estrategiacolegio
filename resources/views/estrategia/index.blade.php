@extends('layouts.admin')

@section('title', 'Dashboard Estadístico — Panel de Administración')
@section('page_title', 'Dashboard General y Estadísticas de Logro de Aprendizajes')
@section('page_subtitle', 'Monitoreo mensual de 4 actividades y 6 tipos de evidencia en ' . ($cursoActivo?->nombre ?? 'Secundaria'))

@section('content')
@if($cursoActivo)
    @php
        $sem1 = $estadisticasSemanas[1] ?? ['pct_inicial' => 0, 'pct_en_proceso' => 0, 'pct_logrado' => 0, 'inicial' => 0, 'en_proceso' => 0, 'logrado' => 0];
        $sem4 = $estadisticasSemanas[4] ?? $sem1;
    @endphp

    <form method="GET" action="{{ route('estrategia.index') }}" class="flex flex-wrap items-end gap-3 rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
        <input type="hidden" name="curso_id" value="{{ $cursoActivo->id }}">
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
        <label class="text-xs font-bold text-slate-600">Actividad del informe
            <select name="actividad" class="block mt-1 rounded-lg border-slate-300 text-xs">
                @for($numeroActividad = 1; $numeroActividad <= 4; $numeroActividad++)
                    <option value="{{ $numeroActividad }}" @selected($actividadSeleccionada === $numeroActividad)>Actividad {{ $numeroActividad }}</option>
                @endfor
            </select>
        </label>
        <button class="rounded-lg bg-slate-900 px-4 py-2 text-xs font-bold text-white">Ver periodo</button>
    </form>

    <!-- 1. TARJETAS KPI DEL DASHBOARD -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold uppercase text-slate-400">Curso Seleccionado</p>
                <p class="text-xl font-black text-slate-900 mt-0.5">{{ $cursoActivo->nombre }} "{{ $cursoActivo->paralelo }}"</p>
                <p class="text-xs text-slate-500 mt-0.5">{{ $cursoActivo->estudiantes->count() }} estudiantes registrados</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-slate-900 text-amber-400 flex items-center justify-center text-xl">🎓</div>
        </div>

        <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold uppercase text-slate-400">Actividades de {{ \Carbon\Carbon::createFromDate($anio, $mes, 1)->locale('es')->translatedFormat('F Y') }}</p>
                <p class="text-xl font-black text-slate-900 mt-0.5">{{ $cursoActivo->actividades->count() }} / 4 Sesiones</p>
                <p class="text-xs text-emerald-600 font-semibold mt-0.5">Planificadas para el mes</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-xl">📅</div>
        </div>

        <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold uppercase text-slate-400">Nivel LOGRADO (Actividad 4)</p>
                <p class="text-xl font-black text-emerald-700 mt-0.5">{{ $sem4['pct_logrado'] }}% del Curso</p>
                <p class="text-xs text-slate-500 mt-0.5">Comparado con {{ $sem1['pct_logrado'] }}% en Actividad 1</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl">📈</div>
        </div>

        <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold uppercase text-slate-400">Cumplimiento 6 Evidencias</p>
                <p class="text-xl font-black text-amber-600 mt-0.5">{{ $pctGlobalEvidencias }}% Cumplido</p>
                <p class="text-xs text-slate-500 mt-0.5">{{ $totalEvidenciasCumplidas }} de {{ $totalEvidenciasPosibles }} evidencias</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-xl">📂</div>
        </div>
    </div>

    <!-- 2. BARRA DE DESCARGA RÁPIDA DE INFORMES PDF -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 rounded-xl shadow-lg p-5 text-white flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 border border-slate-700">
        <div>
            <span class="inline-block bg-amber-500 text-slate-950 text-[10px] font-extrabold uppercase px-2.5 py-0.5 rounded mb-1">
                Exportación Oficial Automática — {{ $cursoActivo->nombre }} "{{ $cursoActivo->paralelo }}"
            </span>
            <h2 class="text-base md:text-lg font-extrabold">
                Generar Informes Oficiales para la Dirección de Unidad Educativa
            </h2>
            <p class="text-xs text-slate-300 mt-0.5">
                Descarga el Informe General del Curso con los 6 tipos de evidencia o las fichas individuales del proceso de aprendizaje de cada estudiante.
            </p>
        </div>
        <div class="flex flex-wrap gap-2.5 shrink-0">
            <a href="{{ route('estrategia.pdf.curso', ['curso' => $cursoActivo->id, 'mes' => $mes, 'anio' => $anio, 'actividad' => $actividadSeleccionada]) }}"
               class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold px-4 py-2.5 rounded-lg shadow text-xs flex items-center gap-2 transition">
                <span>📊</span>
                <span>1. Informe General del Curso (PDF)</span>
            </a>
            <a href="{{ route('estrategia.pdf.estudiantes', ['curso' => $cursoActivo->id, 'mes' => $mes, 'anio' => $anio, 'actividad' => $actividadSeleccionada]) }}"
               class="bg-white hover:bg-slate-100 text-slate-900 font-extrabold px-4 py-2.5 rounded-lg shadow text-xs flex items-center gap-2 transition">
                <span>📑</span>
                <span>2. Informes de Todos los Estudiantes (PDF)</span>
            </a>
            <a href="{{ asset(str_contains($cursoActivo->nombre, '5') ? 'cuadernillos/Cuadernillo_Actividades_5to_Secundaria.pdf' : 'cuadernillos/Cuadernillo_Actividades_6to_Secundaria.pdf') }}"
               target="_blank"
               class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold px-3.5 py-2.5 rounded-lg shadow text-xs flex items-center gap-2 transition">
                <span>📘</span>
                <span>3. Cuadernillo de Aula (PDF)</span>
            </a>
        </div>
    </div>

    <!-- 3. GRÁFICOS ESTADÍSTICOS INTERACTIVOS (CHART.JS) + TARJETAS SEMANALES -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Gráfico de evolución de las cuatro actividades del mes -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <h3 class="text-sm font-bold uppercase text-slate-800">
                        📊 Evolución de Niveles de Desempeño — {{ \Carbon\Carbon::createFromDate($anio, $mes, 1)->locale('es')->translatedFormat('F Y') }}
                    </h3>
                    <p class="text-xs text-slate-500">Reducción progresiva del rezago escolar mediante andamiaje en {{ $cursoActivo->nombre }}</p>
                </div>
                <a href="{{ route('estrategia.admin.actividades', ['curso_id' => $cursoActivo->id, 'mes' => $mes, 'anio' => $anio]) }}"
                   class="text-xs font-bold text-amber-600 hover:underline">
                    Configurar Actividades →
                </a>
            </div>
            <div class="h-60">
                <canvas id="chartEvolucion"></canvas>
            </div>
        </div>

        <!-- Gráfico de Distribución al Cierre del Ciclo -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex flex-col justify-between">
            <div>
                <h3 class="text-sm font-bold uppercase text-slate-800">
                    🎯 Estado al Cierre del Mes (Actividad 4)
                </h3>
                <p class="text-xs text-slate-500 mb-3">Porcentaje de estudiantes por nivel alcanzado</p>
                <div class="h-44 flex items-center justify-center">
                    <canvas id="chartCierre"></canvas>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-2 pt-3 border-t border-slate-100 text-center text-xs">
                <div class="bg-red-50 p-2 rounded">
                    <span class="block font-black text-red-700">{{ $sem4['inicial'] }} ({{ $sem4['pct_inicial'] }}%)</span>
                    <span class="text-[10px] text-red-600 font-semibold">INICIAL</span>
                </div>
                <div class="bg-amber-50 p-2 rounded">
                    <span class="block font-black text-amber-700">{{ $sem4['en_proceso'] }} ({{ $sem4['pct_en_proceso'] }}%)</span>
                    <span class="text-[10px] text-amber-700 font-semibold">EN PROCESO</span>
                </div>
                <div class="bg-emerald-50 p-2 rounded">
                    <span class="block font-black text-emerald-700">{{ $sem4['logrado'] }} ({{ $sem4['pct_logrado'] }}%)</span>
                    <span class="text-[10px] text-emerald-700 font-semibold">LOGRADO</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. ACCESO RÁPIDO A LAS 4 ACTIVIDADES SEMANALES -->
    <div>
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-sm font-bold text-slate-800 uppercase">
                📅 Control de las 4 Actividades Mensuales y sus 6 Evidencias ({{ $cursoActivo->nombre }})
            </h3>
            <a href="{{ route('estrategia.admin.actividades', ['curso_id' => $cursoActivo->id, 'mes' => $mes, 'anio' => $anio]) }}" class="text-xs font-bold text-slate-600 hover:text-slate-900">
                ✏️ Editar textos de actividades y evidencias
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($estadisticasSemanas as $sem => $stat)
                @php $act = $stat['actividad']; @endphp
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 flex flex-col justify-between hover:border-amber-500 transition">
                    <div>
                        <div class="flex items-center justify-between text-xs font-bold text-slate-500 mb-1">
                            <span class="bg-amber-100 text-amber-900 px-2 py-0.5 rounded">ACTIVIDAD {{ $sem }}</span>
                            <span>⏱ {{ $act->tiempo_minutos }} min | {{ optional($act->fecha_aplicacion)->format('d/m/Y') }}</span>
                        </div>
                        <h4 class="font-bold text-sm text-slate-900 leading-snug mt-1">
                            {{ $act->titulo }}
                        </h4>
                        <p class="text-xs text-slate-500 mt-1.5 line-clamp-2">
                            {{ $act->planteamiento }}
                        </p>

                        <div class="mt-3 space-y-1 text-xs">
                            <div class="flex justify-between text-[11px] font-semibold">
                                <span class="text-red-600">Ini: {{ $stat['pct_inicial'] }}%</span>
                                <span class="text-amber-600">Proc: {{ $stat['pct_en_proceso'] }}%</span>
                                <span class="text-emerald-700">Log: {{ $stat['pct_logrado'] }}%</span>
                            </div>
                            <div class="w-full h-2 bg-slate-200 rounded-full overflow-hidden flex">
                                <div style="width: {{ $stat['pct_inicial'] }}%" class="bg-red-500"></div>
                                <div style="width: {{ $stat['pct_en_proceso'] }}%" class="bg-amber-400"></div>
                                <div style="width: {{ $stat['pct_logrado'] }}%" class="bg-emerald-600"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] text-emerald-700 font-semibold">✓ 6 Evidencias</span>
                        <a href="{{ route('estrategia.evaluar', ['curso' => $cursoActivo->id, 'semana' => $sem, 'mes' => $mes, 'anio' => $anio]) }}"
                           class="bg-slate-900 hover:bg-amber-500 hover:text-slate-950 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition">
                            Calificar Actividad {{ $sem }} →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 5. RESUMEN DE ESTUDIANTES Y DESCARGA INDIVIDUAL -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-4 bg-slate-50 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h3 class="text-sm font-bold uppercase text-slate-800">
                    👨‍🎓 Resumen de Seguimiento por Estudiante ({{ $cursoActivo->nombre }} "{{ $cursoActivo->paralelo }}")
                </h3>
                <p class="text-xs text-slate-500">
                    Vista mensual de las cuatro actividades y descarga del informe individual en PDF.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('estrategia.admin.estudiantes', ['curso_id' => $cursoActivo->id]) }}"
                   class="bg-slate-800 hover:bg-slate-700 text-white font-bold px-3 py-1.5 rounded-lg text-xs">
                    ➕ Gestionar / Importar Estudiantes
                </a>
                <a href="{{ route('estrategia.pdf.estudiantes', $cursoActivo->id) }}"
                   class="bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold px-3 py-1.5 rounded-lg text-xs">
                    📥 PDF de Todos ({{ $cursoActivo->estudiantes->count() }})
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-800 text-white uppercase text-[11px]">
                        <th class="py-2.5 px-3 text-center w-10">N.º</th>
                        <th class="py-2.5 px-3">Apellidos y Nombres</th>
                        <th class="py-2.5 px-2 text-center">Sem. 1</th>
                        <th class="py-2.5 px-2 text-center">Sem. 2</th>
                        <th class="py-2.5 px-2 text-center">Sem. 3</th>
                        <th class="py-2.5 px-2 text-center">Sem. 4</th>
                        <th class="py-2.5 px-2 text-center">Evidencias</th>
                        <th class="py-2.5 px-3">Síntesis Automática del Proceso</th>
                        <th class="py-2.5 px-3 text-center">Informe PDF</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($cursoActivo->estudiantes as $idx => $est)
                        @php
                            $resumen = $est->ResumenProceso();
                            $evalsPorSem = $est->evaluaciones->keyBy(fn($e) => $e->actividad->numero_semana ?? 0);
                            $badgeColor = [
                                'INICIAL' => 'bg-red-100 text-red-800 border-red-300',
                                'EN_PROCESO' => 'bg-amber-100 text-amber-800 border-amber-300',
                                'LOGRADO' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                            ];
                            $shortLabel = ['INICIAL' => 'INICIAL', 'EN_PROCESO' => 'PROCESO', 'LOGRADO' => 'LOGRADO'];
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="py-2.5 px-3 text-center font-bold text-slate-500">{{ $idx + 1 }}</td>
                            <td class="py-2.5 px-3 font-bold text-slate-900">
                                {{ $est->nombres_apellidos }}
                                <span class="block text-[10px] font-normal text-slate-500">
                                    Diagnóstico: {{ $est->diagnostico_inicial }}
                                </span>
                            </td>
                            @for($s = 1; $s <= 4; $s++)
                                @php $niv = $evalsPorSem->get($s)?->nivel_desempeno ?? 'EN_PROCESO'; @endphp
                                <td class="py-2.5 px-2 text-center">
                                    <span class="inline-block px-2 py-0.5 rounded border text-[10px] font-bold {{ $badgeColor[$niv] ?? '' }}">
                                        {{ $shortLabel[$niv] ?? $niv }}
                                    </span>
                                </td>
                            @endfor
                            <td class="py-2.5 px-2 text-center font-bold">
                                {{ $resumen['total_cumplidas'] }}/{{ $resumen['total_posibles'] }}
                                <span class="block text-[10px] text-emerald-700">({{ $resumen['porcentaje_evidencias'] }}%)</span>
                            </td>
                            <td class="py-2.5 px-3 text-[11px] text-slate-600 max-w-md">
                                {{ \Illuminate\Support\Str::limit($resumen['parrafo_evolucion'], 135) }}
                            </td>
                            <td class="py-2.5 px-3 text-center">
                                <a href="{{ route('estrategia.pdf.estudiante.individual', $est->id) }}"
                                   class="inline-block bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold px-2.5 py-1 rounded text-[11px] shadow-sm transition">
                                    📄 PDF Individual
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection

@push('scripts')
@if($cursoActivo)
<script>
    const labelsSemanas = ['Actividad 1', 'Actividad 2', 'Actividad 3', 'Actividad 4'];
    const dataInicial = [
        {{ $estadisticasSemanas[1]['inicial'] ?? 0 }},
        {{ $estadisticasSemanas[2]['inicial'] ?? 0 }},
        {{ $estadisticasSemanas[3]['inicial'] ?? 0 }},
        {{ $estadisticasSemanas[4]['inicial'] ?? 0 }}
    ];
    const dataProceso = [
        {{ $estadisticasSemanas[1]['en_proceso'] ?? 0 }},
        {{ $estadisticasSemanas[2]['en_proceso'] ?? 0 }},
        {{ $estadisticasSemanas[3]['en_proceso'] ?? 0 }},
        {{ $estadisticasSemanas[4]['en_proceso'] ?? 0 }}
    ];
    const dataLogrado = [
        {{ $estadisticasSemanas[1]['logrado'] ?? 0 }},
        {{ $estadisticasSemanas[2]['logrado'] ?? 0 }},
        {{ $estadisticasSemanas[3]['logrado'] ?? 0 }},
        {{ $estadisticasSemanas[4]['logrado'] ?? 0 }}
    ];

    new Chart(document.getElementById('chartEvolucion'), {
        type: 'bar',
        data: {
            labels: labelsSemanas,
            datasets: [
                { label: 'Inicial (Apoyo Alto)', data: dataInicial, backgroundColor: '#ef4444', borderRadius: 4 },
                { label: 'En Proceso (Apoyo Medio)', data: dataProceso, backgroundColor: '#f59e0b', borderRadius: 4 },
                { label: 'Logrado (Autónomo)', data: dataLogrado, backgroundColor: '#10b981', borderRadius: 4 }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    new Chart(document.getElementById('chartCierre'), {
        type: 'doughnut',
        data: {
            labels: ['Inicial', 'En Proceso', 'Logrado'],
            datasets: [{
                data: [
                    {{ $estadisticasSemanas[4]['inicial'] ?? 0 }},
                    {{ $estadisticasSemanas[4]['en_proceso'] ?? 0 }},
                    {{ $estadisticasSemanas[4]['logrado'] ?? 0 }}
                ],
                backgroundColor: ['#ef4444', '#f59e0b', '#10b981']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }
        }
    });
</script>
@endif
@endpush
