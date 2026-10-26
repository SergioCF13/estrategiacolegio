@extends('layouts.admin')

@section('title', 'Gestión de Estudiantes — Panel de Administración')
@section('page_title', 'Gestión de Estudiantes y Asignación de Curso')
@section('page_subtitle', 'Visualiza la nómina a pantalla completa y usa los botones superiores para registrar, importar o editar mediante ventanas emergentes (Modales)')

@section('content')

<!-- BARRA SUPERIOR: FILTRO POR CURSO + BUSCADOR + BOTONES QUE ABREN MODALES -->
<div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
    <!-- Filtros por Curso -->
    <div class="flex items-center gap-2 flex-wrap">
        <span class="text-xs font-extrabold uppercase text-slate-500">Filtrar:</span>
        <a href="{{ route('estrategia.admin.estudiantes', ['curso_id' => 'todos']) }}"
           class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ $filtroCursoId === 'todos' || !$filtroCursoId ? 'bg-slate-900 text-amber-400 shadow' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
            📋 Todos ({{ $cursos->sum('estudiantes_count') }})
        </a>
        @foreach($cursos as $c)
            <a href="{{ route('estrategia.admin.estudiantes', ['curso_id' => $c->id]) }}"
               class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ (int) $filtroCursoId === $c->id ? 'bg-amber-500 text-slate-950 shadow' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                🎓 {{ $c->nombre }} "{{ $c->paralelo }}" ({{ $c->estudiantes_count }})
            </a>
        @endforeach
    </div>

    <!-- Buscador + Botones de Modal -->
    <div class="flex flex-wrap items-center gap-2.5">
        <input type="text" id="buscadorEstudiantes" onkeyup="filtrarTablaEstudiantes()"
               placeholder="🔍 Buscar estudiante o RUDE..."
               class="border border-slate-300 rounded-lg px-3 py-1.5 text-xs w-56 focus:ring-2 focus:ring-amber-500 focus:outline-none">

        <button type="button" onclick="abrirModal('modalCrearEstudiante')"
                class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold px-3.5 py-2 rounded-lg text-xs shadow flex items-center gap-1.5 transition">
            <span>➕</span>
            <span>Registrar Estudiante</span>
        </button>

        <button type="button" onclick="abrirModal('modalImportarLote')"
                class="bg-slate-900 hover:bg-slate-800 text-amber-400 font-extrabold px-3.5 py-2 rounded-lg text-xs shadow flex items-center gap-1.5 transition">
            <span>⚡</span>
            <span>Importar por Lote</span>
        </button>
    </div>
</div>

