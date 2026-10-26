@extends('layouts.admin')

@section('title', 'Calificación Actividad ' . $semana . ' — Panel de Administración')
@section('page_title', 'Calificación y Control de las 6 Evidencias — Actividad ' . $semana)
@section('page_subtitle', $curso->nombre . ' "' . $curso->paralelo . '" • ' . $actividad->nombreMes() . ' ' . $anio . ' • ' . $actividad->titulo)

@section('content')
<div class="flex flex-wrap items-center justify-between gap-2 bg-white p-3.5 rounded-xl border border-slate-200 shadow-sm">
    <div class="flex items-center gap-2 flex-wrap">
        <form method="GET" action="{{ route('estrategia.evaluar', ['curso' => $curso->id, 'semana' => $semana]) }}" class="flex items-end gap-2">
            <label class="text-xs font-bold text-slate-500">Mes
                <select name="mes" class="block rounded-lg border-slate-300 text-xs">
                    @foreach(range(1, 12) as $numeroMes)
                        <option value="{{ $numeroMes }}" @selected($mes === $numeroMes)>{{ \Carbon\Carbon::createFromDate($anio, $numeroMes, 1)->locale('es')->translatedFormat('F') }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-xs font-bold text-slate-500">Año
                <input type="number" name="anio" min="2020" max="2100" value="{{ $anio }}" class="block w-20 rounded-lg border-slate-300 text-xs">
            </label>
            <button class="rounded-lg bg-slate-900 px-3 py-2 text-xs font-bold text-white">Ver</button>
        </form>
        <span class="text-xs font-bold uppercase text-slate-500">Actividad:</span>
        @for($s = 1; $s <= 4; $s++)
            <a href="{{ route('estrategia.evaluar', ['curso' => $curso->id, 'semana' => $s, 'mes' => $mes, 'anio' => $anio]) }}"
               class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ $semana == $s ? 'bg-amber-500 text-slate-950 shadow' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                📅 Actividad {{ $s }}
            </a>
        @endfor
    </div>
    <div class="flex items-center gap-2 flex-wrap">
        <button type="button" onclick="abrirModal('modalSubirEvidenciaSemanal')"
                class="bg-emerald-600 hover:bg-emerald-700 text-white px-3.5 py-1.5 rounded-lg text-xs font-extrabold shadow flex items-center gap-1.5">
            <span>📸🎥</span>
            <span>Subir Foto o Video de Evidencia (Actividad {{ $semana }})</span>
        </button>
        <a href="{{ route('estrategia.pdf.curso', ['curso' => $curso->id, 'mes' => $mes, 'anio' => $anio]) }}" class="bg-slate-900 text-white hover:bg-slate-800 px-3.5 py-1.5 rounded-lg text-xs font-bold">
            📊 Descargar Informe General PDF
        </a>
    </div>
</div>

<!-- GALERÍA RÁPIDA DE IMÁGENES Y VIDEOS ADJUNTOS EN ESTA ACTIVIDAD -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-xs font-extrabold uppercase text-slate-800">
            🖼️🎬 Evidencias Multimedia (Imágenes y Videos) Registradas en la Actividad {{ $semana }} ({{ $actividad->archivosEvidencia->count() }})
        </h3>
        <button type="button" onclick="abrirModal('modalSubirEvidenciaSemanal')" class="text-xs font-bold text-emerald-700 hover:underline">
            + Adjuntar Imagen o Video
        </button>
    </div>

    @if($actividad->archivosEvidencia->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
            @foreach($actividad->archivosEvidencia as $arch)
                <div class="border border-slate-200 rounded-xl overflow-hidden bg-slate-50 flex flex-col justify-between text-xs">
                    <div>
                        @if($arch->tipo_archivo === 'IMAGEN')
                            <div class="h-32 bg-slate-200 relative overflow-hidden">
                                <img src="{{ asset($arch->ruta_archivo) }}" alt="{{ $arch->titulo }}" class="w-full h-full object-cover">
                                <span class="absolute top-1.5 left-1.5 bg-slate-900/80 text-amber-400 text-[10px] font-bold px-2 py-0.5 rounded">
                                    📷 Ev. #{{ $arch->numero_evidencia }}
                                </span>
                            </div>
                        @else
                            <div class="h-32 bg-slate-950 relative flex items-center justify-center">
                                @if(str_starts_with($arch->ruta_archivo, 'http'))
                                    <a href="{{ $arch->ruta_archivo }}" target="_blank" class="bg-amber-500 text-slate-950 font-bold px-3 py-1.5 rounded text-[11px]">
                                        ▶️ Abrir Video Externo
                                    </a>
                                @else
                                    <video controls class="w-full h-full object-contain">
                                        <source src="{{ asset($arch->ruta_archivo) }}" type="{{ $arch->mime_type ?: 'video/mp4' }}">
                                    </video>
                                @endif
                                <span class="absolute top-1.5 left-1.5 bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded pointer-events-none">
                                    🎥 Video Ev. #{{ $arch->numero_evidencia }}
                                </span>
                            </div>
                        @endif
                        <div class="p-2">
                            <p class="font-bold text-slate-900 truncate">{{ $arch->titulo ?: 'Evidencia de clase' }}</p>
                            <p class="text-[10px] text-amber-700 font-semibold">{{ $arch->nombreTipoEvidencia() }}</p>
                            <p class="text-[10px] text-slate-500">{{ $arch->estudiante ? '👤 ' . $arch->estudiante->nombres_apellidos : '👥 Todo el Curso' }}</p>
                        </div>
                    </div>
                    <div class="px-2 py-1.5 bg-white border-t border-slate-200 flex justify-between items-center text-[11px]">
                        <a href="{{ str_starts_with($arch->ruta_archivo, 'http') ? $arch->ruta_archivo : asset($arch->ruta_archivo) }}" target="_blank" class="text-blue-600 font-bold hover:underline">
                            Ver archivo
                        </a>
                        <form action="{{ route('estrategia.evidencia.eliminar', $arch->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta evidencia multimedia?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 font-bold hover:underline">🗑️ Quitar</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-xs text-slate-500 bg-slate-50 border border-dashed border-slate-300 rounded-lg p-3 text-center">
            Aún no subiste fotos ni videos en esta actividad. Usa el botón verde <strong>"📸🎥 Subir Foto o Video de Evidencia"</strong> para adjuntarlos.
        </p>
    @endif
</div>

<form action="{{ route('estrategia.evaluar.guardar', ['curso' => $curso->id, 'semana' => $semana]) }}" method="POST" class="space-y-5">
    @csrf
    <input type="hidden" name="mes" value="{{ $mes }}">
    <input type="hidden" name="anio" value="{{ $anio }}">

    <!-- Detalles de la Actividad y sus 6 Evidencias -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-600 mb-1">Título de la Actividad {{ $semana }}</label>
                <input type="text" name="titulo" value="{{ $actividad->titulo }}" class="w-full border border-slate-300 rounded px-2.5 py-1.5 text-xs font-semibold">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Fecha de Aplicación</label>
                <input type="date" name="fecha_aplicacion" value="{{ optional($actividad->fecha_aplicacion)->format('Y-m-d') }}" class="w-full border border-slate-300 rounded px-2.5 py-1.5 text-xs">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Duración (Minutos)</label>
                <input type="number" name="tiempo_minutos" value="{{ $actividad->tiempo_minutos }}" class="w-full border border-slate-300 rounded px-2.5 py-1.5 text-xs">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
            <div>
                <label class="block font-bold text-slate-600 mb-1">Logros observados en la sesión (Para el Informe General)</label>
                <textarea name="logros_sesion" rows="2" class="w-full border border-slate-300 rounded px-2.5 py-1.5">{{ $actividad->logros_sesion }}</textarea>
            </div>
            <div>
                <label class="block font-bold text-slate-600 mb-1">Dificultades superadas y andamiaje aplicado</label>
                <textarea name="dificultades_sesion" rows="2" class="w-full border border-slate-300 rounded px-2.5 py-1.5">{{ $actividad->dificultades_sesion }}</textarea>
            </div>
        </div>

        <div class="mt-3 pt-3 border-t border-slate-100 grid grid-cols-2 md:grid-cols-6 gap-2 text-[11px]">
            <div class="bg-slate-50 p-2 rounded border"><strong>Ev. 1 (Datos):</strong> {{ $actividad->ev_1_detalle }}</div>
            <div class="bg-slate-50 p-2 rounded border"><strong>Ev. 2 (Problemas):</strong> {{ $actividad->ev_2_detalle }}</div>
            <div class="bg-slate-50 p-2 rounded border"><strong>Ev. 3 (Indagación):</strong> {{ $actividad->ev_3_detalle }}</div>
            <div class="bg-slate-50 p-2 rounded border"><strong>Ev. 4 (Escrita):</strong> {{ $actividad->ev_4_detalle }}</div>
            <div class="bg-slate-50 p-2 rounded border"><strong>Ev. 5 (Oral):</strong> {{ $actividad->ev_5_detalle }}</div>
            <div class="bg-slate-50 p-2 rounded border"><strong>Ev. 6 (Informe):</strong> {{ $actividad->ev_6_detalle }}</div>
        </div>
    </div>

    <!-- Botones de Llenado Rápido en 1 Clic -->
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-3.5 flex flex-wrap items-center justify-between gap-3">
        <div class="flex flex-wrap items-center gap-2">
            <span class="text-xs font-bold text-amber-950 uppercase mr-1">⚡ Acción Masiva con 1 Clic:</span>
            <button type="button" onclick="setAllNivel('LOGRADO', 'APOYO_BAJO')"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-3 py-1.5 rounded shadow-sm">
                Marcar Todos: LOGRADO
            </button>
            <button type="button" onclick="setAllNivel('EN_PROCESO', 'APOYO_MEDIO')"
                    class="bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs font-bold px-3 py-1.5 rounded shadow-sm">
                Marcar Todos: EN PROCESO
            </button>
            <button type="button" onclick="setAllNivel('INICIAL', 'APOYO_ALTO')"
                    class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-3 py-1.5 rounded shadow-sm">
                Marcar Todos: INICIAL
            </button>
            <button type="button" onclick="checkAllEvidencias(true)"
                    class="bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold px-3 py-1.5 rounded shadow-sm">
                ✓ Marcar las 6 Evidencias a Todos
            </button>
        </div>

        <div class="flex items-center gap-3">
            <label class="flex items-center gap-1.5 text-xs font-semibold text-slate-800 cursor-pointer">
                <input type="checkbox" name="regenerar_retroalimentacion" value="1" checked class="rounded text-amber-600">
                <span>Autogenerar retroalimentación según nivel</span>
            </label>
            <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold px-5 py-2 rounded-lg text-xs shadow-md">
                💾 Guardar Actividad {{ $semana }}
            </button>
        </div>
    </div>

    <!-- Tabla de Calificación de Estudiantes -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="bg-slate-800 text-white text-[11px] uppercase">
                    <th class="py-2.5 px-2 text-center w-8">#</th>
                    <th class="py-2.5 px-3">Estudiante</th>
                    <th class="py-2.5 px-2 text-center">Nivel General<br>Actividad {{ $semana }}</th>
                    <th class="py-2.5 px-2 text-center">Andamiaje / Apoyo<br>(Diapositivas Mineros)</th>
                    <th class="py-2.5 px-2 text-center" colspan="6">Checklist de los 6 Tipos de Evidencia</th>
                    <th class="py-2.5 px-3">Retroalimentación Formativa (Automática o Editable)</th>
                </tr>
                <tr class="bg-slate-700 text-amber-300 text-[10px] text-center">
                    <th colspan="4"></th>
                    <th class="py-1 px-1">Ev.1<br>Datos</th>
                    <th class="py-1 px-1">Ev.2<br>Cálculo</th>
                    <th class="py-1 px-1">Ev.3<br>Verif.</th>
                    <th class="py-1 px-1">Ev.4<br>Escrito</th>
                    <th class="py-1 px-1">Ev.5<br>Oral</th>
                    <th class="py-1 px-1">Ev.6<br>Informe</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($estudiantes as $idx => $est)
                    @php $ev = $est->evaluaciones->first(); @endphp
                    <tr class="hover:bg-slate-50">
                        <td class="py-2 px-2 text-center font-bold text-slate-500">{{ $idx + 1 }}</td>
                        <td class="py-2 px-3 font-bold text-slate-900">{{ $est->nombres_apellidos }}</td>
                        <td class="py-2 px-2 text-center">
                            <select name="eval[{{ $est->id }}][nivel_desempeno]"
                                    onchange="syncRowCriteria(this, {{ $est->id }})"
                                    class="select-nivel border border-slate-300 rounded px-2 py-1 text-xs font-bold">
                                <option value="INICIAL" {{ $ev->nivel_desempeno === 'INICIAL' ? 'selected' : '' }}>1. INICIAL</option>
                                <option value="EN_PROCESO" {{ $ev->nivel_desempeno === 'EN_PROCESO' ? 'selected' : '' }}>2. EN PROCESO</option>
                                <option value="LOGRADO" {{ $ev->nivel_desempeno === 'LOGRADO' ? 'selected' : '' }}>3. LOGRADO</option>
                            </select>
                            <input type="hidden" id="c1_{{ $est->id }}" name="eval[{{ $est->id }}][criterio_1]" value="{{ $ev->criterio_1 }}">
                            <input type="hidden" id="c2_{{ $est->id }}" name="eval[{{ $est->id }}][criterio_2]" value="{{ $ev->criterio_2 }}">
                            <input type="hidden" id="c3_{{ $est->id }}" name="eval[{{ $est->id }}][criterio_3]" value="{{ $ev->criterio_3 }}">
                            <input type="hidden" id="c4_{{ $est->id }}" name="eval[{{ $est->id }}][criterio_4]" value="{{ $ev->criterio_4 }}">
                        </td>
                        <td class="py-2 px-2 text-center">
                            <select name="eval[{{ $est->id }}][andamiaje_aplicado]"
                                    id="apoyo_{{ $est->id }}"
                                    class="select-apoyo border border-slate-300 rounded px-2 py-1 text-xs">
                                <option value="APOYO_ALTO" {{ $ev->andamiaje_aplicado === 'APOYO_ALTO' ? 'selected' : '' }}>Apoyo Alto (Directo)</option>
                                <option value="APOYO_MEDIO" {{ $ev->andamiaje_aplicado === 'APOYO_MEDIO' ? 'selected' : '' }}>Apoyo Medio (Guiado)</option>
                                <option value="APOYO_BAJO" {{ $ev->andamiaje_aplicado === 'APOYO_BAJO' ? 'selected' : '' }}>Apoyo Bajo (Autónomo)</option>
                            </select>
                        </td>
                        @for($i = 1; $i <= 6; $i++)
                            @php $campo = "ev_{$i}"; @endphp
                            <td class="py-2 px-1 text-center">
                                <input type="checkbox" name="eval[{{ $est->id }}][ev_{{ $i }}]" value="1"
                                       {{ $ev->$campo ? 'checked' : '' }}
                                       class="chk-evidencia w-4 h-4 rounded text-emerald-600 border-slate-300">
                            </td>
                        @endfor
                        <td class="py-2 px-3">
                            <input type="text" name="eval[{{ $est->id }}][retroalimentacion]"
                                   value="{{ $ev->retroalimentacion }}"
                                   class="w-full border border-slate-300 rounded px-2 py-1 text-[11px] text-slate-700">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</form>

<!-- MODAL PARA SUBIR FOTOS O VIDEOS EN ESTA SEMANA -->
<div id="modalSubirEvidenciaSemanal" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 max-w-lg w-full overflow-hidden">
        <div class="bg-slate-900 text-white px-5 py-4 flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase text-emerald-400 block">{{ $actividad->nombreMes() }} {{ $anio }} • Actividad {{ $semana }} • {{ $curso->nombre }}</span>
                <h3 class="text-base font-extrabold">📸🎥 Subir Imágenes o Videos de Evidencia</h3>
            </div>
            <button type="button" onclick="cerrarModal('modalSubirEvidenciaSemanal')" class="text-slate-400 hover:text-white text-lg font-bold">✕</button>
        </div>

        <form action="{{ route('estrategia.evidencia.subir', $actividad->id) }}" method="POST" enctype="multipart/form-data" class="p-5 space-y-3.5 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 mb-1">1. ¿A cuál de los 6 Tipos de Evidencia corresponde? *</label>
                <select name="numero_evidencia" required class="w-full border-2 border-amber-400 bg-amber-50/40 rounded-lg px-3 py-2 font-extrabold text-slate-900">
                    <option value="" selected disabled>Selecciona una de las 6 evidencias</option>
                    <option value="1">Evidencia 1: Interpretación de Textos, Tablas y Datos</option>
                    <option value="2">Evidencia 2: Resolución de Problemas (Cálculos en cuaderno/pizarra)</option>
                    <option value="3">Evidencia 3: Registros de Indagación y Verificación</option>
                    <option value="4">Evidencia 4: Producciones Escritas (Dictamen / Conclusión)</option>
                    <option value="5">Evidencia 5: Exposiciones y Argumentaciones Orales (Foto o Video)</option>
                    <option value="6">Evidencia 6: Informes, Proyectos y Valoración Formativa</option>
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">2. ¿Pertenece a todo el Curso o a un Estudiante específico?</label>
                <select name="estudiante_id" class="w-full border border-slate-300 rounded-lg px-3 py-2 font-semibold">
                    <option value="">👥 Evidencia General de toda la Clase ({{ $curso->nombre }})</option>
                    @foreach($estudiantes as $est)
                        <option value="{{ $est->id }}">👤 {{ $est->nombres_apellidos }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">3. Título o Descripción de la Evidencia</label>
                <input type="text" name="titulo" placeholder="Ej: Fotografía de cuaderno resuelto / Video de exposición oral"
                       class="w-full border border-slate-300 rounded-lg px-3 py-2">
            </div>

            <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 space-y-2">
                <label class="block font-extrabold text-emerald-950">
                    4. Seleccionar Fotos (.jpg, .png, .webp) o Videos (.mp4, .webm, .mov):
                </label>
                <input type="file" name="archivos[]" multiple accept="image/*,video/*"
                       class="w-full text-xs text-slate-700 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Opcional: Enlace externo de Video (YouTube, Google Drive, TikTok)</label>
                <input type="url" name="url_externa" placeholder="https://drive.google.com/... o https://www.youtube.com/..."
                       class="w-full border border-slate-300 rounded-lg px-3 py-1.5">
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="cerrarModal('modalSubirEvidenciaSemanal')"
                        class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 font-bold">
                    Cancelar
                </button>
                <button type="submit"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold px-5 py-2 rounded-lg shadow">
                    ⬆️ Subir Evidencia
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function abrirModal(id) {
        const m = document.getElementById(id);
        m.classList.remove('hidden');
        m.classList.add('flex');
    }

    function cerrarModal(id) {
        const m = document.getElementById(id);
        m.classList.add('hidden');
        m.classList.remove('flex');
    }

    function syncRowCriteria(selectElem, estId) {
        const val = selectElem.value;
        document.getElementById('c1_' + estId).value = val;
        document.getElementById('c2_' + estId).value = val;
        document.getElementById('c3_' + estId).value = val;
        document.getElementById('c4_' + estId).value = val;
        const apoyoSelect = document.getElementById('apoyo_' + estId);
        if (val === 'INICIAL') apoyoSelect.value = 'APOYO_ALTO';
        if (val === 'EN_PROCESO') apoyoSelect.value = 'APOYO_MEDIO';
        if (val === 'LOGRADO') apoyoSelect.value = 'APOYO_BAJO';
    }

    function setAllNivel(nivel, apoyo) {
        document.querySelectorAll('.select-nivel').forEach(sel => {
            sel.value = nivel;
            sel.dispatchEvent(new Event('change'));
        });
        document.querySelectorAll('.select-apoyo').forEach(sel => {
            sel.value = apoyo;
        });
    }

    function checkAllEvidencias(estado) {
        document.querySelectorAll('.chk-evidencia').forEach(chk => {
            chk.checked = estado;
        });
    }
</script>
@endpush
