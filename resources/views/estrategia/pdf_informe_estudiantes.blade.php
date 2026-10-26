<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Informes Individuales por Estudiante - {{ $curso->nombre }} — Actividad {{ $actividadSeleccionada }} — {{ $nombreMes }} {{ $anio }}</title>
<style>
    @page {
        margin: 25.4mm;
    }
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 7.2pt;
        line-height: 1.18;
        color: #26323d;
        margin: 0;
        padding: 0;
    }
    .student-page {
        page-break-after: always;
    }
    .student-page:last-child {
        page-break-after: auto;
    }
    .evidence-page {
        page-break-inside: avoid;
    }
    .evidence-page + .evidence-page {
        page-break-before: always;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    .tricolor {
        width: 100%;
        margin-bottom: 3px;
    }
    .tricolor td {
        height: 4px;
        padding: 0;
        border: none;
    }
    .header-box {
        border: 1px solid #d8dee5;
        background-color: #f8fafb;
        padding: 4px 6px;
        text-align: center;
        margin-bottom: 3px;
    }
    .header-box h4 {
        margin: 0;
        font-size: 7pt;
        color: #66717d;
        text-transform: uppercase;
    }
    .header-box h1 {
        margin: 1px 0;
        font-size: 9.8pt;
        color: #26323d;
        text-transform: uppercase;
    }
    .header-box h2 {
        margin: 0;
        font-size: 7.8pt;
        color: #52677d;
        text-transform: uppercase;
    }
    .meta-table {
        margin-bottom: 3px;
        font-size: 7pt;
    }
    .meta-table th {
        background-color: #eef1f4;
        color: #344252;
        padding: 2px 5px;
        border: 1px solid #d3dae1;
        text-align: left;
        width: 22%;
    }
    .meta-table td {
        padding: 2px 5px;
        border: 1px solid #d8dee5;
        background-color: #fff;
        width: 28%;
    }
    h3.sec-title {
        font-size: 7.8pt;
        color: #26323d;
        text-transform: uppercase;
        border-bottom: 1px solid #9aa8b6;
        padding-bottom: 1px;
        margin: 3px 0 2px 0;
    }
    .min-table {
        margin: 1.5px 0 3px 0;
        font-size: 6.7pt;
    }
    .min-table th {
        background-color: #eef1f4;
        color: #344252;
        padding: 2px 3px;
        border: 1px solid #d3dae1;
        text-align: center;
        font-weight: bold;
    }
    .min-table td {
        padding: 2px 3.5px;
        border: 1px solid #d8dee5;
        vertical-align: middle;
    }
    .min-table tbody tr:nth-child(even) td {
        background-color: #f8fafb;
    }
    .center {
        text-align: center;
    }
    .report-grid td {
        width: 50%;
        border: 1px solid #d8dee5;
        background-color: #f8fafb;
        padding: 4px 6px;
        vertical-align: top;
        font-size: 6.9pt;
    }
    .report-grid strong.block-title {
        color: #52677d;
        text-transform: uppercase;
        display: block;
        margin-bottom: 2px;
        font-size: 7.1pt;
    }
    .lvl-ini { color: #7b4545; font-weight: bold; }
    .lvl-pro { color: #80683f; font-weight: bold; }
    .lvl-log { color: #456a59; font-weight: bold; }
    body, body * {
        color: #000 !important;
        background-color: #fff !important;
        background-image: none !important;
    }
</style>
</head>
<body>

@foreach($estudiantes as $idx => $est)
    @php
        $res = $semana ? null : $est->ResumenProceso();
        $evals = $est->evaluaciones->sortBy(fn($e) => $e->actividad->numero_semana ?? 0)->values();
        $evalSemana = $evals->last();
        $actividadSemana = $curso->actividades->last();
        $lblNivel = ['INICIAL' => 'INICIAL', 'EN_PROCESO' => 'EN PROCESO', 'LOGRADO' => 'LOGRADO'];
        $clsNivel = ['INICIAL' => 'lvl-ini', 'EN_PROCESO' => 'lvl-pro', 'LOGRADO' => 'lvl-log'];
        $lblApoyo = [
            'APOYO_ALTO' => 'Apoyo Alto (Directo)',
            'APOYO_MEDIO' => 'Apoyo Medio (Guiado)',
            'APOYO_BAJO' => 'Apoyo Bajo (Autónomo)',
        ];
    @endphp

    <div class="student-page">
        <table class="tricolor">
            <tr>
                <td style="background-color:#718096; width:100%;"></td>
            </tr>
        </table>

        <div class="header-box">
            <h4>MINISTERIO DE EDUCACIÓN • {{ $curso->distrito }}</h4>
            <h1>INFORME INDIVIDUAL — ACTIVIDAD {{ $actividadSeleccionada }} — {{ mb_strtoupper($nombreMes, 'UTF-8') }} {{ $anio }} — SEGUIMIENTO Y PROCESO DE APRENDIZAJE</h1>
            <h2>ESTRATEGIA NACIONAL DE FORTALECIMIENTO DE LOGRO DE APRENDIZAJES (2026)</h2>
        </div>

        <table class="meta-table">
            <tr>
                <th>ESTUDIANTE:</th>
                <td colspan="3"><strong style="font-size:8pt;">{{ $est->nombres_apellidos }}</strong></td>
            </tr>
            <tr>
                <th>CURSO / PARALELO:</th>
                <td><strong>{{ $curso->nombre }} "{{ $curso->paralelo }}"</strong></td>
                <th>UNIDAD EDUCATIVA:</th>
                <td><strong>Padre Luis Variara</strong></td>
            </tr>
            <tr>
                <th>MATERIA:</th>
                <td><strong>Sistemas Informáticos</strong></td>
                <th>CAPACIDAD EVALUADA:</th>
                <td><strong>{{ $curso->capacidad }}</strong></td>
            </tr>
            <tr>
                <th>NIVEL DIAGNÓSTICO INICIAL:</th>
                <td><span class="{{ $clsNivel[$est->diagnostico_inicial] ?? '' }}">{{ $lblNivel[$est->diagnostico_inicial] ?? $est->diagnostico_inicial }}</span></td>
                @if($semana)
                    <th>NIVEL DE LA ACTIVIDAD {{ $actividadSeleccionada }}:</th>
                    <td>
                        @if($evalSemana)
                            <span class="{{ $clsNivel[$evalSemana->nivel_desempeno] ?? '' }}">{{ $lblNivel[$evalSemana->nivel_desempeno] ?? $evalSemana->nivel_desempeno }} ({{ $evalSemana->totalEvidenciasCumplidas() }}/6 evidencias)</span>
                        @else
                            Sin evaluación registrada
                        @endif
                    </td>
                @else
                    <th>NIVEL AL CIERRE DEL CICLO:</th>
                    <td><span class="{{ $clsNivel[$res['nivel_final_raw']] ?? '' }}">{{ $res['nivel_final'] }} ({{ $res['porcentaje_evidencias'] }}% Evidencias)</span></td>
                @endif
            </tr>
        </table>

        <h3 class="sec-title">1. DESARROLLO DE LA ACTIVIDAD {{ $actividadSeleccionada }}, CRITERIOS Y ANDAMIAJE</h3>
        <table class="min-table">
            <thead>
                <tr>
                    <th style="width:9%;">Actividad</th>
                    <th style="width:29%;">Actividad Desarrollada en Clase</th>
                    <th style="width:10.5%;">Criterio 1:<br>Comprende</th>
                    <th style="width:10.5%;">Criterio 2:<br>Resuelve</th>
                    <th style="width:10.5%;">Criterio 3:<br>Verifica</th>
                    <th style="width:10.5%;">Criterio 4:<br>Transfiere</th>
                    <th style="width:10%;">Andamiaje<br>Recibido</th>
                    <th style="width:10%;">Nivel<br>Alcanzado</th>
                </tr>
            </thead>
            <tbody>
                @if($semana && !$evalSemana && $actividadSemana)
                    <tr>
                        <td class="center"><strong>Actividad {{ $actividadSemana->numero_semana }}</strong><br><span style="font-size:6pt;">{{ optional($actividadSemana->fecha_aplicacion)->format('d/m/Y') }}</span></td>
                        <td><strong>{{ $actividadSemana->titulo }}</strong></td>
                        <td class="center">—</td><td class="center">—</td><td class="center">—</td><td class="center">—</td><td class="center">—</td>
                        <td class="center">Sin evaluación registrada</td>
                    </tr>
                @else
                @foreach($evals as $ev)
                    @php $act = $ev->actividad; @endphp
                    <tr>
                        <td class="center">
                            <strong>Actividad {{ $act->numero_semana }}</strong><br>
                            <span style="font-size:6pt;">{{ optional($act->fecha_aplicacion)->format('d/m/Y') }}</span>
                        </td>
                        <td><strong>{{ $act->titulo }}</strong></td>
                        <td class="center">{{ $lblNivel[$ev->criterio_1] ?? $ev->criterio_1 }}</td>
                        <td class="center">{{ $lblNivel[$ev->criterio_2] ?? $ev->criterio_2 }}</td>
                        <td class="center">{{ $lblNivel[$ev->criterio_3] ?? $ev->criterio_3 }}</td>
                        <td class="center">{{ $lblNivel[$ev->criterio_4] ?? $ev->criterio_4 }}</td>
                        <td class="center">{{ $lblApoyo[$ev->andamiaje_aplicado] ?? $ev->andamiaje_aplicado }}</td>
                        <td class="center {{ $clsNivel[$ev->nivel_desempeno] ?? '' }}">
                            {{ $lblNivel[$ev->nivel_desempeno] ?? $ev->nivel_desempeno }}
                        </td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>

        <h3 class="sec-title">2. REGISTRO DE CUMPLIMIENTO DE LOS 6 TIPOS DE EVIDENCIA — ACTIVIDAD {{ $actividadSeleccionada }} (Sección 5.3)</h3>
        <table class="min-table">
            <thead>
                <tr>
                    <th style="width:9%;">Actividad</th>
                    <th style="width:8.5%;">1. Interp.<br>Datos</th>
                    <th style="width:8.5%;">2. Resol.<br>Problemas</th>
                    <th style="width:8.5%;">3. Reg.<br>Indagación</th>
                    <th style="width:8.5%;">4. Prod.<br>Escrita</th>
                    <th style="width:8.5%;">5. Expos.<br>Oral</th>
                    <th style="width:8.5%;">6. Informe<br>Integrador</th>
                    <th style="width:40%;">Retroalimentación Formativa de la Sesión (Sección 5.4)</th>
                </tr>
            </thead>
            <tbody>
                @if($semana && !$evalSemana && $actividadSemana)
                    <tr>
                        <td class="center"><strong>Actividad {{ $actividadSemana->numero_semana }}</strong></td>
                        <td colspan="6" class="center">Sin registro de cumplimiento</td>
                        <td>Sin retroalimentación registrada para esta actividad.</td>
                    </tr>
                @else
                @foreach($evals as $ev)
                    <tr>
                        <td class="center"><strong>Actividad {{ $ev->actividad->numero_semana }}</strong></td>
                        <td class="center"><strong>{{ $ev->ev_1 ? 'SÍ (✓)' : 'NO' }}</strong></td>
                        <td class="center"><strong>{{ $ev->ev_2 ? 'SÍ (✓)' : 'NO' }}</strong></td>
                        <td class="center"><strong>{{ $ev->ev_3 ? 'SÍ (✓)' : 'NO' }}</strong></td>
                        <td class="center"><strong>{{ $ev->ev_4 ? 'SÍ (✓)' : 'NO' }}</strong></td>
                        <td class="center"><strong>{{ $ev->ev_5 ? 'SÍ (✓)' : 'NO' }}</strong></td>
                        <td class="center"><strong>{{ $ev->ev_6 ? 'SÍ (✓)' : 'NO' }}</strong></td>
                        <td style="font-size:6.5pt;">{{ $ev->retroalimentacion }}</td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>

        <h3 class="sec-title">3. INFORME CUALITATIVO INTEGRAL DEL PROCESO DE APRENDIZAJE DEL ESTUDIANTE</h3>

        @if($semana)
        <table class="report-grid">
            <tr>
                <td>
                    <strong class="block-title">Actividad {{ $actividadSeleccionada }}:</strong>
                    {{ $actividadSemana?->titulo ?: 'No hay información registrada para esta actividad.' }}
                    @if($actividadSemana?->planteamiento)<br>{{ $actividadSemana->planteamiento }}@endif
                </td>
                <td>
                    <strong class="block-title">Desempeño de esta actividad:</strong>
                    {{ $evalSemana ? ($lblNivel[$evalSemana->nivel_desempeno] ?? $evalSemana->nivel_desempeno) : 'Sin evaluación registrada.' }}
                    @if($evalSemana)<br>{{ $lblApoyo[$evalSemana->andamiaje_aplicado] ?? $evalSemana->andamiaje_aplicado }}@endif
                </td>
            </tr>
            <tr>
                <td>
                    <strong class="block-title">Logros de la sesión:</strong>
                    {{ $actividadSemana?->logros_sesion ?: 'Sin logros registrados para esta actividad.' }}
                </td>
                <td>
                    <strong class="block-title">Dificultades y retroalimentación:</strong>
                    {{ $actividadSemana?->dificultades_sesion ?: 'Sin dificultades registradas para esta actividad.' }}
                    @if($evalSemana?->retroalimentacion)<br>{{ $evalSemana->retroalimentacion }}@endif
                </td>
            </tr>
        </table>
        @else
        <table class="report-grid">
            <tr>
                <td>
                    <strong class="block-title">A) Diagnóstico de Partida y Eslabón de Dificultad:</strong>
                    {{ $res['parrafo_diagnostico'] }}
                </td>
                <td>
                    <strong class="block-title">B) Evolución y Desempeño en las Actividades:</strong>
                    {{ $res['parrafo_evolucion'] }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong class="block-title">C) Valoración de los 6 Tipos de Evidencia:</strong>
                    {{ $res['parrafo_evidencias'] }}
                </td>
                <td>
                    <strong class="block-title">D) Acción Pedagógica Consecuente y Recomendación:</strong>
                    {{ $res['parrafo_recomendacion'] }}
                </td>
            </tr>
        </table>
        @endif

        @php
            $evidenciasMultimediaEst = $est->archivosEvidencia;
            $imgsEst = $evidenciasMultimediaEst->where('tipo_archivo', 'IMAGEN')->values();
            $vidsEst = $evidenciasMultimediaEst->where('tipo_archivo', 'VIDEO')->take(2)->values();
        @endphp

        @if($imgsEst->isNotEmpty() || $vidsEst->isNotEmpty())
            @if($imgsEst->isNotEmpty())
                @foreach($imgsEst->chunk(2) as $paginaImagenes)
                    <div class="evidence-page">
                        <h3 class="sec-title">4. EVIDENCIAS MULTIMEDIA ADJUNTAS — ACTIVIDAD {{ $actividadSeleccionada }}</h3>
                        <table style="width:100%; border-collapse:collapse; margin-bottom:3px;">
                            <tr>
                                @foreach($paginaImagenes as $imgE)
                                    @php $b64Est = $imgE->obtenerImagenBase64ParaPdf(); @endphp
                                    <td style="width:50%; border:1px solid #d8dee5; background-color:#f8fafb; padding:5px; text-align:center; vertical-align:top;">
                                        <div style="font-size:6pt; font-weight:bold; color:#52677d;">
                                            Actividad {{ $imgE->actividad->numero_semana ?? '-' }} • Ev. {{ $imgE->numero_evidencia }} ({{ $imgE->nombreTipoEvidencia() }})
                                        </div>
                                        @if($b64Est)
                                            <img src="{{ $b64Est }}" style="max-width:300px; max-height:360px; border:1px solid #d8dee5; margin:3px auto; display:block;">
                                        @endif
                                        <div style="font-size:6pt; color:#26323d;">{{ $imgE->titulo }}</div>
                                    </td>
                                @endforeach
                                @if($paginaImagenes->count() === 1)
                                    <td style="width:50%; border:none;"></td>
                                @endif
                            </tr>
                        </table>
                    </div>
                @endforeach
            @endif
            @if($vidsEst->isNotEmpty())
                <h3 class="sec-title">4. EVIDENCIAS MULTIMEDIA ADJUNTAS — ACTIVIDAD {{ $actividadSeleccionada }}</h3>
                <div style="font-size:6.3pt; background-color:#f5f7f9; border:1px solid #d8dee5; padding:2.5px 5px; margin-bottom:3px;">
                    <strong>Evidencias en Video Registradas:</strong>
                    @foreach($vidsEst as $vE)
                        • [Actividad {{ $vE->actividad->numero_semana ?? '-' }} - Ev. {{ $vE->numero_evidencia }} {{ $vE->nombreTipoEvidencia() }}]: <strong>{{ $vE->titulo }}</strong> ({{ $vE->ruta_archivo }}) {{ !$loop->last ? '|' : '' }}
                    @endforeach
                </div>
            @endif
        @endif

        <table style="margin-top:50px; text-align:center; font-size:7.2pt;">
            <tr>
                <td style="width:45%; padding:0 18px;">
                    <div style="border-top:1px solid #222; padding-top:3px;">
                        <strong>Sergio Canaviri Felix</strong><br>
                        MAESTRO
                    </div>
                </td>
                <td style="width:10%;"></td>
                <td style="width:45%; padding:0 18px;">
                    <div style="border-top:1px solid #222; padding-top:3px;">
                        <strong>{{ $curso->director }}</strong><br>
                        DIRECTOR
                    </div>
                </td>
            </tr>
        </table>
    </div>
@endforeach

</body>
</html>
