<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Administración — Estrategia Nacional 2026')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-slate-100 text-slate-800 antialiased">

<!-- Barra Tricolor Institucional Fija -->
<div class="flex h-1.5 w-full fixed top-0 left-0 z-50">
    <div class="flex-1 bg-red-600"></div>
    <div class="flex-1 bg-yellow-400"></div>
    <div class="flex-1 bg-green-700"></div>
</div>

<div class="min-h-screen flex pt-1.5">

    <!-- ==================== SIDEBAR DEL PANEL DE ADMINISTRACIÓN ==================== -->
    <aside class="w-64 bg-slate-900 text-slate-200 flex flex-col justify-between shrink-0 shadow-xl">
        <div>
            <!-- Logo / Título del Sistema -->
            <div class="p-4 border-b border-slate-800 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-amber-500 to-yellow-600 flex items-center justify-center text-slate-950 font-black text-lg shadow">
                    SI
                </div>
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-amber-400 block">Panel Administrativo</span>
                    <h2 class="text-sm font-extrabold text-white leading-tight">Estrategia Logro 2026</h2>
                    <span class="text-[10px] text-slate-400 block">Distrito Mineros (7036)</span>
                </div>
            </div>

            <!-- Menú de Navegación -->
            <div class="p-3 space-y-1 text-xs font-semibold">
                <p class="px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-500">
                    Módulos de Gestión
                </p>

                <a href="{{ route('estrategia.index', isset($cursoActivo) ? ['curso_id' => $cursoActivo->id] : []) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('estrategia.index') || request()->routeIs('estrategia.admin.dashboard') ? 'bg-amber-500 text-slate-950 font-bold shadow' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <span class="text-base">📊</span>
                    <span>Dashboard y Estadísticas</span>
                </a>

                <a href="{{ route('estrategia.admin.cursos') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('estrategia.admin.cursos') ? 'bg-amber-500 text-slate-950 font-bold shadow' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <span class="text-base">🏫</span>
                    <span>Gestión de Cursos</span>
                </a>

                <a href="{{ route('estrategia.admin.actividades', isset($cursoActivo) ? ['curso_id' => $cursoActivo->id] : []) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('estrategia.admin.actividades') ? 'bg-amber-500 text-slate-950 font-bold shadow' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <span class="text-base">📅</span>
                    <span>Actividades y 6 Evidencias</span>
                </a>

                <a href="{{ route('estrategia.admin.estudiantes', isset($cursoActivo) ? ['curso_id' => $cursoActivo->id] : []) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('estrategia.admin.estudiantes') ? 'bg-amber-500 text-slate-950 font-bold shadow' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <span class="text-base">👨‍🎓</span>
                    <span>Estudiantes y Diagnóstico</span>
                </a>

                @php $firstCursoId = isset($cursoActivo) && $cursoActivo ? $cursoActivo->id : (\App\Models\Curso::first()?->id ?? 1); @endphp
                <div class="pt-2">
                    <p class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-500">
                        Evaluación Rápida Semanal
                    </p>
                    <div class="grid grid-cols-2 gap-1.5 px-2 mt-1">
                        @for($s = 1; $s <= 4; $s++)
                            <a href="{{ route('estrategia.evaluar', ['curso' => $firstCursoId, 'semana' => $s, 'mes' => now()->month, 'anio' => now()->year]) }}"
                               class="text-center py-1.5 px-2 rounded border text-[11px] transition {{ request()->routeIs('estrategia.evaluar') && isset($semana) && $semana == $s ? 'bg-amber-500 text-slate-950 border-amber-400 font-bold' : 'bg-slate-800/70 border-slate-700 text-slate-300 hover:bg-slate-700' }}">
                                ✅ Semana {{ $s }}
                            </a>
                        @endfor
                    </div>
                </div>

                <div class="pt-2">
                    <p class="px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-500">
                        Informes Oficiales (PDF)
                    </p>
                    <a href="{{ route('estrategia.admin.reportes', isset($cursoActivo) ? ['curso_id' => $cursoActivo->id] : []) }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('estrategia.admin.reportes') ? 'bg-amber-500 text-slate-950 font-bold shadow' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span class="text-base">🖨️</span>
                        <span>Centro de Reportes PDF</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Pie del Sidebar / Usuario -->
        <div class="p-3 border-t border-slate-800 bg-slate-950/60 text-xs">
            <div class="flex items-center justify-between">
                <div class="truncate">
                    <p class="font-bold text-white truncate">
                        {{ auth()->user()?->name ?? 'Prof. Sistemas Informáticos' }}
                    </p>
                    <p class="text-[10px] text-emerald-400">● Sistema Activo (MySQL)</p>
                </div>
                @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-red-400 text-xs px-2 py-1 rounded bg-slate-800" title="Cerrar Sesión">
                            Salir
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-amber-400 hover:underline text-[11px] font-bold">Login</a>
                @endauth
            </div>
        </div>
    </aside>

    <!-- ==================== CONTENIDO PRINCIPAL ==================== -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- Topbar Superior -->
        <header class="bg-white border-b border-slate-200 px-6 py-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 shadow-sm">
            <div>
                <h1 class="text-base md:text-lg font-extrabold text-slate-900">
                    @yield('page_title', 'Panel de Administración — Estrategia Nacional de Logro de Aprendizajes')
                </h1>
                <p class="text-xs text-slate-500">
                    @yield('page_subtitle', 'Área: Técnica Tecnológica Especializada — Sistemas Informáticos | Capacidad: Pensamiento Lógico - Matemático')
                </p>
            </div>

            <!-- Selector Rápido de Curso en la Topbar -->
            @if(isset($cursos) && $cursos->count() > 0)
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-xs font-bold text-slate-500 uppercase">Curso Activo:</span>
                    @foreach($cursos as $c)
                        <a href="{{ request()->fullUrlWithQuery(['curso_id' => $c->id]) }}"
                           class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ isset($cursoActivo) && $cursoActivo && $cursoActivo->id === $c->id ? 'bg-slate-900 text-amber-400 shadow ring-2 ring-amber-400/50' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                            🎓 {{ $c->nombre }} "{{ $c->paralelo }}"
                        </a>
                    @endforeach
                </div>
            @endif
        </header>

        <!-- Área de Trabajo -->
        <main class="p-6 space-y-6 flex-1 overflow-y-auto">
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-600 text-emerald-900 px-4 py-3 rounded-lg shadow-sm flex items-center justify-between text-xs md:text-sm font-medium">
                    <span>✅ {{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-600 text-red-900 px-4 py-3 rounded-lg shadow-sm flex items-center justify-between text-xs md:text-sm font-medium">
                    <span>⚠️ {{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-600 text-red-900 px-4 py-3 rounded-lg shadow-sm text-xs">
                    <p class="font-bold mb-1">Por favor corrige los siguientes campos:</p>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