<!-- TABLA A PANTALLA COMPLETA (100% ANCHO) DE ESTUDIANTES -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-4 bg-slate-900 text-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div>
            <h3 class="text-sm font-extrabold uppercase text-amber-400">
                👨‍🎓 Nómina General de Estudiantes Registrados ({{ $estudiantesListado->count() }})
            </h3>
            <p class="text-xs text-slate-300">
                Haz clic en "Editar" para abrir el modal de edición del estudiante o "PDF" para descargar su informe individual.
            </p>
        </div>
        @if($cursoActivo)
            <a href="{{ route('estrategia.pdf.estudiantes', $cursoActivo->id) }}"
               class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold px-3.5 py-1.5 rounded-lg text-xs shadow shrink-0">
                📑 Descargar PDF de Todos ({{ $cursoActivo->nombre }})
            </a>
        @endif
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs" id="tablaEstudiantesCrud">
            <thead>
                <tr class="bg-slate-100 text-slate-700 uppercase text-[11px] border-b border-slate-200">
                    <th class="py-3 px-3 text-center w-12">N.º</th>
                    <th class="py-3 px-4">Apellidos y Nombres del Estudiante</th>
                    <th class="py-3 px-3 text-center">RUDE / C.I.</th>
                    <th class="py-3 px-3 text-center">Curso que Corresponde</th>
                    <th class="py-3 px-3 text-center">Diagnóstico Inicial</th>
                    <th class="py-3 px-3 text-center">Nivel Cierre (S4)</th>
                    <th class="py-3 px-3 text-center">6 Evidencias</th>
                    <th class="py-3 px-4 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($estudiantesListado as $idx => $est)
                    @php
                        $res = $est->ResumenProceso();
                        $badgeNivel = [
                            'INICIAL' => 'bg-red-100 text-red-800 border-red-300',
                            'EN_PROCESO' => 'bg-amber-100 text-amber-800 border-amber-300',
                            'LOGRADO' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                        ];
                    @endphp
                    <tr class="hover:bg-amber-50/30 transition fila-est-crud"
                        data-search="{{ strtolower($est->nombres_apellidos . ' ' . ($est->curso?->nombre ?? '') . ' ' . ($est->rude ?? '')) }}">
                        <td class="py-3 px-3 text-center font-bold text-slate-400">{{ $idx + 1 }}</td>
                        <td class="py-3 px-4">
                            <span class="font-bold text-slate-900 text-sm block">{{ $est->nombres_apellidos }}</span>
                            <span class="text-[11px] text-slate-500">
                                Dificultad: {{ \Illuminate\Support\Str::limit($est->dificultad_detectada, 75) }}
                            </span>
                        </td>
                        <td class="py-3 px-3 text-center font-mono text-slate-600">
                            {{ $est->rude ?: '—' }}
                        </td>
                        <td class="py-3 px-3 text-center">
                            <span class="inline-block bg-slate-800 text-amber-300 font-bold px-3 py-1 rounded-lg text-[11px]">
                                🎓 {{ $est->curso?->nombre }} "{{ $est->curso?->paralelo }}"
                            </span>
                        </td>
                        <td class="py-3 px-3 text-center">
                            <span class="inline-block px-2.5 py-0.5 rounded border text-[10px] font-bold {{ $badgeNivel[$est->diagnostico_inicial] ?? '' }}">
                                {{ $est->diagnostico_inicial }}
                            </span>
                        </td>
                        <td class="py-3 px-3 text-center">
                            <span class="inline-block px-2.5 py-0.5 rounded border text-[10px] font-bold {{ $badgeNivel[$res['nivel_final_raw']] ?? '' }}">
                                {{ $res['nivel_final'] }}
                            </span>
                        </td>
                        <td class="py-3 px-3 text-center font-bold text-slate-800">
                            {{ $res['total_cumplidas'] }}/{{ $res['total_posibles'] }}
                            <span class="block text-[10px] text-emerald-700">({{ $res['porcentaje_evidencias'] }}%)</span>
                        </td>
                        <td class="py-3 px-4 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-1.5">
                                <button type="button"
                                        onclick="abrirModalEditarEstudiante({{ $est->id }}, {{ $est->curso_id }}, @js($est->nombres_apellidos), @js($est->rude ?? ''), @js($est->diagnostico_inicial), @js($est->dificultad_detectada ?? ''))"
                                        class="bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold px-2.5 py-1.5 rounded text-[11px] shadow-sm transition">
                                    ✏️ Editar
                                </button>
                                <a href="{{ route('estrategia.pdf.estudiante.individual', $est->id) }}"
                                   class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-2.5 py-1.5 rounded text-[11px] shadow-sm transition"
                                   title="Descargar Informe Individual PDF">
                                    📄 PDF
                                </a>
                                <form action="{{ route('estrategia.estudiantes.eliminar', $est->id) }}" method="POST"
                                      onsubmit="return confirm('¿Eliminar al estudiante {{ $est->nombres_apellidos }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white font-bold px-2.5 py-1.5 rounded text-[11px] shadow-sm transition"
                                            title="Eliminar Estudiante">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-8 text-center text-slate-500">
                            No hay estudiantes registrados en este filtro. Haz clic en el botón superior <strong>"➕ Registrar Estudiante"</strong>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ==================== MODAL 1: REGISTRAR ESTUDIANTE INDIVIDUAL ==================== -->
