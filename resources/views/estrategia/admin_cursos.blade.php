@extends('layouts.admin')

@section('title', 'Gestión de Cursos — Panel de Administración')
@section('page_title', 'Gestión de Cursos (Crear, Ver, Editar y Eliminar)')
@section('page_subtitle', 'Visualiza todos tus cursos a pantalla completa y usa los botones para crear o editar cursos mediante ventanas emergentes (Modales)')

@section('content')

<!-- 1. TABLA PRINCIPAL A PANTALLA COMPLETA DE CURSOS -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-4 bg-slate-900 text-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h3 class="text-sm font-extrabold uppercase tracking-wide text-amber-400">
                🏫 Listado General de Cursos Registrados ({{ $cursos->count() }})
            </h3>
            <p class="text-xs text-slate-300">
                Selecciona "Ver" para inspeccionar los estudiantes del curso, "Editar" para abrir el modal de edición o "Eliminar".
            </p>
        </div>
        <button type="button" onclick="abrirModal('modalCrearCurso')"
                class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold px-4 py-2 rounded-lg text-xs shadow flex items-center gap-1.5 shrink-0 transition">
            <span>➕</span>
            <span>Crear Nuevo Curso</span>
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="bg-slate-100 text-slate-700 uppercase text-[11px] border-b border-slate-200">
                    <th class="py-3 px-3 text-center w-12">ID</th>
                    <th class="py-3 px-4">Curso / Año de Escolaridad</th>
                    <th class="py-3 px-2 text-center">Paralelo</th>
                    <th class="py-3 px-3">Área y Capacidad</th>
                    <th class="py-3 px-3">Unidad Educativa / Docente</th>
                    <th class="py-3 px-2 text-center">Estudiantes</th>
                    <th class="py-3 px-2 text-center">Actividades</th>
                    <th class="py-3 px-4 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($cursos as $c)
                    <tr class="hover:bg-amber-50/40 transition {{ isset($cursoDetalle) && $cursoDetalle && $cursoDetalle->id === $c->id ? 'bg-amber-50' : '' }}">
                        <td class="py-3 px-3 text-center font-bold text-slate-500">#{{ $c->id }}</td>
                        <td class="py-3 px-4 font-extrabold text-slate-900 text-sm">
                            🎓 {{ $c->nombre }}
                            <span class="block text-[11px] font-normal text-slate-500">{{ $c->trimestre }}</span>
                        </td>
                        <td class="py-3 px-2 text-center">
                            <span class="inline-block bg-slate-900 text-amber-400 font-black px-2.5 py-1 rounded text-xs">
                                "{{ $c->paralelo }}"
                            </span>
                        </td>
                        <td class="py-3 px-3">
                            <span class="font-bold text-slate-800 block">{{ $c->area }}</span>
                            <span class="text-[11px] text-amber-700 font-semibold">{{ $c->capacidad }}</span>
                        </td>
                        <td class="py-3 px-3">
                            <span class="font-semibold text-slate-800 block">{{ $c->unidad_educativa }}</span>
                            <span class="text-[11px] text-slate-500">Docente: {{ $c->docente }}</span>
                        </td>
                        <td class="py-3 px-2 text-center">
                            <a href="{{ route('estrategia.admin.estudiantes', ['curso_id' => $c->id]) }}"
                               class="inline-block bg-blue-100 text-blue-800 font-bold px-2.5 py-1 rounded hover:bg-blue-200">
                                👨‍🎓 {{ $c->estudiantes_count }} alumnos
                            </a>
                        </td>
                        <td class="py-3 px-2 text-center">
                            <a href="{{ route('estrategia.admin.actividades', ['curso_id' => $c->id]) }}"
                               class="inline-block bg-emerald-100 text-emerald-800 font-bold px-2.5 py-1 rounded hover:bg-emerald-200">
                                📅 {{ $c->actividades_count }} sem.
                            </a>
                        </td>
                        <td class="py-3 px-4 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('estrategia.admin.cursos', ['ver_curso_id' => $c->id]) }}"
                                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-2.5 py-1.5 rounded text-[11px] shadow-sm transition">
                                    👁️ Ver
                                </a>
                                <button type="button"
                                        onclick="abrirModalEditarCurso({{ $c->id }}, @js($c->nombre), @js($c->paralelo), @js($c->area), @js($c->capacidad), @js($c->unidad_educativa), @js($c->distrito), @js($c->docente), @js($c->director), @js($c->trimestre), @js($c->diagnostico_curso ?? ''))"
                                        class="bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold px-2.5 py-1.5 rounded text-[11px] shadow-sm transition">
                                    ✏️ Editar
                                </button>
                                <a href="{{ route('estrategia.pdf.curso', $c->id) }}"
                                   class="bg-slate-800 hover:bg-slate-700 text-white font-bold px-2.5 py-1.5 rounded text-[11px] shadow-sm transition"
                                   title="Descargar Informe General PDF">
                                    📊 PDF
                                </a>
                                <form action="{{ route('estrategia.curso.eliminar', $c->id) }}" method="POST"
                                      onsubmit="return confirm('¿Estás seguro de eliminar el curso {{ $c->nombre }} {{ $c->paralelo }} y todos sus registros?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white font-bold px-2.5 py-1.5 rounded text-[11px] shadow-sm transition">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-8 text-center text-slate-500">
                            No hay cursos registrados. Haz clic en el botón superior <strong>"➕ Crear Nuevo Curso"</strong>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- 2. VISTA DETALLADA A PANTALLA COMPLETA DEL CURSO SELECCIONADO (BOTÓN "VER") -->
