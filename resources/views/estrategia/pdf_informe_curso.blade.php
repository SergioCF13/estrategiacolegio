<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Informe General del Curso - {{ $curso->nombre }} - Actividad {{ $actividadSeleccionada }} - {{ $nombreMes }} {{ $anio }}</title>
<style>
    @page {
        margin: 25.4mm;
    }
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 7.5pt;
        line-height: 1.22;
        color: #26323d;
        margin: 0;
        padding: 0;
    }
    .page-break {
        page-break-before: always;
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
        margin-bottom: 4px;
    }
    .tricolor td {
        height: 4px;
        padding: 0;
        border: none;
    }
    .header-box {
        border: 1px solid #d8dee5;
        background-color: #f8fafb;
        padding: 5px 8px;
        text-align: center;
        margin-bottom: 4px;
    }
    .header-box h4 {
        margin: 0;
        font-size: 7.3pt;
        color: #66717d;
        text-transform: uppercase;
    }
    .header-box h1 {
        margin: 2px 0 1px 0;
        font-size: 10.5pt;
        color: #26323d;
        text-transform: uppercase;
    }
    .header-box h2 {
        margin: 1px 0 3px 0;
        font-size: 8.3pt;
        color: #52677d;
        text-transform: uppercase;
    }
    .badge {
        display: inline-block;
        background-color: #eef1f4;
        color: #344252;
        font-weight: bold;
        padding: 2.5px 12px;
        font-size: 8.2pt;
    }
    .meta-table {
        margin-bottom: 4px;
        font-size: 7.3pt;
    }
    .meta-table th {
        background-color: #eef1f4;
        color: #344252;
        padding: 2.5px 5px;
        border: 1px solid #d3dae1;
        text-align: left;
        width: 23%;
    }
    .meta-table td {
        padding: 2.5px 5px;
        border: 1px solid #d8dee5;
        background-color: #fff;
        width: 27%;
    }
    h3.sec-title {
        font-size: 8.2pt;
        color: #26323d;
        text-transform: uppercase;
        border-bottom: 1px solid #9aa8b6;
        padding-bottom: 1px;
        margin: 4px 0 3px 0;
    }
    .min-table {
        margin: 2px 0 4px 0;
        font-size: 6.9pt;
    }
    .min-table th {
        background-color: #eef1f4;
        color: #344252;
        padding: 2.5px 3.5px;
        border: 1px solid #d3dae1;
        text-align: center;
        font-weight: bold;
    }
    .min-table td {
        padding: 2.5px 3.5px;
        border: 1px solid #d8dee5;
        vertical-align: top;
    }
    .min-table tbody tr:nth-child(even) td {
        background-color: #f8fafb;
    }
    .center {
        text-align: center;
    }
    .box-info {
        background-color: #f5f7f9;
        border-left: 2px solid #718096;
        padding: 4px 7px;
        font-size: 7.3pt;
        margin-bottom: 4px;
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

<!-- ==================== PÁGINA 1: INFORME GENERAL DEL CURSO Y EL MES SELECCIONADO ==================== -->
<table class="tricolor">
    <tr>
        <td style="background-color:#718096; width:100%;"></td>
    </tr>
</table>

<div class="header-box">
    <h4>MINISTERIO DE EDUCACIÓN • VICEMINISTERIO DE EDUCACIÓN REGULAR • {{ $curso->distrito }}</h4>
    <h1>INFORME GENERAL PEDAGÓGICO — ACTIVIDAD {{ $actividadSeleccionada }} — {{ mb_strtoupper($nombreMes, 'UTF-8') }} {{ $anio }} — ESTRATEGIA NACIONAL 2026</h1>
    <h2>ACTIVIDAD DESARROLLADA Y SISTEMATIZACIÓN DE LOS 6 TIPOS DE EVIDENCIA</h2>
    <div class="badge">CURSO: {{ mb_strtoupper($curso->nombre, 'UTF-8') }} PARALELO "{{ $curso->paralelo }}"</div>
</div>

<table class="meta-table">
    <tr>
        <th>UNIDAD EDUCATIVA:</th>
        <td><strong>Padre Luis Variara</strong></td>
        <th>MATERIA:</th>
        <td><strong>Sistemas Informáticos</strong></td>
    </tr>
    <tr>
        <th>CAPACIDAD FORTALECIDA:</th>
        <td><strong>{{ $curso->capacidad }}</strong></td>
        <th>TRIMESTRE / GESTIÓN:</th>
        <td><strong>{{ $curso->trimestre }}</strong></td>
    </tr>
    <tr>
        <th>MAESTRO / MAESTRA:</th>
        <td><strong>Sergio Canaviri Felix</strong></td>
        <th>ESTUDIANTES EVALUADOS:</th>
        <td><strong>{{ $curso->estudiantes->count() }} estudiantes</strong></td>
    </tr>
</table>

<h3 class="sec-title">1. DIAGNÓSTICO DEL LOGRO DE APRENDIZAJES Y FUNDAMENTACIÓN DEL CURSO</h3>
<div class="box-info">
    {{ $curso->diagnostico_curso }}
</div>

<h3 class="sec-title">2. PLANIFICACIÓN Y EJECUCIÓN DE LA ACTIVIDAD {{ $actividadSeleccionada }} — {{ mb_strtoupper($nombreMes, 'UTF-8') }} {{ $anio }} CON LOS 6 TIPOS DE EVIDENCIA (Sección 5.3)</h3>

<table class="min-table">
    <thead>
        <tr>
            <th style="width:8%;">Actividad / Fecha</th>
            <th style="width:20%;">Actividad Desarrollada y Planteamiento</th>
            <th style="width:12%;">Evidencia 1:<br>Interpretación de Datos</th>
            <th style="width:12%;">Evidencia 2:<br>Resolución de Problemas</th>
            <th style="width:12%;">Evidencia 3:<br>Registros de Indagación</th>
            <th style="width:12%;">Evidencia 4:<br>Producciones Escritas</th>
            <th style="width:12%;">Evidencia 5:<br>Exposiciones Orales</th>
            <th style="width:12%;">Evidencia 6:<br>Informes y Valoración</th>
        </tr>
    </thead>
    <tbody>
        @foreach($curso->actividades as $act)
            <tr>
                <td class="center">
                    <strong>Actividad {{ $act->numero_semana }}</strong><br>
                    {{ optional($act->fecha_aplicacion)->format('d/m/Y') }}<br>
                    ({{ $act->tiempo_minutos }} min)
                </td>
                <td>
                    <strong>{{ $act->titulo }}</strong><br>
                    <span style="color:#444; font-size:6.5pt;">{{ $act->planteamiento }}</span>
                </td>
                <td>
                    {{ $act->ev_1_detalle }}
                    @php $cnt1 = $act->archivosEvidencia->where('numero_evidencia', 1)->count(); @endphp
                    @if($cnt1 > 0)<br><strong style="color:#52677d; font-size:6pt;">[+{{ $cnt1 }} adjunto(s)]</strong>@endif
                </td>
                <td>
                    {{ $act->ev_2_detalle }}
                    @php $cnt2 = $act->archivosEvidencia->where('numero_evidencia', 2)->count(); @endphp
                    @if($cnt2 > 0)<br><strong style="color:#52677d; font-size:6pt;">[+{{ $cnt2 }} adjunto(s)]</strong>@endif
                </td>
                <td>
                    {{ $act->ev_3_detalle }}
                    @php $cnt3 = $act->archivosEvidencia->where('numero_evidencia', 3)->count(); @endphp
                    @if($cnt3 > 0)<br><strong style="color:#52677d; font-size:6pt;">[+{{ $cnt3 }} adjunto(s)]</strong>@endif
                </td>
                <td>
                    {{ $act->ev_4_detalle }}
                    @php $cnt4 = $act->archivosEvidencia->where('numero_evidencia', 4)->count(); @endphp
                    @if($cnt4 > 0)<br><strong style="color:#52677d; font-size:6pt;">[+{{ $cnt4 }} adjunto(s)]</strong>@endif
                </td>
                <td>
                    {{ $act->ev_5_detalle }}
                    @php $cnt5 = $act->archivosEvidencia->where('numero_evidencia', 5)->count(); @endphp
                    @if($cnt5 > 0)<br><strong style="color:#52677d; font-size:6pt;">[+{{ $cnt5 }} adjunto(s)]</strong>@endif
                </td>
                <td>
                    {{ $act->ev_6_detalle }}
                    @php $cnt6 = $act->archivosEvidencia->where('numero_evidencia', 6)->count(); @endphp
                    @if($cnt6 > 0)<br><strong style="color:#52677d; font-size:6pt;">[+{{ $cnt6 }} adjunto(s)]</strong>@endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<h3 class="sec-title">3. RESULTADOS Y LOGROS DE LA ACTIVIDAD {{ $actividadSeleccionada }} EN EL CURSO ({{ $curso->nombre }})</h3>
<table class="min-table">
    <thead>
        <tr>
            <th style="width:9%;">Actividad</th>
            <th style="width:12%;">Nivel INICIAL<br>(Apoyo Alto)</th>
            <th style="width:13%;">Nivel EN PROCESO<br>(Apoyo Medio)</th>
            <th style="width:12%;">Nivel LOGRADO<br>(Autónomo)</th>
            <th style="width:27%;">Logros Cualitativos Alcanzados en Aula</th>
            <th style="width:27%;">Dificultades Superadas y Mediación Docente</th>
        </tr>
    </thead>
    <tbody>
        @foreach($estadisticasSemanas as $sem => $st)
            @php $act = $st['actividad']; @endphp
            <tr>
                <td class="center"><strong>Actividad {{ $sem }}</strong></td>
                <td class="center lvl-ini">{{ $st['inicial'] }} est. ({{ $st['pct_inicial'] }}%)</td>
                <td class="center lvl-pro">{{ $st['en_proceso'] }} est. ({{ $st['pct_en_proceso'] }}%)</td>
                <td class="center lvl-log">{{ $st['logrado'] }} est. ({{ $st['pct_logrado'] }}%)</td>
                <td>{{ $act->logros_sesion }}</td>
                <td>{{ $act->dificultades_sesion }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@php
    $todosArchivos = $curso->actividades->flatMap(function ($act) {
        return $act->archivosEvidencia->map(function ($ar) use ($act) {
            $ar->semana_num = $act->numero_semana;
            $ar->actividad_titulo = $act->titulo;
            return $ar;
        });
    });
    $imagenesCurso = $todosArchivos->where('tipo_archivo', 'IMAGEN')->values();
    $videosCurso = $todosArchivos->where('tipo_archivo', 'VIDEO')->values();
@endphp

@if($todosArchivos->isNotEmpty())
    @if($imagenesCurso->isNotEmpty())
        @foreach($imagenesCurso->chunk(2) as $paginaImagenes)
            <div class="evidence-page">
                <h3 class="sec-title" style="margin-top:8px;">
                    4. ANEXO MULTIMEDIA — ACTIVIDAD {{ $actividadSeleccionada }} (FOTOGRAFÍAS Y VIDEOS)
                </h3>
                <table style="width:100%; border-collapse:collapse; margin-bottom:5px;">
                    <tr>
                        @foreach($paginaImagenes as $img)
                            @php $b64 = $img->obtenerImagenBase64ParaPdf(); @endphp
                            <td style="width:50%; border:1px solid #d8dee5; background-color:#f8fafb; padding:5px; vertical-align:top; text-align:center;">
                                <div style="font-size:6.3pt; font-weight:bold; color:#52677d; margin-bottom:2px;">
                                    ACTIVIDAD {{ $img->semana_num }} • EVIDENCIA {{ $img->numero_evidencia }}: {{ mb_strtoupper($img->nombreTipoEvidencia(), 'UTF-8') }}
                                </div>
                                @if($b64)
                                    <img src="{{ $b64 }}" style="max-width:300px; max-height:360px; border:1px solid #d8dee5; margin:3px auto; display:block;">
                                @endif
                                <div style="font-size:6.5pt; color:#111; margin-top:2px;">
                                    <strong>{{ $img->titulo }}</strong><br>
                                    <span style="color:#66717d; font-size:6pt;">
                                        {{ $img->estudiante ? 'Est.: ' . $img->estudiante->nombres_apellidos : 'Evidencia General de Aula' }}
                                    </span>
                                </div>
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

    @if($videosCurso->isNotEmpty())
        <h3 class="sec-title" style="margin-top:8px;">
            4. ANEXO MULTIMEDIA — ACTIVIDAD {{ $actividadSeleccionada }} (FOTOGRAFÍAS Y VIDEOS)
        </h3>
        <table class="min-table" style="margin-top:3px;">
            <thead>
                <tr>
                    <th style="width:10%;">Actividad</th>
                    <th style="width:22%;">Tipo de Evidencia (1 al 6)</th>
                    <th style="width:23%;">Estudiante / Alcance</th>
                    <th style="width:25%;">Título de la Evidencia Audiovisual</th>
                    <th style="width:20%;">Archivo / Enlace de Video</th>
                </tr>
            </thead>
            <tbody>
                @foreach($videosCurso as $vid)
                    <tr>
                        <td class="center"><strong>Actividad {{ $vid->semana_num }}</strong></td>
                        <td><strong>Ev. {{ $vid->numero_evidencia }}:</strong> {{ $vid->nombreTipoEvidencia() }}</td>
                        <td>{{ $vid->estudiante ? $vid->estudiante->nombres_apellidos : 'Evidencia Grupal del Curso' }}</td>
                        <td><strong>[VIDEO]</strong> {{ $vid->titulo }}</td>
                        <td style="font-size:6pt; color:#52677d; word-break:break-all;">{{ $vid->ruta_archivo }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endif

<table style="margin-top:55px; text-align:center; font-size:7.8pt;">
    <tr>
        <td style="width:45%; padding:0 20px;">
            <div style="border-top:1px solid #222; padding-top:3px;">
                <strong>Sergio Canaviri Felix</strong><br>
                MAESTRO
            </div>
        </td>
        <td style="width:10%;"></td>
        <td style="width:45%; padding:0 20px;">
            <div style="border-top:1px solid #222; padding-top:3px;">
                <strong>{{ $curso->director }}</strong><br>
                DIRECTOR
            </div>
        </td>
    </tr>
</table>

</body>
</html>
