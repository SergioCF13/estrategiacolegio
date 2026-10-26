<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\ArchivoEvidencia;
use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\EvaluacionSemanal;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EstrategiaController extends Controller
{
    public static function plantillasActividadesDefault(): array
    {
        return [
            [
                'numero_semana' => 1,
                'titulo' => 'Modelación matemática para contratación de Internet y Servidores Cloud',
                'fecha_aplicacion' => '2026-10-21',
                'tiempo_minutos' => 25,
                'orientacion_didactica' => 'Integra la modelación matemática de funciones lineales con la toma de decisiones tecnológicas y financieras. Los estudiantes evalúan dos planes de conectividad y almacenamiento en la nube según el tráfico en GB.',
                'habilidades' => 'Planteamiento de ecuaciones lineales de costo C(x) = 150 + 0,50x, cálculo de tráfico de datos, punto de equilibrio y justificación matemática de presupuestos.',
                'planteamiento' => 'Comparación entre Plan A (Bs 300 fijos/mes ilimitado) y Plan B (Bs 150 fijos + Bs 0,50 por GB) con consumos históricos de 180 GB, 220 GB, 260 GB, 300 GB y 340 GB.',
                'solucionario_docente' => 'Costos Plan B: Mes 1=Bs 240, Mes 2=Bs 260, Mes 3=Bs 280, Mes 4=Bs 300 (Equilibrio en 300 GB), Mes 5=Bs 320. Total 5 meses: Plan A=Bs 1.500 vs Plan B=Bs 1.400.',
                'ev_1_detalle' => 'Matriz comparativa de tráfico mensual (GB) y desglose de costos de los Planes A y B.',
                'ev_2_detalle' => 'Resolución algebraica de la ecuación de equilibrio (150 + 0,50x = 300) y cálculo del promedio mensual (260 GB).',
                'ev_3_detalle' => 'Prueba de escritorio y predicción del costo en el Mes 6 ante un incremento a 450 GB.',
                'ev_4_detalle' => 'Redacción de un dictamen técnico de 5 líneas dirigido al Director recomendando el plan óptimo.',
                'ev_5_detalle' => 'Defensa oral relámpago (1 min) sustentando la decisión con tres argumentos numéricos.',
                'ev_6_detalle' => 'Ficha integradora evaluada con escala cualitativa (Inicial/En Proceso/Logrado) y retroalimentación.',
                'logros_sesion' => 'Los estudiantes comprendieron cómo una función lineal modela un servicio real de TI y localizaron el punto de equilibrio en 300 GB.',
                'dificultades_sesion' => 'Se reforzó la multiplicación con decimales mediante modelado paso a paso en pizarra.',
            ],
            [
                'numero_semana' => 2,
                'titulo' => 'Cálculo de recurso limitante en ensamblaje de PCs y cotización de hardware',
                'fecha_aplicacion' => '2026-10-01',
                'tiempo_minutos' => 30,
                'orientacion_didactica' => 'Determinan cuántas computadoras pueden actualizarse con el stock actual identificando el factor limitante y auditan dos proformas comerciales con descuento porcentual.',
                'habilidades' => 'Razonamiento cuantitativo operacional, división entera y residuo, identificación del cuello de botella (recurso limitante) y cálculo de descuentos porcentuales (10%).',
                'planteamiento' => 'Stock: 35 RAM (2 por PC), 18 SSD (1 por PC) y 64 RJ-45 (4 por PC). Cotización de lote extra: Proveedor A sin descuento vs Proveedor B con 10% de descuento sobre el total.',
                'solucionario_docente' => 'Recurso limitante: Conectores RJ-45 (máximo 16 PCs completas; sobran 3 RAM y 2 SSD). Cotización: Proveedor A = Bs 2.700; Proveedor B = Bs 2.556 (Ahorro neto de Bs 144).',
                'ev_1_detalle' => 'Tabla de inventario disponible vs requisito técnico por estación de trabajo.',
                'ev_2_detalle' => 'Cálculo de divisiones de alcance por componente y auditoría aritmética de ambas proformas con descuento del 10%.',
                'ev_3_detalle' => 'Verificación de saldos sobrantes en almacén (3 RAM y 2 SSD) y comprobación del ahorro neto (Bs 144).',
                'ev_4_detalle' => 'Informe escrito de adjudicación de compra dirigido al Gobierno Estudiantil / Dirección.',
                'ev_5_detalle' => 'Exposición oral argumentando por qué un precio unitario mayor con 10% de descuento global resultó más económico.',
                'ev_6_detalle' => 'Guía de presupuesto resuelta, sellada y valorada con criterios de desempeño.',
                'logros_sesion' => 'Excelente participación al descubrir que el proveedor con descuento global del 10% generaba un ahorro neto de Bs 144.',
                'dificultades_sesion' => 'Se aclaró por qué el menor cociente entero define el recurso limitante del sistema.',
            ],
            [
                'numero_semana' => 3,
                'titulo' => 'Lógica de conjuntos y consultas de Bases de Datos con Diagramas de Venn',
                'fecha_aplicacion' => '2026-10-08',
                'tiempo_minutos' => 25,
                'orientacion_didactica' => 'Aplica la teoría de conjuntos y los Diagramas de Venn al filtrado de registros en Bases de Datos, identificando intersecciones (AND), uniones (OR) y exclusiones (NOT).',
                'habilidades' => 'Abstracción formal, representación gráfica de relaciones de pertenencia/exclusión y lógica proposicional aplicada a consultas SQL.',
                'planteamiento' => 'Muestra A (N=40): 24 programan en Python, 20 en JavaScript, 6 en ninguno. Muestra B (N=50): 32 acceden por Celular, 28 por PC y 15 usan ambos.',
                'solucionario_docente' => 'Muestra A: Intersección (Ambos) = 10 (25%); Solo Python = 14; Solo JS = 10; Ninguno = 6. Muestra B: Ambos = 15 (30%); Solo Celular = 17; Solo PC = 13; Sin acceso = 5.',
                'ev_1_detalle' => 'Tabla de extracción de subconjuntos y universo muestral (N=40 y N=50).',
                'ev_2_detalle' => 'Construcción gráfica de los dos Diagramas de Venn y resolución de la ecuación de intersección n(A ∩ B).',
                'ev_3_detalle' => 'Comprobación de suma de regiones disjuntas (14+10+10+6=40 y 17+15+13+5=50) y cálculo porcentual.',
                'ev_4_detalle' => 'Reporte escrito explicando cómo la intersección evita registros duplicados en una consulta de base de datos.',
                'ev_5_detalle' => 'Socialización en pizarra vinculando las zonas del diagrama con los operadores lógicos AND, OR y NOT.',
                'ev_6_detalle' => 'Ficha de lógica y clasificación evaluada y registrada en el seguimiento del curso.',
                'logros_sesion' => 'Se consolidó la relación entre los Diagramas de Venn y las consultas condicionales WHERE en bases de datos.',
                'dificultades_sesion' => 'El gráfico en pizarra permitió comprender la resta de la intersección antes de sumar conjuntos.',
            ],
            [
                'numero_semana' => 4,
                'titulo' => 'Dimensionamiento de almacenamiento, conversión de unidades y autonomía de Servidor',
                'fecha_aplicacion' => '2026-10-15',
                'tiempo_minutos' => 30,
                'orientacion_didactica' => 'Los estudiantes dimensionan un servidor de copias de seguridad (Backups) de 2 TB con generación diaria de 40.000 MB convirtiendo unidades y calculando tiempos de operación.',
                'habilidades' => 'Conversión de unidades informáticas (TB, GB, MB), cálculo de porcentajes de capacidad útil (30%) y modelización proporcional de autonomía en días y horas.',
                'planteamiento' => 'Servidor de Backups de 2 TB (1 TB = 1.000 GB; 1 GB = 1.000 MB). Flujo diario: 40.000 MB/día. Calcular capacidad en GB/MB, días al 100% y horas al 30% de espacio libre.',
                'solucionario_docente' => 'a) 2 TB = 2.000 GB = 2.000.000 MB; carga diaria = 40 GB/día. b) Al 100%: 50 días. c) Al 30% (600 GB libres): 15 días = 360 horas.',
                'ev_1_detalle' => 'Esquema cilíndrico rotulado del servidor de 2 TB y tabla de equivalencias TB, GB y MB.',
                'ev_2_detalle' => 'Desarrollo algebraico de los tres incisos expresando unidades de capacidad y tiempo (días y horas).',
                'ev_3_detalle' => 'Indagación y verificación del impacto de un algoritmo de compresión (.zip al 50%) que duplica la autonomía a 30 días.',
                'ev_4_detalle' => 'Conclusión técnica escrita sobre la viabilidad del servidor y protocolo de mantenimiento recomendado.',
                'ev_5_detalle' => 'Sustentación oral de la cadena de factores de conversión de unidades en la pizarra.',
                'ev_6_detalle' => 'Informe integrador de cierre de ciclo calificado con nivel de logro final y retroalimentación.',
                'logros_sesion' => 'La mayoría del curso alcanzó autonomía en la conversión de unidades y en la interpretación física de los resultados.',
                'dificultades_sesion' => 'Se reforzó el factor de conversión de días a horas (× 24) en estudiantes que requerían apoyo medio.',
            ],
        ];
    }

    public static function crearEvaluacionesInicialesParaEstudiante(Estudiante $est): void
    {
        $actividades = Actividad::where('curso_id', $est->curso_id)
            ->where('estado', 'EJECUTADA')
            ->orderBy('anio')
            ->orderBy('mes')
            ->orderBy('numero_semana')
            ->get();
        $diag = $est->diagnostico_inicial;

        foreach ($actividades as $act) {
            $sem = $act->numero_semana;
            if ($diag === 'INICIAL') {
                $nivel = ($sem === 1) ? 'INICIAL' : (($sem <= 3) ? 'EN_PROCESO' : 'LOGRADO');
            } elseif ($diag === 'EN_PROCESO') {
                $nivel = ($sem <= 2) ? 'EN_PROCESO' : 'LOGRADO';
            } else {
                $nivel = 'LOGRADO';
            }

            $apoyo = match ($nivel) {
                'INICIAL' => 'APOYO_ALTO',
                'EN_PROCESO' => 'APOYO_MEDIO',
                default => 'APOYO_BAJO',
            };

            EvaluacionSemanal::updateOrCreate(
                [
                    'actividad_id' => $act->id,
                    'estudiante_id' => $est->id,
                ],
                [
                    'criterio_1' => $nivel,
                    'criterio_2' => $nivel,
                    'criterio_3' => $nivel,
                    'criterio_4' => ($sem === 1 && $nivel !== 'LOGRADO') ? 'INICIAL' : $nivel,
                    'nivel_desempeno' => $nivel,
                    'andamiaje_aplicado' => $apoyo,
                    'ev_1' => true,
                    'ev_2' => true,
                    'ev_3' => true,
                    'ev_4' => true,
                    'ev_5' => true,
                    'ev_6' => true,
                    'retroalimentacion' => EvaluacionSemanal::generarRetroalimentacionAutomatica($nivel, $apoyo, $sem),
                ]
            );
        }
    }

    // ==================== AUTENTICACIÓN ====================

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('estrategia.index');
        }
        return view('estrategia.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $admin = User::first();
        if (!$admin) {
            $admin = User::create([
                'name' => 'Administrador Docente - Sistemas Informáticos',
                'email' => 'admin@mineros.edu.bo',
                'password' => Hash::make('12345678'),
            ]);
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('estrategia.index'))
                ->with('success', 'Bienvenido al Panel de Administración de la Estrategia Nacional 2026.');
        }

        return back()->withErrors([
            'email' => 'Las credenciales ingresadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // ==================== 1. DASHBOARD PRINCIPAL ====================

    public function index(Request $request)
    {
        $request->validate([
            'mes' => 'sometimes|required|integer|between:1,12',
            'anio' => 'sometimes|required|integer|between:2020,2100',
            'actividad' => 'sometimes|required|integer|between:1,4',
        ]);
        $cursos = Curso::with(['actividades.evaluaciones', 'estudiantes.evaluaciones.actividad'])->get();
        $cursoId = $request->query('curso_id', $cursos->first()?->id);
        $cursoActivo = $cursos->firstWhere('id', $cursoId) ?? $cursos->first();
        $mes = (int) $request->query('mes', now()->month);
        $anio = (int) $request->query('anio', now()->year);
        $actividadSeleccionada = (int) $request->query('actividad', 1);

        $estadisticasSemanas = [];
        $totalEvidenciasPosibles = 0;
        $totalEvidenciasCumplidas = 0;

        if ($cursoActivo) {
            $this->crearActividadesDelMesSiFaltan($cursoActivo, $mes, $anio);
            $cursoActivo->load('actividades.evaluaciones');
            $cursoActivo->setRelation('actividades', $cursoActivo->actividades
                ->where('mes', $mes)
                ->where('anio', $anio)
                ->values());
            foreach ($cursoActivo->actividades as $act) {
                $total = max(1, $act->evaluaciones->count());
                $ini = $act->evaluaciones->where('nivel_desempeno', 'INICIAL')->count();
                $proc = $act->evaluaciones->where('nivel_desempeno', 'EN_PROCESO')->count();
                $log = $act->evaluaciones->where('nivel_desempeno', 'LOGRADO')->count();

                foreach ($act->evaluaciones as $ev) {
                    $totalEvidenciasPosibles += 6;
                    $totalEvidenciasCumplidas += $ev->totalEvidenciasCumplidas();
                }

                $estadisticasSemanas[$act->numero_semana] = [
                    'actividad' => $act,
                    'total' => $act->evaluaciones->count(),
                    'inicial' => $ini,
                    'en_proceso' => $proc,
                    'logrado' => $log,
                    'pct_inicial' => round(($ini / $total) * 100),
                    'pct_en_proceso' => round(($proc / $total) * 100),
                    'pct_logrado' => round(($log / $total) * 100),
                ];
            }
        }

        $pctGlobalEvidencias = $totalEvidenciasPosibles > 0
            ? round(($totalEvidenciasCumplidas / $totalEvidenciasPosibles) * 100)
            : 100;

        return view('estrategia.index', compact(
            'cursos',
            'cursoActivo',
            'estadisticasSemanas',
            'pctGlobalEvidencias',
            'totalEvidenciasCumplidas',
            'totalEvidenciasPosibles',
            'mes',
            'anio',
            'actividadSeleccionada'
        ));
    }

    // ==================== 2. CRUD COMPLETO DE CURSOS (CREAR, VER, EDITAR, ELIMINAR) ====================

    public function adminCursos(Request $request)
    {
        $cursos = Curso::withCount(['estudiantes', 'actividades'])->with('estudiantes')->get();
        $cursoVerId = $request->query('ver_curso_id');
        $cursoEditarId = $request->query('editar_curso_id');

        $cursoDetalle = $cursoVerId ? Curso::with(['estudiantes.evaluaciones.actividad', 'actividades'])->find($cursoVerId) : null;
        $cursoEditar = $cursoEditarId ? Curso::find($cursoEditarId) : null;
        $cursoActivo = $cursoDetalle ?? $cursoEditar ?? $cursos->first();

        return view('estrategia.admin_cursos', compact('cursos', 'cursoActivo', 'cursoDetalle', 'cursoEditar'));
    }

    public function crearCurso(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:120',
            'paralelo' => 'required|string|max:20',
            'area' => 'required|string|max:180',
            'capacidad' => 'required|string|max:180',
            'unidad_educativa' => 'required|string|max:180',
            'distrito' => 'required|string|max:180',
            'docente' => 'required|string|max:150',
            'director' => 'required|string|max:150',
            'trimestre' => 'required|string|max:120',
            'diagnostico_curso' => 'nullable|string',
        ]);

        $curso = Curso::create($data);

        // Crear las actividades iniciales del curso con sus seis tipos de evidencia.
        if ($request->boolean('clonar_actividades_base', true)) {
            foreach (self::plantillasActividadesDefault() as $actData) {
                $fecha = new \DateTimeImmutable($actData['fecha_aplicacion']);
                Actividad::create(array_merge($actData, [
                    'curso_id' => $curso->id,
                    'mes' => (int) $fecha->format('n'),
                    'anio' => (int) $fecha->format('Y'),
                    'estado' => 'EJECUTADA',
                ]));
            }
        }

        return redirect()->route('estrategia.admin.cursos', ['ver_curso_id' => $curso->id])
            ->with('success', "Curso {$curso->nombre} \"{$curso->paralelo}\" creado exitosamente con sus actividades iniciales.");
    }

    public function actualizarCurso(Request $request, Curso $curso)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:120',
            'paralelo' => 'required|string|max:20',
            'area' => 'nullable|string|max:180',
            'capacidad' => 'nullable|string|max:180',
            'unidad_educativa' => 'required|string|max:180',
            'distrito' => 'required|string|max:180',
            'docente' => 'required|string|max:150',
            'director' => 'required|string|max:150',
            'trimestre' => 'required|string|max:120',
            'diagnostico_curso' => 'nullable|string',
        ]);

        $curso->update(array_filter($data, fn($v) => !is_null($v)));

        if ($request->input('redirect_to') === 'admin_cursos') {
            return redirect()->route('estrategia.admin.cursos', ['ver_curso_id' => $curso->id])
                ->with('success', "Curso {$curso->nombre} \"{$curso->paralelo}\" actualizado correctamente.");
        }

        return redirect()->route('estrategia.index', ['curso_id' => $curso->id])
            ->with('success', 'Datos del curso actualizados correctamente.');
    }

    public function eliminarCurso(Curso $curso)
    {
        $nombre = "{$curso->nombre} \"{$curso->paralelo}\"";
        $curso->delete();

        return redirect()->route('estrategia.admin.cursos')
            ->with('success', "El curso {$nombre} y sus registros asociados fueron eliminados.");
    }

    // ==================== 3. CRUD DE ACTIVIDADES Y 6 EVIDENCIAS (TEXTO + IMÁGENES + VIDEOS) ====================

    public function adminActividades(Request $request)
    {
        $request->validate([
            'mes' => 'sometimes|required|integer|between:1,12',
            'anio' => 'sometimes|required|integer|between:2020,2100',
            'actividad' => 'sometimes|required|integer|between:1,4',
        ]);
        $cursos = Curso::with(['actividades.archivosEvidencia.estudiante', 'estudiantes'])->get();
        $cursoId = $request->query('curso_id', $cursos->first()?->id);
        $cursoActivo = $cursos->firstWhere('id', $cursoId) ?? $cursos->first();
        $mes = (int) $request->query('mes', now()->month);
        $anio = (int) $request->query('anio', now()->year);
        $semanaActiva = (int) $request->query('actividad', 1);

        if ($cursoActivo) {
            $this->crearActividadesDelMesSiFaltan($cursoActivo, $mes, $anio);
            $cursoActivo->load(['actividades.archivosEvidencia.estudiante', 'estudiantes']);
        }
        $actividades = $cursoActivo
            ? $cursoActivo->actividades
                ->where('mes', $mes)
                ->where('anio', $anio)
                ->where('numero_semana', $semanaActiva)
            : collect();

        return view('estrategia.admin_actividades', compact('cursos', 'cursoActivo', 'actividades', 'semanaActiva', 'mes', 'anio'));
    }

    public function subirArchivoEvidencia(Request $request, Actividad $actividad)
    {
        $request->validate([
            'numero_evidencia' => 'required|integer|min:1|max:6',
            'estudiante_id' => 'nullable|exists:estudiantes,id',
            'titulo' => 'nullable|string|max:200',
            'archivos.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,bmp,avif,svg,mp4,webm,ogg,mov,avi,mkv|max:102400',
            'url_externa' => 'nullable|string|max:500',
        ]);

        $destDir = public_path('evidencias');
        if (!is_dir($destDir)) {
            mkdir($destDir, 0775, true);
        }

        $contador = 0;

        // 1. Procesar archivos subidos desde la PC o celular (Imágenes o Videos)
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $file) {
                if (!$file || !$file->isValid()) {
                    continue;
                }
                $ext = strtolower($file->getClientOriginalExtension());
                $mime = $file->getMimeType() ?? '';
                $esVideo = str_starts_with($mime, 'video/');
                if (!$esVideo && !str_starts_with($mime, 'image/')) {
                    continue;
                }
                $tipo = $esVideo ? 'VIDEO' : 'IMAGEN';

                $nombreArchivo = 'ev_sem' . $actividad->numero_semana . '_tipo' . $request->input('numero_evidencia') . '_' . uniqid() . '.' . $ext;
                $file->move($destDir, $nombreArchivo);

                ArchivoEvidencia::create([
                    'actividad_id' => $actividad->id,
                    'estudiante_id' => $request->input('estudiante_id') ?: null,
                    'numero_evidencia' => $request->input('numero_evidencia'),
                    'tipo_archivo' => $tipo,
                    'titulo' => $request->input('titulo') ?: $file->getClientOriginalName(),
                    'ruta_archivo' => 'evidencias/' . $nombreArchivo,
                    'mime_type' => $mime,
                ]);
                $contador++;
            }
        }

        // 2. Procesar enlace de video externo (YouTube / Google Drive / TikTok / OneDrive) si se ingresó
        if ($request->filled('url_externa')) {
            ArchivoEvidencia::create([
                'actividad_id' => $actividad->id,
                'estudiante_id' => $request->input('estudiante_id') ?: null,
                'numero_evidencia' => $request->input('numero_evidencia'),
                'tipo_archivo' => 'VIDEO',
                'titulo' => $request->input('titulo') ?: 'Video de evidencia en clase',
                'ruta_archivo' => trim($request->input('url_externa')),
                'mime_type' => 'video/url',
            ]);
            $contador++;
        }

        return back()->with('success', "Se adjuntaron {$contador} archivo(s) multimedia a la Evidencia #{$request->input('numero_evidencia')} de la Actividad {$actividad->numero_semana}.");
    }

    public function eliminarArchivoEvidencia(ArchivoEvidencia $archivo)
    {
        if (!str_starts_with($archivo->ruta_archivo, 'http')) {
            $fullPath = public_path($archivo->ruta_archivo);
            if (file_exists($fullPath) && !str_contains($archivo->ruta_archivo, 'demo_')) {
                @unlink($fullPath);
            }
        }
        $archivo->delete();

        return back()->with('success', 'Archivo multimedia de evidencia eliminado correctamente.');
    }

    public function guardarActividad(Request $request, Actividad $actividad)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:220',
            'fecha_aplicacion' => 'nullable|date',
            'tiempo_minutos' => 'required|integer|min:10|max:90',
            'estado' => 'required|in:PLANIFICADA,EJECUTADA',
            'orientacion_didactica' => 'required|string',
            'habilidades' => 'required|string',
            'planteamiento' => 'required|string',
            'solucionario_docente' => 'nullable|string',
            'ev_1_detalle' => 'required|string',
            'ev_2_detalle' => 'required|string',
            'ev_3_detalle' => 'required|string',
            'ev_4_detalle' => 'required|string',
            'ev_5_detalle' => 'required|string',
            'ev_6_detalle' => 'required|string',
            'logros_sesion' => 'nullable|string',
            'dificultades_sesion' => 'nullable|string',
            'ev_1_archivos.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,bmp,avif,svg,mp4,webm,ogg,mov,avi,mkv|max:102400',
            'ev_2_archivos.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,bmp,avif,svg,mp4,webm,ogg,mov,avi,mkv|max:102400',
            'ev_3_archivos.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,bmp,avif,svg,mp4,webm,ogg,mov,avi,mkv|max:102400',
            'ev_4_archivos.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,bmp,avif,svg,mp4,webm,ogg,mov,avi,mkv|max:102400',
            'ev_5_archivos.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,bmp,avif,svg,mp4,webm,ogg,mov,avi,mkv|max:102400',
            'ev_6_archivos.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,bmp,avif,svg,mp4,webm,ogg,mov,avi,mkv|max:102400',
        ]);

        $actividad->update($data);

        // Si el docente seleccionó imágenes o videos directamente dentro de cualquiera de las 6 casillas de evidencia (1 a 6)
        $destDir = public_path('evidencias');
        if (!is_dir($destDir)) {
            mkdir($destDir, 0775, true);
        }

        $archivosSubidos = 0;
        for ($numEv = 1; $numEv <= 6; $numEv++) {
            $campoFile = "ev_{$numEv}_archivos";
            if ($request->hasFile($campoFile)) {
                foreach ($request->file($campoFile) as $file) {
                    if (!$file || !$file->isValid()) {
                        continue;
                    }
                    $ext = strtolower($file->getClientOriginalExtension());
                    $mime = $file->getMimeType() ?? '';
                    $esVideo = str_starts_with($mime, 'video/');
                    if (!$esVideo && !str_starts_with($mime, 'image/')) {
                        continue;
                    }
                    $tipo = $esVideo ? 'VIDEO' : 'IMAGEN';

                    $nombreArchivo = 'ev_sem' . $actividad->numero_semana . '_tipo' . $numEv . '_' . uniqid() . '.' . $ext;
                    $file->move($destDir, $nombreArchivo);

                    $campoDetalle = "ev_{$numEv}_detalle";
                    ArchivoEvidencia::create([
                        'actividad_id' => $actividad->id,
                        'estudiante_id' => null,
                        'numero_evidencia' => $numEv,
                        'tipo_archivo' => $tipo,
                        'titulo' => $actividad->$campoDetalle ?: $file->getClientOriginalName(),
                        'ruta_archivo' => 'evidencias/' . $nombreArchivo,
                        'mime_type' => $mime,
                    ]);
                    $archivosSubidos++;
                }
            }

            $campoUrl = "ev_{$numEv}_video_url";
            if ($request->filled($campoUrl)) {
                $campoDetalle = "ev_{$numEv}_detalle";
                ArchivoEvidencia::create([
                    'actividad_id' => $actividad->id,
                    'estudiante_id' => null,
                    'numero_evidencia' => $numEv,
                    'tipo_archivo' => 'VIDEO',
                    'titulo' => $actividad->$campoDetalle ?: "Video de Evidencia #{$numEv}",
                    'ruta_archivo' => trim($request->input($campoUrl)),
                    'mime_type' => 'video/url',
                ]);
                $archivosSubidos++;
            }
        }

        $msgExtra = $archivosSubidos > 0 ? " Se guardaron además {$archivosSubidos} archivo(s) multimedia dentro de sus respectivas evidencias." : "";

        return redirect()->route('estrategia.admin.actividades', [
            'curso_id' => $actividad->curso_id,
            'mes' => $actividad->mes,
            'anio' => $actividad->anio,
            'actividad' => $actividad->numero_semana,
        ])
            ->with('success', "Actividad {$actividad->numero_semana} de {$actividad->nombreMes()} {$actividad->anio} y sus evidencias actualizadas correctamente.{$msgExtra}");
    }

    // ==================== 4. CRUD COMPLETO DE ESTUDIANTES (REGISTRAR CON SU CURSO, VER, EDITAR, ELIMINAR) ====================

    public function adminEstudiantes(Request $request)
    {
        $cursos = Curso::withCount('estudiantes')->get();
        $filtroCursoId = $request->query('curso_id');
        $editarEstudianteId = $request->query('editar_id');

        $query = Estudiante::with(['curso', 'evaluaciones.actividad'])->orderBy('curso_id')->orderBy('nombres_apellidos');
        if ($filtroCursoId && $filtroCursoId !== 'todos') {
            $query->where('curso_id', $filtroCursoId);
        }

        $estudiantesListado = $query->get();
        $cursoActivo = ($filtroCursoId && $filtroCursoId !== 'todos')
            ? $cursos->firstWhere('id', (int) $filtroCursoId)
            : $cursos->first();

        $estudianteEditar = $editarEstudianteId ? Estudiante::find($editarEstudianteId) : null;

        return view('estrategia.admin_estudiantes', compact(
            'cursos',
            'cursoActivo',
            'filtroCursoId',
            'estudiantesListado',
            'estudianteEditar'
        ));
    }

    public function crearEstudianteIndividual(Request $request)
    {
        $data = $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'nombres_apellidos' => 'required|string|max:180',
            'rude' => 'nullable|string|max:50',
            'diagnostico_inicial' => 'required|in:INICIAL,EN_PROCESO,LOGRADO',
            'dificultad_detectada' => 'nullable|string|max:255',
        ]);

        $est = Estudiante::create([
            'curso_id' => $data['curso_id'],
            'nombres_apellidos' => mb_strtoupper(trim($data['nombres_apellidos']), 'UTF-8'),
            'rude' => $data['rude'] ?? null,
            'diagnostico_inicial' => $data['diagnostico_inicial'],
            'dificultad_detectada' => $data['dificultad_detectada'] ?: 'Interpretación de datos en tablas, planteamiento algebraico y verificación de resultados',
        ]);

        self::crearEvaluacionesInicialesParaEstudiante($est);

        return redirect()->route('estrategia.admin.estudiantes', ['curso_id' => $est->curso_id])
            ->with('success', "Estudiante {$est->nombres_apellidos} registrado exitosamente en su curso.");
    }

    public function actualizarEstudiante(Request $request, Estudiante $estudiante)
    {
        $data = $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'nombres_apellidos' => 'required|string|max:180',
            'rude' => 'nullable|string|max:50',
            'diagnostico_inicial' => 'required|in:INICIAL,EN_PROCESO,LOGRADO',
            'dificultad_detectada' => 'nullable|string|max:255',
        ]);

        $cursoAnteriorId = (int) $estudiante->curso_id;
        $nuevoCursoId = (int) $data['curso_id'];

        $estudiante->update([
            'curso_id' => $nuevoCursoId,
            'nombres_apellidos' => mb_strtoupper(trim($data['nombres_apellidos']), 'UTF-8'),
            'rude' => $data['rude'] ?? null,
            'diagnostico_inicial' => $data['diagnostico_inicial'],
            'dificultad_detectada' => $data['dificultad_detectada'],
        ]);

        // Si se cambió de curso al estudiante, revincular sus evaluaciones a las actividades del nuevo curso
        if ($cursoAnteriorId !== $nuevoCursoId) {
            $estudiante->evaluaciones()->delete();
            self::crearEvaluacionesInicialesParaEstudiante($estudiante);
        }

        return redirect()->route('estrategia.admin.estudiantes', ['curso_id' => $nuevoCursoId])
            ->with('success', "Datos y curso del estudiante {$estudiante->nombres_apellidos} actualizados correctamente.");
    }

    public function importarEstudiantes(Request $request, Curso $curso)
    {
        $request->validate([
            'curso_id_destino' => 'nullable|exists:cursos,id',
            'lista_estudiantes' => 'required|string',
            'diagnostico_base' => 'required|in:INICIAL,EN_PROCESO,LOGRADO',
            'reemplazar_existentes' => 'nullable|boolean',
        ]);

        $cursoDestino = $request->filled('curso_id_destino')
            ? Curso::findOrFail($request->input('curso_id_destino'))
            : $curso;

        if ($request->boolean('reemplazar_existentes')) {
            $cursoDestino->estudiantes()->delete();
        }

        $lineas = preg_split('/\r\n|\r|\n/', trim($request->input('lista_estudiantes')));
        $contador = 0;

        foreach ($lineas as $linea) {
            $nombreLimpio = trim(preg_replace('/^\d+[\.\-\)\s]+/', '', trim($linea)));
            if ($nombreLimpio === '') {
                continue;
            }

            $est = Estudiante::create([
                'curso_id' => $cursoDestino->id,
                'nombres_apellidos' => mb_strtoupper($nombreLimpio, 'UTF-8'),
                'rude' => null,
                'diagnostico_inicial' => $request->input('diagnostico_base'),
                'dificultad_detectada' => $request->input('dificultad_base', 'Interpretación de datos en tablas, planteamiento algebraico y verificación de resultados'),
            ]);

            self::crearEvaluacionesInicialesParaEstudiante($est);
            $contador++;
        }

        return redirect()->route('estrategia.admin.estudiantes', ['curso_id' => $cursoDestino->id])
            ->with('success', "Se registraron {$contador} estudiantes en {$cursoDestino->nombre} \"{$cursoDestino->paralelo}\".");
    }

    public function eliminarEstudiante(Estudiante $estudiante)
    {
        $cursoId = $estudiante->curso_id;
        $nombre = $estudiante->nombres_apellidos;
        $estudiante->delete();

        return redirect()->route('estrategia.admin.estudiantes', ['curso_id' => $cursoId])
            ->with('success', "Estudiante {$nombre} eliminado correctamente.");
    }

    // ==================== 5. CALIFICACIÓN POR SEMANA ====================

    public function evaluarSemana(Request $request, Curso $curso, int $semana)
    {
        $request->validate([
            'mes' => 'sometimes|required|integer|between:1,12',
            'anio' => 'sometimes|required|integer|between:2020,2100',
            'actividad' => 'sometimes|required|integer|between:1,4',
        ]);
        $mes = (int) $request->query('mes', now()->month);
        $anio = (int) $request->query('anio', now()->year);
        $cursos = Curso::all();
        $cursoActivo = $curso;
        $actividad = $curso->actividades()
            ->with('archivosEvidencia.estudiante')
            ->where('mes', $mes)
            ->where('anio', $anio)
            ->where('numero_semana', $semana)
            ->first();

        if (!$actividad) {
            $this->crearActividadesDelMesSiFaltan($curso, $mes, $anio);
            $actividad = $curso->actividades()
                ->where('mes', $mes)
                ->where('anio', $anio)
                ->where('numero_semana', $semana)
                ->firstOrFail();
        }

        $estudiantes = $curso->estudiantes()->with(['evaluaciones' => function ($q) use ($actividad) {
            $q->where('actividad_id', $actividad->id);
        }])->get();

        foreach ($estudiantes as $est) {
            if ($est->evaluaciones->isEmpty()) {
                $ev = EvaluacionSemanal::create([
                    'actividad_id' => $actividad->id,
                    'estudiante_id' => $est->id,
                    'criterio_1' => 'EN_PROCESO',
                    'criterio_2' => 'EN_PROCESO',
                    'criterio_3' => 'EN_PROCESO',
                    'criterio_4' => 'EN_PROCESO',
                    'nivel_desempeno' => 'EN_PROCESO',
                    'andamiaje_aplicado' => 'APOYO_MEDIO',
                    'ev_1' => true,
                    'ev_2' => true,
                    'ev_3' => true,
                    'ev_4' => true,
                    'ev_5' => true,
                    'ev_6' => true,
                    'retroalimentacion' => EvaluacionSemanal::generarRetroalimentacionAutomatica('EN_PROCESO', 'APOYO_MEDIO', $semana),
                ]);
                $est->setRelation('evaluaciones', collect([$ev]));
            }
        }

        return view('estrategia.evaluar_semana', compact('cursos', 'cursoActivo', 'curso', 'actividad', 'estudiantes', 'semana', 'mes', 'anio'));
    }

    public function guardarEvaluacionSemana(Request $request, Curso $curso, int $semana)
    {
        $request->validate([
            'mes' => 'required|integer|between:1,12',
            'anio' => 'required|integer|between:2020,2100',
        ]);
        $mes = (int) $request->input('mes');
        $anio = (int) $request->input('anio');
        $actividad = $curso->actividades()
            ->where('mes', $mes)
            ->where('anio', $anio)
            ->where('numero_semana', $semana)
            ->firstOrFail();

        $actividad->update([
            'titulo' => $request->input('titulo', $actividad->titulo),
            'fecha_aplicacion' => $request->input('fecha_aplicacion', $actividad->fecha_aplicacion),
            'tiempo_minutos' => $request->input('tiempo_minutos', $actividad->tiempo_minutos),
            'logros_sesion' => $request->input('logros_sesion', $actividad->logros_sesion),
            'dificultades_sesion' => $request->input('dificultades_sesion', $actividad->dificultades_sesion),
        ]);

        $evalsInput = $request->input('eval', []);
        $regenerarTexto = $request->boolean('regenerar_retroalimentacion');

        foreach ($evalsInput as $estudianteId => $row) {
            $nivel = $row['nivel_desempeno'] ?? 'EN_PROCESO';
            $apoyo = $row['andamiaje_aplicado'] ?? 'APOYO_MEDIO';
            $textoActual = trim($row['retroalimentacion'] ?? '');

            if ($regenerarTexto || $textoActual === '') {
                $textoActual = EvaluacionSemanal::generarRetroalimentacionAutomatica($nivel, $apoyo, $semana);
            }

            EvaluacionSemanal::updateOrCreate(
                [
                    'actividad_id' => $actividad->id,
                    'estudiante_id' => $estudianteId,
                ],
                [
                    'criterio_1' => $row['criterio_1'] ?? $nivel,
                    'criterio_2' => $row['criterio_2'] ?? $nivel,
                    'criterio_3' => $row['criterio_3'] ?? $nivel,
                    'criterio_4' => $row['criterio_4'] ?? $nivel,
                    'nivel_desempeno' => $nivel,
                    'andamiaje_aplicado' => $apoyo,
                    'ev_1' => isset($row['ev_1']),
                    'ev_2' => isset($row['ev_2']),
                    'ev_3' => isset($row['ev_3']),
                    'ev_4' => isset($row['ev_4']),
                    'ev_5' => isset($row['ev_5']),
                    'ev_6' => isset($row['ev_6']),
                    'retroalimentacion' => $textoActual,
                ]
            );
        }

        return redirect()->route('estrategia.evaluar', ['curso' => $curso->id, 'semana' => $semana, 'mes' => $mes, 'anio' => $anio])
            ->with('success', "Evaluaciones y evidencias de la Actividad {$semana} guardadas correctamente.");
    }

    // ==================== 6. REPORTES PDF ====================

    public function adminReportes(Request $request)
    {
        $request->validate([
            'mes' => 'sometimes|required|integer|between:1,12',
            'anio' => 'sometimes|required|integer|between:2020,2100',
            'actividad' => 'sometimes|required|integer|between:1,4',
        ]);

        $cursos = Curso::with('estudiantes')->get();
        $cursoId = $request->query('curso_id', $cursos->first()?->id);
        $cursoActivo = $cursos->firstWhere('id', $cursoId) ?? $cursos->first();
        $mes = (int) $request->query('mes', now()->month);
        $anio = (int) $request->query('anio', now()->year);
        $actividadSeleccionada = (int) $request->query('actividad', 1);
        $nombreMes = self::nombreMes($mes);
        foreach ($cursos as $curso) {
            $this->crearActividadesDelMesSiFaltan($curso, $mes, $anio);
        }

        return view('estrategia.admin_reportes', compact('cursos', 'cursoActivo', 'mes', 'anio', 'nombreMes', 'actividadSeleccionada'));
    }

    public function pdfInformeGeneralCurso(Request $request, Curso $curso)
    {
        $request->validate([
            'mes' => 'sometimes|required|integer|between:1,12',
            'anio' => 'sometimes|required|integer|between:2020,2100',
            'actividad' => 'sometimes|required|integer|between:1,4',
        ]);
        $mes = (int) $request->query('mes', now()->month);
        $anio = (int) $request->query('anio', now()->year);
        $actividadSeleccionada = (int) $request->query('actividad', 1);
        $nombreMes = self::nombreMes($mes);
        $this->crearActividadesDelMesSiFaltan($curso, $mes, $anio);
        $curso->load(['actividades.evaluaciones', 'actividades.archivosEvidencia.estudiante', 'estudiantes']);
        $curso->setRelation('actividades', $curso->actividades
            ->where('mes', $mes)
            ->where('anio', $anio)
            ->where('numero_semana', $actividadSeleccionada)
            ->values());

        $estadisticasSemanas = [];
        foreach ($curso->actividades as $act) {
            $total = max(1, $act->evaluaciones->count());
            $ini = $act->evaluaciones->where('nivel_desempeno', 'INICIAL')->count();
            $proc = $act->evaluaciones->where('nivel_desempeno', 'EN_PROCESO')->count();
            $log = $act->evaluaciones->where('nivel_desempeno', 'LOGRADO')->count();

            $estadisticasSemanas[$act->numero_semana] = [
                'actividad' => $act,
                'total' => $act->evaluaciones->count(),
                'inicial' => $ini,
                'en_proceso' => $proc,
                'logrado' => $log,
                'pct_inicial' => round(($ini / $total) * 100),
                'pct_en_proceso' => round(($proc / $total) * 100),
                'pct_logrado' => round(($log / $total) * 100),
            ];
        }
        $periodo = "{$nombreMes} {$anio} — Actividad {$actividadSeleccionada}";
        $pdf = Pdf::loadView('estrategia.pdf_informe_curso', compact('curso', 'estadisticasSemanas', 'mes', 'anio', 'nombreMes', 'periodo', 'actividadSeleccionada'))
            ->setPaper('letter', 'portrait');

        $slug = str_replace([' ', '.', 'º'], ['_', '', 'to'], $curso->nombre);
        return $pdf->download("Informe_General_Curso_{$slug}_{$nombreMes}_{$anio}_Actividad_{$actividadSeleccionada}_Sistemas_Informaticos.pdf");
    }

    public function pdfInformesEstudiantesCurso(Request $request, Curso $curso)
    {
        $request->validate([
            'mes' => 'sometimes|required|integer|between:1,12',
            'anio' => 'sometimes|required|integer|between:2020,2100',
            'actividad' => 'sometimes|required|integer|between:1,4',
        ]);
        $mes = (int) $request->query('mes', now()->month);
        $anio = (int) $request->query('anio', now()->year);
        $actividadSeleccionada = (int) $request->query('actividad', 1);
        $nombreMes = self::nombreMes($mes);
        $periodo = "{$nombreMes} {$anio} — Actividad {$actividadSeleccionada}";
        $this->crearActividadesDelMesSiFaltan($curso, $mes, $anio);
        $curso->load(['actividades.archivosEvidencia', 'estudiantes.evaluaciones.actividad', 'estudiantes.archivosEvidencia.actividad']);
        $curso->setRelation('actividades', $curso->actividades
            ->where('mes', $mes)
            ->where('anio', $anio)
            ->where('numero_semana', $actividadSeleccionada)
            ->values());
        foreach ($curso->estudiantes as $estudiante) {
            $estudiante->setRelation('evaluaciones', $estudiante->evaluaciones
                ->filter(fn ($evaluacion) => (int) $evaluacion->actividad?->mes === $mes
                    && (int) $evaluacion->actividad?->anio === $anio
                    && (int) $evaluacion->actividad?->numero_semana === $actividadSeleccionada)
                ->values());
            $estudiante->setRelation('archivosEvidencia', $estudiante->archivosEvidencia
                ->filter(fn ($archivo) => (int) $archivo->actividad?->mes === $mes
                    && (int) $archivo->actividad?->anio === $anio
                    && (int) $archivo->actividad?->numero_semana === $actividadSeleccionada)
                ->values());
        }
        $estudiantes = $curso->estudiantes;
        $semana = $actividadSeleccionada;

        $pdf = Pdf::loadView('estrategia.pdf_informe_estudiantes', compact('curso', 'estudiantes', 'semana', 'mes', 'anio', 'nombreMes', 'periodo', 'actividadSeleccionada'))
            ->setPaper('letter', 'portrait');

        $slug = str_replace([' ', '.', 'º'], ['_', '', 'to'], $curso->nombre);
        return $pdf->download("Informes_Individuales_Estudiantes_{$slug}_{$nombreMes}_{$anio}_Actividad_{$actividadSeleccionada}_Sistemas.pdf");
    }

    public function pdfInformeIndividualEstudiante(Request $request, Estudiante $estudiante)
    {
        $request->validate([
            'mes' => 'sometimes|required|integer|between:1,12',
            'anio' => 'sometimes|required|integer|between:2020,2100',
            'actividad' => 'sometimes|required|integer|between:1,4',
        ]);
        $mes = (int) $request->query('mes', now()->month);
        $anio = (int) $request->query('anio', now()->year);
        $actividadSeleccionada = (int) $request->query('actividad', 1);
        $nombreMes = self::nombreMes($mes);
        $periodo = "{$nombreMes} {$anio} — Actividad {$actividadSeleccionada}";
        $estudiante->load(['curso.actividades.archivosEvidencia', 'evaluaciones.actividad', 'archivosEvidencia.actividad']);
        $curso = $estudiante->curso;
        $this->crearActividadesDelMesSiFaltan($curso, $mes, $anio);
        $curso->load('actividades.archivosEvidencia');
        $estudiante->load(['evaluaciones.actividad', 'archivosEvidencia.actividad']);
        $curso->setRelation('actividades', $curso->actividades
            ->where('mes', $mes)
            ->where('anio', $anio)
            ->where('numero_semana', $actividadSeleccionada)
            ->values());
        $estudiante->setRelation('evaluaciones', $estudiante->evaluaciones
            ->filter(fn ($evaluacion) => (int) $evaluacion->actividad?->mes === $mes
                && (int) $evaluacion->actividad?->anio === $anio
                && (int) $evaluacion->actividad?->numero_semana === $actividadSeleccionada)
            ->values());
        $estudiante->setRelation('archivosEvidencia', $estudiante->archivosEvidencia
            ->filter(fn ($archivo) => (int) $archivo->actividad?->mes === $mes
                && (int) $archivo->actividad?->anio === $anio
                && (int) $archivo->actividad?->numero_semana === $actividadSeleccionada)
            ->values());
        $estudiantes = collect([$estudiante]);
        $semana = $actividadSeleccionada;

        $pdf = Pdf::loadView('estrategia.pdf_informe_estudiantes', compact('curso', 'estudiantes', 'semana', 'mes', 'anio', 'nombreMes', 'periodo', 'actividadSeleccionada'))
            ->setPaper('letter', 'portrait');

        $nombreSlug = str_replace(' ', '_', $estudiante->nombres_apellidos);
        return $pdf->download("Informe_Estudiante_{$nombreSlug}_{$nombreMes}_{$anio}_Actividad_{$actividadSeleccionada}.pdf");
    }

    private function crearActividadesDelMesSiFaltan(Curso $curso, int $mes, int $anio): void
    {
        for ($numeroActividad = 1; $numeroActividad <= 4; $numeroActividad++) {
            Actividad::firstOrCreate(
                [
                    'curso_id' => $curso->id,
                    'anio' => $anio,
                    'mes' => $mes,
                    'numero_semana' => $numeroActividad,
                ],
                [
                    'titulo' => "Actividad {$numeroActividad}",
                    'fecha_aplicacion' => null,
                    'tiempo_minutos' => 25,
                    'orientacion_didactica' => '',
                    'habilidades' => '',
                    'planteamiento' => '',
                    'ev_1_detalle' => '',
                    'ev_2_detalle' => '',
                    'ev_3_detalle' => '',
                    'ev_4_detalle' => '',
                    'ev_5_detalle' => '',
                    'ev_6_detalle' => '',
                    'estado' => 'PLANIFICADA',
                ]
            );
        }
    }

    private static function nombreMes(int $mes): string
    {
        return [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre',
        ][$mes] ?? 'Mes';
    }
}
