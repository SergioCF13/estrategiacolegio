@extends('layouts.admin')

@section('title', 'Actividades y Evidencias Multimedia — Panel de Administración')
@section('page_title', 'Gestión de Actividades y Evidencias Multimedia (Texto, Imágenes y Videos)')
@section('page_subtitle', 'Configura los textos de las 6 evidencias y adjunta fotografías o videos reales de tus clases en ' . ($cursoActivo?->nombre ?? ''))

@section('content')
@if($cursoActivo)
    <nav class="bg-white rounded-xl border border-slate-200 shadow-sm p-3" aria-label="Seleccionar mes y actividad">
        <form method="GET" action="{{ route('estrategia.admin.actividades') }}" class="flex flex-wrap items-end gap-3 mb-3">
            <input type="hidden" name="curso_id" value="{{ $cursoActivo->id }}">
            <label class="text-xs font-bold text-slate-600">
                Mes
                <select name="mes" class="block mt-1 rounded-lg border-slate-300 text-xs">
                    @foreach(range(1, 12) as $numeroMes)
                        <option value="{{ $numeroMes }}" @selected($mes === $numeroMes)>{{ \Carbon\Carbon::createFromDate($anio, $numeroMes, 1)->locale('es')->translatedFormat('F') }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-xs font-bold text-slate-600">
                Año
                <input type="number" name="anio" min="2020" max="2100" value="{{ $anio }}" class="block mt-1 w-24 rounded-lg border-slate-300 text-xs">
            </label>
            <button class="rounded-lg bg-slate-900 px-4 py-2 text-xs font-bold text-white">Ver mes</button>
        </form>
        <p class="text-xs font-extrabold uppercase text-slate-600 mb-2">Actividades de {{ \Carbon\Carbon::createFromDate($anio, $mes, 1)->locale('es')->translatedFormat('F Y') }}:</p>
        <div class="flex flex-wrap gap-2">
            @for($numeroSemana = 1; $numeroSemana <= 4; $numeroSemana++)
                <a href="{{ route('estrategia.admin.actividades', ['curso_id' => $cursoActivo->id, 'mes' => $mes, 'anio' => $anio, 'actividad' => $numeroSemana]) }}"
                   @if($semanaActiva === $numeroSemana) aria-current="page" @endif
                   class="rounded-lg px-4 py-2 text-xs font-extrabold transition {{ $semanaActiva === $numeroSemana ? 'bg-amber-500 text-slate-950 shadow' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    📅 Actividad {{ $numeroSemana }}
                </a>
            @endfor
        </div>
    </nav>
    <div class="space-y-6">
        @foreach($actividades as $act)
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <!-- Cabecera de la actividad mensual -->
                <div class="bg-slate-900 text-white px-5 py-3.5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div class="flex items-center gap-2.5">
                        <span class="bg-amber-500 text-slate-950 font-black text-xs px-2.5 py-1 rounded">
                            {{ $act->nombreMes() }} {{ $act->anio }} • ACTIVIDAD {{ $act->numero_semana }}
                        </span>
                        <h3 class="font-bold text-sm md:text-base">{{ $act->titulo }}</h3>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button"
                                onclick="abrirModalSubirEvidencia({{ $act->id }}, {{ $act->numero_semana }}, @js($act->titulo))"
                                class="bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold px-3.5 py-1.5 rounded-lg text-xs shadow flex items-center gap-1.5">
                            <span>📸🎥</span>
                            <span>Subir Imagen o Video (Actividad {{ $act->numero_semana }})</span>
                        </button>
                        <a href="{{ route('estrategia.evaluar', ['curso' => $cursoActivo->id, 'semana' => $act->numero_semana, 'mes' => $mes, 'anio' => $anio]) }}"
                           class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-3 py-1.5 rounded-lg text-xs shrink-0">
                            ✅ Calificar Actividad {{ $act->numero_semana }} →
                        </a>
                    </div>
                </div>

                <!-- 1. GALERÍA MULTIMEDIA DE IMÁGENES Y VIDEOS DE ESTA ACTIVIDAD -->
                <div class="p-4 bg-slate-50 border-b border-slate-200">
                    <div class="flex items-center justify-between mb-2.5">
                        <h4 class="text-xs font-extrabold uppercase text-slate-800 flex items-center gap-1.5">
                            <span>🖼️🎬</span>
                            <span>Archivos Multimedia ({{ $act->archivosEvidencia->count() }} archivos)</span>
                        </h4>
                        <button type="button"
                                onclick="abrirModalSubirEvidencia({{ $act->id }}, {{ $act->numero_semana }}, @js($act->titulo))"
                                class="text-xs font-bold text-emerald-700 hover:underline">
                            + Agregar más fotos o videos a esta actividad
                        </button>
                    </div>

                    <div class="space-y-3">
                        @for($numeroEvidencia = 1; $numeroEvidencia <= 6; $numeroEvidencia++)
                            @php
                                $archivosDeEvidencia = $act->archivosEvidencia->where('numero_evidencia', $numeroEvidencia);
                                $detalleEvidencia = $act->{'ev_' . $numeroEvidencia . '_detalle'};
                            @endphp
                            <section class="bg-white border border-slate-200 rounded-xl p-3">
                                <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                    <h5 class="text-xs font-extrabold text-slate-800">
                                        Evidencia #{{ $numeroEvidencia }}: {{ $detalleEvidencia }}
                                        <span class="text-slate-500 font-semibold">({{ $archivosDeEvidencia->count() }} archivos)</span>
                                    </h5>
                                    <button type="button"
                                            onclick="abrirModalSubirEvidencia({{ $act->id }}, {{ $act->numero_semana }}, @js($act->titulo), {{ $numeroEvidencia }})"
                                            class="text-[11px] font-bold text-emerald-700 hover:underline">
                                        + Adjuntar a esta evidencia
                                    </button>
                                </div>

                                @if($archivosDeEvidencia->isNotEmpty())
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                        @foreach($archivosDeEvidencia as $arch)
                                            <div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden flex flex-col justify-between">
                                                <div>
                                                    @if($arch->tipo_archivo === 'IMAGEN')
                                                        <div class="h-36 bg-slate-100 relative overflow-hidden group cursor-pointer"
                                                             onclick="verImagenGrande('{{ asset($arch->ruta_archivo) }}', @js($arch->titulo))">
                                                            <img src="{{ asset($arch->ruta_archivo) }}" alt="{{ $arch->titulo }}"
                                                                 class="w-full h-full object-cover group-hover:scale-105 transition">
                                                            <span class="absolute top-2 left-2 bg-slate-900/80 text-amber-400 text-[10px] font-bold px-2 py-0.5 rounded">
                                                                📷 Evidencia #{{ $arch->numero_evidencia }}
                                                            </span>
                                                        </div>
                                                    @else
                                                        <div class="h-36 bg-slate-950 relative flex items-center justify-center">
                                                            @if(str_starts_with($arch->ruta_archivo, 'http'))
                                                                <div class="text-center p-3">
                                                                    <span class="text-3xl block mb-1">🎬</span>
                                                                    <a href="{{ $arch->ruta_archivo }}" target="_blank"
                                                                       class="bg-amber-500 text-slate-950 font-bold px-3 py-1 rounded text-[11px] inline-block">
                                                                        ▶️ Abrir Video Externo
                                                                    </a>
                                                                </div>
                                                            @else
                                                                <video controls class="w-full h-full object-contain">
                                                                    <source src="{{ asset($arch->ruta_archivo) }}" type="{{ $arch->mime_type ?: 'video/mp4' }}">
                                                                </video>
                                                            @endif
                                                            <span class="absolute top-2 left-2 bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded pointer-events-none">
                                                                🎥 Video Ev. #{{ $arch->numero_evidencia }}
                                                            </span>
                                                        </div>
                                                    @endif

                                                    <div class="p-2.5 text-xs">
                                                        <p class="font-bold text-slate-900 truncate" title="{{ $arch->titulo }}">
                                                            {{ $arch->titulo ?: 'Evidencia de clase' }}
                                                        </p>
                                                        <p class="text-[10px] text-slate-500 mt-0.5">
                                                            {{ $arch->estudiante ? '👤 ' . $arch->estudiante->nombres_apellidos : '👥 Evidencia General del Curso' }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="px-2.5 py-1.5 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-[11px]">
                                                    @if($arch->tipo_archivo === 'IMAGEN')
                                                        <button type="button" onclick="verImagenGrande('{{ asset($arch->ruta_archivo) }}', @js($arch->titulo))"
                                                                class="text-blue-600 hover:underline font-semibold">
                                                            🔍 Ampliar
                                                        </button>
                                                    @else
                                                        <a href="{{ str_starts_with($arch->ruta_archivo, 'http') ? $arch->ruta_archivo : asset($arch->ruta_archivo) }}"
                                                           target="_blank" class="text-blue-600 hover:underline font-semibold">
                                                            ▶️ Ver video
                                                        </a>
                                                    @endif

                                                    <form action="{{ route('estrategia.evidencia.eliminar', $arch->id) }}" method="POST"
                                                          onsubmit="return confirm('¿Eliminar este archivo multimedia?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800 font-bold">🗑️ Eliminar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-[11px] text-slate-500">Aún no hay imágenes ni videos asociados a esta evidencia.</p>
                                @endif
                            </section>
                        @endfor
                    </div>
                </div>

                <!-- 2. FORMULARIO DE TEXTOS DE LA ACTIVIDAD Y DESCRIPCIÓN DE LAS 6 EVIDENCIAS -->
                <form action="{{ route('estrategia.actividad.guardar', $act->id) }}" method="POST" class="p-5 space-y-4 text-xs">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                        <div class="md:col-span-2">
                            <label class="block font-bold text-slate-700 mb-1">Título de la Actividad</label>
                            <input type="text" name="titulo" value="{{ $act->titulo }}" required class="w-full border border-slate-300 rounded-lg px-3 py-1.5 font-semibold">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Fecha de Aplicación</label>
                            <input type="date" name="fecha_aplicacion" value="{{ optional($act->fecha_aplicacion)->format('Y-m-d') }}" class="w-full border border-slate-300 rounded-lg px-3 py-1.5">
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Minutos</label>
                                <input type="number" name="tiempo_minutos" value="{{ $act->tiempo_minutos }}" class="w-full border border-slate-300 rounded-lg px-2.5 py-1.5">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Estado</label>
                                <select name="estado" class="w-full border border-slate-300 rounded-lg px-2 py-1.5 font-bold">
                                    <option value="EJECUTADA" {{ $act->estado === 'EJECUTADA' ? 'selected' : '' }}>EJECUTADA</option>
                                    <option value="PLANIFICADA" {{ $act->estado === 'PLANIFICADA' ? 'selected' : '' }}>PLANIFICADA</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Orientación Didáctica</label>
                            <textarea name="orientacion_didactica" rows="2" class="w-full border border-slate-300 rounded-lg px-2.5 py-1.5">{{ $act->orientacion_didactica }}</textarea>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Habilidades que Fortalece</label>
                            <textarea name="habilidades" rows="2" class="w-full border border-slate-300 rounded-lg px-2.5 py-1.5">{{ $act->habilidades }}</textarea>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Planteamiento / Caso Técnico</label>
                            <textarea name="planteamiento" rows="2" class="w-full border border-slate-300 rounded-lg px-2.5 py-1.5">{{ $act->planteamiento }}</textarea>
                        </div>
                    </div>

                    <div class="bg-amber-50/70 border border-amber-200 rounded-xl p-3.5">
                        <h4 class="font-extrabold text-amber-950 uppercase text-xs mb-2.5">
                            📂 Descripción Escrita de los 6 Tipos de Evidencia (Sección 5.3)
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">1. Interpretación de Textos y Datos</label>
                                <input type="text" name="ev_1_detalle" value="{{ $act->ev_1_detalle }}" required class="w-full border border-slate-300 bg-white rounded px-2.5 py-1.5">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">2. Resolución de Problemas</label>
                                <input type="text" name="ev_2_detalle" value="{{ $act->ev_2_detalle }}" required class="w-full border border-slate-300 bg-white rounded px-2.5 py-1.5">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">3. Registros de Indagación / Verificación</label>
                                <input type="text" name="ev_3_detalle" value="{{ $act->ev_3_detalle }}" required class="w-full border border-slate-300 bg-white rounded px-2.5 py-1.5">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">4. Producciones Escritas</label>
                                <input type="text" name="ev_4_detalle" value="{{ $act->ev_4_detalle }}" required class="w-full border border-slate-300 bg-white rounded px-2.5 py-1.5">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">5. Exposiciones y Argumentaciones</label>
                                <input type="text" name="ev_5_detalle" value="{{ $act->ev_5_detalle }}" required class="w-full border border-slate-300 bg-white rounded px-2.5 py-1.5">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">6. Informes, Proyectos y Valoración</label>
                                <input type="text" name="ev_6_detalle" value="{{ $act->ev_6_detalle }}" required class="w-full border border-slate-300 bg-white rounded px-2.5 py-1.5">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Solucionario para el Docente</label>
                            <textarea name="solucionario_docente" rows="2" class="w-full border border-slate-300 rounded-lg px-2.5 py-1.5">{{ $act->solucionario_docente }}</textarea>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Logros Cualitativos de la Sesión</label>
                            <textarea name="logros_sesion" rows="2" class="w-full border border-slate-300 rounded-lg px-2.5 py-1.5">{{ $act->logros_sesion }}</textarea>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Dificultades Superadas y Mediación</label>
                            <textarea name="dificultades_sesion" rows="2" class="w-full border border-slate-300 rounded-lg px-2.5 py-1.5">{{ $act->dificultades_sesion }}</textarea>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="bg-slate-900 hover:bg-emerald-600 text-white font-bold px-5 py-2 rounded-lg shadow transition">
                            💾 Guardar Actividad {{ $act->numero_semana }}
                        </button>
                    </div>
                </form>
            </div>
        @endforeach
    </div>

    <!-- ==================== MODAL PARA SUBIR IMÁGENES O VIDEOS DE EVIDENCIA ==================== -->
    <div id="modalSubirEvidencia" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 max-w-lg w-full overflow-hidden">
            <div class="bg-slate-900 text-white px-5 py-4 flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold uppercase text-emerald-400 block" id="subtituloModalEvidencia">Adjuntar Evidencia Multimedia</span>
                    <h3 class="text-base font-extrabold">📸🎥 Subir Imágenes o Videos de Evidencia</h3>
                </div>
                <button type="button" onclick="cerrarModal('modalSubirEvidencia')" class="text-slate-400 hover:text-white text-lg font-bold">✕</button>
            </div>

            <form id="formSubirEvidencia" method="POST" enctype="multipart/form-data" class="p-5 space-y-3.5 text-xs">
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
                    <label class="block font-bold text-slate-700 mb-1">2. ¿Es Evidencia General del Curso o de un Estudiante específico?</label>
                    <select name="estudiante_id" class="w-full border border-slate-300 rounded-lg px-3 py-2 font-semibold">
                        <option value="">👥 Evidencia General de toda la Clase ({{ $cursoActivo->nombre }})</option>
                        @foreach($cursoActivo->estudiantes as $est)
                            <option value="{{ $est->id }}">👤 {{ $est->nombres_apellidos }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">3. Título o Descripción de la Evidencia</label>
                    <input type="text" name="titulo" placeholder="Ej: Fotografía de resolución en pizarra / Video de defensa oral"
                           class="w-full border border-slate-300 rounded-lg px-3 py-2">
                </div>

                <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 space-y-2">
                    <label class="block font-extrabold text-emerald-950">
                        4. Seleccionar Fotos (.jpg, .png, .webp) o Videos (.mp4, .webm, .mov) desde tu PC:
                    </label>
                    <input type="file" name="archivos[]" multiple accept="image/*,video/*"
                           class="w-full text-xs text-slate-700 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700">
                    <p class="text-[10px] text-emerald-800">
                        💡 Puedes seleccionar varias fotos y videos al mismo tiempo. Las fotos se incrustan automáticamente en el Informe PDF.
                    </p>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Opcional: Pegar enlace externo de Video (YouTube, Google Drive, TikTok)</label>
                    <input type="url" name="url_externa" placeholder="https://drive.google.com/... o https://www.youtube.com/..."
                           class="w-full border border-slate-300 rounded-lg px-3 py-1.5">
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" onclick="cerrarModal('modalSubirEvidencia')"
                            class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 font-bold">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold px-5 py-2 rounded-lg shadow">
                        ⬆️ Subir y Guardar Evidencia
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== MODAL VISOR DE IMAGEN EN GRANDE ==================== -->
    <div id="modalVisorImagen" class="fixed inset-0 bg-slate-950/80 z-50 hidden items-center justify-center p-4" onclick="cerrarModal('modalVisorImagen')">
        <div class="max-w-3xl w-full bg-white rounded-2xl overflow-hidden shadow-2xl" onclick="event.stopPropagation()">
            <div class="bg-slate-900 text-white px-4 py-3 flex items-center justify-between">
                <h4 class="text-xs font-bold" id="tituloVisorImagen">Vista previa de evidencia</h4>
                <button type="button" onclick="cerrarModal('modalVisorImagen')" class="text-slate-400 hover:text-white font-bold">✕</button>
            </div>
            <div class="p-4 bg-slate-950 flex items-center justify-center max-h-[75vh]">
                <img id="imgVisorGrande" src="" alt="Evidencia" class="max-h-[70vh] w-auto object-contain rounded">
            </div>
        </div>
    </div>
@endif
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

    function abrirModalSubirEvidencia(actividadId, numSemana, tituloAct, numeroEvidencia = '') {
        const baseUrl = "{{ url('/admin/actividades') }}";
        document.getElementById('formSubirEvidencia').action = baseUrl + '/' + actividadId + '/subir-evidencia';
        document.getElementById('subtituloModalEvidencia').textContent = 'Actividad ' + numSemana + ': ' + tituloAct;
        document.querySelector('#formSubirEvidencia [name="numero_evidencia"]').value = numeroEvidencia;
        abrirModal('modalSubirEvidencia');
    }

    function verImagenGrande(url, titulo) {
        document.getElementById('imgVisorGrande').src = url;
        document.getElementById('tituloVisorImagen').textContent = titulo || 'Evidencia Fotográfica';
        abrirModal('modalVisorImagen');
    }
</script>
@endpush