<div id="modalCrearEstudiante" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 max-w-lg w-full overflow-hidden">
        <div class="bg-slate-900 text-white px-5 py-4 flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase text-amber-400 block">Registro Individual</span>
                <h3 class="text-base font-extrabold">➕ Registrar Nuevo Estudiante</h3>
            </div>
            <button type="button" onclick="cerrarModal('modalCrearEstudiante')" class="text-slate-400 hover:text-white text-lg font-bold">✕</button>
        </div>

        <form action="{{ route('estrategia.estudiantes.crear') }}" method="POST" class="p-5 space-y-3.5 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 mb-1">1. Curso que le Corresponde *</label>
                <select name="curso_id" required class="w-full border-2 border-amber-400 bg-amber-50/40 rounded-lg px-3 py-2 font-extrabold text-slate-900">
                    @foreach($cursos as $c)
                        <option value="{{ $c->id }}" {{ $cursoActivo && $cursoActivo->id === $c->id ? 'selected' : '' }}>
                            🎓 {{ $c->nombre }} — Paralelo "{{ $c->paralelo }}"
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">2. Apellidos y Nombres del Estudiante *</label>
                <input type="text" name="nombres_apellidos" placeholder="Ej: CONDORI MAMANI LUIS FERNANDO" required
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 font-semibold uppercase focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">3. Código RUDE / C.I. (Opcional)</label>
                    <input type="text" name="rude" placeholder="Ej: 81920099"
                           class="w-full border border-slate-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">4. Nivel Diagnóstico Inicial *</label>
                    <select name="diagnostico_inicial" class="w-full border border-slate-300 rounded-lg px-3 py-2 font-bold">
                        <option value="EN_PROCESO">2. EN PROCESO</option>
                        <option value="INICIAL">1. INICIAL</option>
                        <option value="LOGRADO">3. LOGRADO</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">5. Eslabón Específico de Dificultad (Para su Informe Individual)</label>
                <input type="text" name="dificultad_detectada"
                       value="Interpretación de datos en tablas, planteamiento algebraico y verificación de resultados"
                       class="w-full border border-slate-300 rounded-lg px-3 py-2">
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="cerrarModal('modalCrearEstudiante')"
                        class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 font-bold hover:bg-slate-50">
                    Cancelar
                </button>
                <button type="submit"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold px-5 py-2 rounded-lg shadow">
                    💾 Guardar Estudiante
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ==================== MODAL 2: EDITAR ESTUDIANTE Y SU CURSO ==================== -->
<div id="modalEditarEstudiante" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 max-w-lg w-full overflow-hidden">
        <div class="bg-amber-500 text-slate-950 px-5 py-4 flex items-center justify-between">
            <div>
                <span class="text-[10px] font-black uppercase block">Modificar Registro</span>
                <h3 class="text-base font-extrabold" id="tituloModalEditar">✏️ Editar Estudiante</h3>
            </div>
            <button type="button" onclick="cerrarModal('modalEditarEstudiante')" class="text-slate-900 hover:text-black text-lg font-bold">✕</button>
        </div>

        <form id="formEditarEstudiante" method="POST" class="p-5 space-y-3.5 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 mb-1">Curso que le Corresponde *</label>
                <select name="curso_id" id="edit_curso_id" required class="w-full border-2 border-amber-400 bg-amber-50/40 rounded-lg px-3 py-2 font-extrabold text-slate-900">
                    @foreach($cursos as $c)
                        <option value="{{ $c->id }}">🎓 {{ $c->nombre }} — Paralelo "{{ $c->paralelo }}"</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Apellidos y Nombres del Estudiante *</label>
                <input type="text" name="nombres_apellidos" id="edit_nombres" required
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 font-bold uppercase">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Código RUDE / C.I.</label>
                    <input type="text" name="rude" id="edit_rude"
                           class="w-full border border-slate-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Diagnóstico Inicial *</label>
                    <select name="diagnostico_inicial" id="edit_diagnostico" required class="w-full border border-slate-300 rounded-lg px-3 py-2 font-bold">
                        <option value="INICIAL">1. INICIAL</option>
                        <option value="EN_PROCESO">2. EN PROCESO</option>
                        <option value="LOGRADO">3. LOGRADO</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Eslabón Específico de Dificultad</label>
                <input type="text" name="dificultad_detectada" id="edit_dificultad"
                       class="w-full border border-slate-300 rounded-lg px-3 py-2">
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="cerrarModal('modalEditarEstudiante')"
                        class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 font-bold hover:bg-slate-50">
                    Cancelar
                </button>
                <button type="submit"
                        class="bg-slate-900 hover:bg-amber-500 hover:text-slate-950 text-white font-extrabold px-5 py-2 rounded-lg shadow transition">
                    💾 Actualizar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ==================== MODAL 3: IMPORTAR LISTA DE ESTUDIANTES POR LOTE ==================== -->