@php $cursoMostrar = $cursoDetalle ?? $cursos->first(); @endphp
@if($cursoMostrar)
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="bg-slate-800 text-white px-5 py-3.5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <span class="text-[10px] font-bold uppercase text-amber-400 block">Detalle del Curso Seleccionado</span>
                <h3 class="text-base font-extrabold">
                    👁️ {{ $cursoMostrar->nombre }} — Paralelo "{{ $cursoMostrar->paralelo }}" ({{ $cursoMostrar->estudiantes->count() }} Estudiantes)
                </h3>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('estrategia.admin.estudiantes', ['curso_id' => $cursoMostrar->id]) }}"
                   class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-3.5 py-1.5 rounded-lg text-xs shadow">
                    👨‍🎓 Gestionar / Agregar Estudiantes de este Curso →
                </a>
            </div>
        </div>

        <div class="p-5 space-y-4 text-xs">
            <div class="bg-slate-50 p-3.5 rounded-lg border border-slate-200">
                <p class="font-bold text-slate-700 mb-1">Diagnóstico General del Curso:</p>
                <p class="text-slate-600">{{ $cursoMostrar->diagnostico_curso }}</p>
            </div>

            <div class="overflow-x-auto border border-slate-200 rounded-lg">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-100 text-slate-700 border-b">
                            <th class="py-2.5 px-3 w-12 text-center">#</th>
                            <th class="py-2.5 px-4">Apellidos y Nombres del Estudiante</th>
                            <th class="py-2.5 px-3 text-center">RUDE</th>
                            <th class="py-2.5 px-3 text-center">Diagnóstico Inicial</th>
                            <th class="py-2.5 px-3 text-center">Acción Rápida</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($cursoMostrar->estudiantes as $idx => $est)
                            <tr class="hover:bg-slate-50">
                                <td class="py-2 px-3 text-center font-bold text-slate-400">{{ $idx + 1 }}</td>
                                <td class="py-2 px-4 font-bold text-slate-900">{{ $est->nombres_apellidos }}</td>
                                <td class="py-2 px-3 text-center font-mono text-slate-500">{{ $est->rude ?: '—' }}</td>
                                <td class="py-2 px-3 text-center">
                                    <span class="px-2 py-0.5 rounded bg-slate-100 font-semibold text-[10px]">{{ $est->diagnostico_inicial }}</span>
                                </td>
                                <td class="py-2 px-3 text-center">
                                    <a href="{{ route('estrategia.pdf.estudiante.individual', $est->id) }}"
                                       class="text-emerald-700 hover:underline font-bold">📄 Descargar PDF Individual</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-slate-400">
                                    Sin estudiantes registrados aún en este curso.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