@if($cursos->isNotEmpty())
<div id="modalImportarLote" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 max-w-lg w-full overflow-hidden">
        <div class="bg-slate-900 text-white px-5 py-4 flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase text-amber-400 block">Carga Masiva Rápida</span>
                <h3 class="text-base font-extrabold">⚡ Importar Lista de Estudiantes por Lote</h3>
            </div>
            <button type="button" onclick="cerrarModal('modalImportarLote')" class="text-slate-400 hover:text-white text-lg font-bold">✕</button>
        </div>

        <form action="{{ route('estrategia.estudiantes.importar', $cursoActivo?->id ?? $cursos->first()->id) }}" method="POST" class="p-5 space-y-3.5 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 mb-1">1. Seleccionar Curso Destino *</label>
                <select name="curso_id_destino" required class="w-full border-2 border-amber-400 bg-amber-50/40 rounded-lg px-3 py-2 font-extrabold text-slate-900">
                    @foreach($cursos as $c)
                        <option value="{{ $c->id }}" {{ $cursoActivo && $cursoActivo->id === $c->id ? 'selected' : '' }}>
                            🎓 {{ $c->nombre }} — Paralelo "{{ $c->paralelo }}"
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">2. Pegar Lista de Apellidos y Nombres (1 por línea) *</label>
                <textarea name="lista_estudiantes" rows="6" required
                          placeholder="MAMANI QUISPE JUAN CARLOS&#10;FLORES CONDORI MARIA ELENA&#10;ROJAS VARGAS DIEGO ARMANDO"
                          class="w-full border border-slate-300 rounded-lg px-3 py-2 font-mono text-xs"></textarea>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">3. Nivel Diagnóstico Inicial Base</label>
                <select name="diagnostico_base" class="w-full border border-slate-300 rounded-lg px-3 py-2 font-semibold">
                    <option value="EN_PROCESO">Inician EN PROCESO → evolucionan a LOGRADO</option>
                    <option value="INICIAL">Inician en INICIAL → evolucionan a EN PROCESO / LOGRADO</option>
                    <option value="LOGRADO">Inician y mantienen LOGRADO</option>
                </select>
            </div>

            <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer pt-1">
                <input type="checkbox" name="reemplazar_existentes" value="1" class="rounded text-amber-600">
                <span>Reemplazar los estudiantes actuales de ese curso por esta nueva lista</span>
            </label>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="cerrarModal('modalImportarLote')"
                        class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 font-bold hover:bg-slate-50">
                    Cancelar
                </button>
                <button type="submit"
                        class="bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold px-5 py-2 rounded-lg shadow">
                    ⚡ Importar y Generar Informes
                </button>
            </div>
        </form>
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

    function abrirModalEditarEstudiante(id, cursoId, nombres, rude, diagnostico, dificultad) {
        const baseUrl = "{{ url('/admin/estudiantes') }}";
        document.getElementById('formEditarEstudiante').action = baseUrl + '/' + id + '/actualizar';
        document.getElementById('tituloModalEditar').textContent = '✏️ Editar: ' + nombres;
        document.getElementById('edit_curso_id').value = cursoId;
        document.getElementById('edit_nombres').value = nombres;
        document.getElementById('edit_rude').value = rude;
        document.getElementById('edit_diagnostico').value = diagnostico;
        document.getElementById('edit_dificultad').value = dificultad;
        abrirModal('modalEditarEstudiante');
    }

    function filtrarTablaEstudiantes() {
        const q = document.getElementById('buscadorEstudiantes').value.toLowerCase();
        document.querySelectorAll('.fila-est-crud').forEach(row => {
            row.style.display = row.dataset.search.includes(q) ? '' : 'none';
        });
    }
</script>
@endpush