<!-- ==================== MODAL 1: CREAR NUEVO CURSO ==================== -->
<div id="modalCrearCurso" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 max-w-xl w-full overflow-hidden">
        <div class="bg-slate-900 text-white px-5 py-4 flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase text-amber-400 block">Nuevo Registro</span>
                <h3 class="text-base font-extrabold">➕ Crear Nuevo Curso / Paralelo</h3>
            </div>
            <button type="button" onclick="cerrarModal('modalCrearCurso')" class="text-slate-400 hover:text-white text-lg font-bold">✕</button>
        </div>

        <form action="{{ route('estrategia.curso.crear') }}" method="POST" class="p-5 space-y-3 text-xs">
            @csrf
            <div class="grid grid-cols-3 gap-3">
                <div class="col-span-2">
                    <label class="block font-bold text-slate-700 mb-1">Curso / Año de Escolaridad *</label>
                    <input type="text" name="nombre" placeholder="Ej: 4.º de Secundaria" required class="w-full border border-slate-300 rounded-lg px-3 py-2 font-bold">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Paralelo *</label>
                    <input type="text" name="paralelo" value="A" required class="w-full border border-slate-300 rounded-lg px-3 py-2 font-bold">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Área de Saberes</label>
                    <input type="text" name="area" value="Técnica Tecnológica Especializada: Sistemas Informáticos" required class="w-full border border-slate-300 rounded-lg px-3 py-1.5">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Capacidad Fundamental</label>
                    <input type="text" name="capacidad" value="Pensamiento Lógico - Matemático" required class="w-full border border-slate-300 rounded-lg px-3 py-1.5">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Unidad Educativa</label>
                    <input type="text" name="unidad_educativa" value="{{ $cursos->first()?->unidad_educativa ?? 'Unidad Educativa' }}" required class="w-full border border-slate-300 rounded-lg px-3 py-1.5">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Dirección Distrital</label>
                    <input type="text" name="distrito" value="{{ $cursos->first()?->distrito ?? 'Dirección Distrital de Educación de Mineros (7036)' }}" required class="w-full border border-slate-300 rounded-lg px-3 py-1.5">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Docente</label>
                    <input type="text" name="docente" value="{{ $cursos->first()?->docente ?? 'Prof. de Sistemas Informáticos' }}" required class="w-full border border-slate-300 rounded-lg px-3 py-1.5">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Director/a</label>
                    <input type="text" name="director" value="{{ $cursos->first()?->director ?? 'Lic. Director/a de U.E.' }}" required class="w-full border border-slate-300 rounded-lg px-3 py-1.5">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Trimestre / Gestión</label>
                    <input type="text" name="trimestre" value="Tercer Trimestre - Gestión 2026" required class="w-full border border-slate-300 rounded-lg px-3 py-1.5">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Diagnóstico Inicial del Curso</label>
                <textarea name="diagnostico_curso" rows="2" class="w-full border border-slate-300 rounded-lg px-3 py-1.5">En el diagnóstico inicial aplicado al curso en el área de Sistemas Informáticos, se identificó rezago en el planteamiento matemático y verificación de resultados, implementándose 4 sesiones semanales con andamiaje progresivo.</textarea>
            </div>

            <label class="flex items-center gap-2 text-xs font-semibold text-slate-800 cursor-pointer pt-1">
                <input type="checkbox" name="clonar_actividades_base" value="1" checked class="rounded text-amber-600">
                <span>Crear actividades iniciales y sus 6 tipos de evidencia</span>
            </label>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="cerrarModal('modalCrearCurso')" class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 font-bold">
                    Cancelar
                </button>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold px-5 py-2 rounded-lg shadow">
                    💾 Crear Curso
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ==================== MODAL 2: EDITAR CURSO ==================== -->
<div id="modalEditarCurso" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 max-w-xl w-full overflow-hidden">
        <div class="bg-amber-500 text-slate-950 px-5 py-4 flex items-center justify-between">
            <div>
                <span class="text-[10px] font-black uppercase block">Modificar Curso</span>
                <h3 class="text-base font-extrabold" id="tituloModalEditarCurso">✏️ Editar Curso</h3>
            </div>
            <button type="button" onclick="cerrarModal('modalEditarCurso')" class="text-slate-900 hover:text-black text-lg font-bold">✕</button>
        </div>

        <form id="formEditarCurso" method="POST" class="p-5 space-y-3 text-xs">
            @csrf
            <input type="hidden" name="redirect_to" value="admin_cursos">
            <div class="grid grid-cols-3 gap-3">
                <div class="col-span-2">
                    <label class="block font-bold text-slate-700 mb-1">Curso / Año de Escolaridad *</label>
                    <input type="text" name="nombre" id="ec_nombre" required class="w-full border border-slate-300 rounded-lg px-3 py-2 font-bold">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Paralelo *</label>
                    <input type="text" name="paralelo" id="ec_paralelo" required class="w-full border border-slate-300 rounded-lg px-3 py-2 font-bold">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Área de Saberes</label>
                    <input type="text" name="area" id="ec_area" required class="w-full border border-slate-300 rounded-lg px-3 py-1.5">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Capacidad Fundamental</label>
                    <input type="text" name="capacidad" id="ec_capacidad" required class="w-full border border-slate-300 rounded-lg px-3 py-1.5">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Unidad Educativa</label>
                    <input type="text" name="unidad_educativa" id="ec_ue" required class="w-full border border-slate-300 rounded-lg px-3 py-1.5">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Dirección Distrital</label>
                    <input type="text" name="distrito" id="ec_distrito" required class="w-full border border-slate-300 rounded-lg px-3 py-1.5">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Docente</label>
                    <input type="text" name="docente" id="ec_docente" required class="w-full border border-slate-300 rounded-lg px-3 py-1.5">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Director/a</label>
                    <input type="text" name="director" id="ec_director" required class="w-full border border-slate-300 rounded-lg px-3 py-1.5">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Trimestre / Gestión</label>
                    <input type="text" name="trimestre" id="ec_trimestre" required class="w-full border border-slate-300 rounded-lg px-3 py-1.5">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Diagnóstico General del Curso</label>
                <textarea name="diagnostico_curso" id="ec_diagnostico" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-1.5"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="cerrarModal('modalEditarCurso')" class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 font-bold">
                    Cancelar
                </button>
                <button type="submit" class="bg-slate-900 hover:bg-amber-500 hover:text-slate-950 text-white font-extrabold px-5 py-2 rounded-lg shadow transition">
                    💾 Guardar Cambios
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

    function abrirModalEditarCurso(id, nombre, paralelo, area, capacidad, ue, distrito, docente, director, trimestre, diagnostico) {
        const baseUrl = "{{ url('/cursos') }}";
        document.getElementById('formEditarCurso').action = baseUrl + '/' + id + '/actualizar';
        document.getElementById('tituloModalEditarCurso').textContent = '✏️ Editar: ' + nombre + ' "' + paralelo + '"';
        document.getElementById('ec_nombre').value = nombre;
        document.getElementById('ec_paralelo').value = paralelo;
        document.getElementById('ec_area').value = area;
        document.getElementById('ec_capacidad').value = capacidad;
        document.getElementById('ec_ue').value = ue;
        document.getElementById('ec_distrito').value = distrito;
        document.getElementById('ec_docente').value = docente;
        document.getElementById('ec_director').value = director;
        document.getElementById('ec_trimestre').value = trimestre;
        document.getElementById('ec_diagnostico').value = diagnostico;
        abrirModal('modalEditarCurso');
    }
</script>
@endpush
