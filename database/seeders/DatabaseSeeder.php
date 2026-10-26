<?php

namespace Database\Seeders;

use App\Models\Actividad;
use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\EvaluacionSemanal;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@mineros.edu.bo'],
            [
                'name' => 'Administrador Docente - Sistemas Informáticos',
                'password' => Hash::make('12345678'),
            ]
        );
        $cursosData = [
            [
                'nombre' => '5.º de Secundaria',
                'paralelo' => 'A',
                'diagnostico_curso' => 'En el diagnóstico inicial aplicado al curso de 5.º de Secundaria en el área de Sistemas Informáticos, se identificó rezago escolar en la traducción de enunciados técnicos a expresiones matemáticas, cálculo de porcentajes comerciales, lógica de conjuntos y conversión de unidades de almacenamiento (TB, GB, MB). Se implementó una rutina pedagógica estructurada de 4 sesiones semanales (25-30 min) con andamiaje progresivo.',
                'estudiantes' => [
                    ['nombres' => 'AGUILAR MAMANI CARLOS DANIEL', 'rude' => '819200112026', 'diag' => 'INICIAL', 'dif' => 'Planteamiento de ecuaciones lineales a partir de tablas de tráfico de datos'],
                    ['nombres' => 'CHOQUE CONDORI MARIA FERNANDA', 'rude' => '819200122026', 'diag' => 'EN_PROCESO', 'dif' => 'Verificación de descuentos porcentuales e identificación del recurso limitante'],
                    ['nombres' => 'FLORES ROJAS JHONATAN DAVID', 'rude' => '819200132026', 'diag' => 'INICIAL', 'dif' => 'Operaciones de división entera y conversión de unidades informáticas TB/GB/MB'],
                    ['nombres' => 'GUTIERREZ VARGAS ANA BELEN', 'rude' => '819200142026', 'diag' => 'LOGRADO', 'dif' => 'Profundización y transferencia de modelos lógicos hacia consultas SQL'],
                    ['nombres' => 'LOPEZ TORREZ KEVIN ALEJANDRO', 'rude' => '819200152026', 'diag' => 'EN_PROCESO', 'dif' => 'Representación de intersecciones en Diagramas de Venn y redacción argumentativa'],
                    ['nombres' => 'MENDOZA QUISPE CAMILA VALERIA', 'rude' => '819200162026', 'diag' => 'INICIAL', 'dif' => 'Comprensión de enunciados problemáticos y relación entre variables'],
                    ['nombres' => 'ORTEGA SALAZAR DIEGO ARMANDO', 'rude' => '819200172026', 'diag' => 'EN_PROCESO', 'dif' => 'Comunicación oral y justificación escrita de procedimientos matemáticos'],
                    ['nombres' => 'RODRIGUEZ PEREZ LUCIA NICOLE', 'rude' => '819200182026', 'diag' => 'EN_PROCESO', 'dif' => 'Aislamiento de la intersección de conjuntos para evitar duplicidad de datos'],
                ],
            ],
            [
                'nombre' => '6.º de Secundaria',
                'paralelo' => 'A',
                'diagnostico_curso' => 'En el diagnóstico inicial aplicado al curso de 6.º de Secundaria en el área de Sistemas Informáticos, se observó dificultad para modelizar costos operativos de servicios TI, auditar presupuestos con descuentos compuestos, aplicar lógica booleana (AND, OR, NOT) en bases de datos y dimensionar capacidades de servidores. Se ejecutaron 4 sesiones semanales focalizadas con recolección de las 6 evidencias de aprendizaje.',
                'estudiantes' => [
                    ['nombres' => 'ALVAREZ CASTRO RODRIGO SEBASTIAN', 'rude' => '819200212026', 'diag' => 'EN_PROCESO', 'dif' => 'Modelización algebraica del punto de equilibrio en costos de servidores'],
                    ['nombres' => 'BALDERRAMA SANCHEZ DANNA PAOLA', 'rude' => '819200222026', 'diag' => 'LOGRADO', 'dif' => 'Transferencia autónoma de lógica de conjuntos a arquitectura de bases de datos'],
                    ['nombres' => 'CACERES VILLARROEL MARCO ANTONIO', 'rude' => '819200232026', 'diag' => 'INICIAL', 'dif' => 'Cálculo proporcional, porcentajes de descuento e interpretación de tablas'],
                    ['nombres' => 'DELGADO MORALES SOFIA ALEJANDRA', 'rude' => '819200242026', 'diag' => 'EN_PROCESO', 'dif' => 'Conversión escalonada de unidades (TB a GB/MB) y tiempos en horas'],
                    ['nombres' => 'ESPINOZA HUANCA CRISTIAN JOEL', 'rude' => '819200252026', 'diag' => 'INICIAL', 'dif' => 'Organización de datos en matrices y redacción de conclusiones técnicas'],
                    ['nombres' => 'FERNANDEZ CESPEDES VALENTINA', 'rude' => '819200262026', 'diag' => 'EN_PROCESO', 'dif' => 'Sustentación oral con argumentos cuantitativos verificados'],
                    ['nombres' => 'MAMANI TICONA BRAYAN', 'rude' => '819200272026', 'diag' => 'EN_PROCESO', 'dif' => 'Determinación del insumo limitante en problemas de stock de hardware'],
                    ['nombres' => 'SUAREZ JUSTINIANO GABRIELA', 'rude' => '819200282026', 'diag' => 'LOGRADO', 'dif' => 'Optimización de modelos matemáticos y monitoreo colaborativo entre pares'],
                ],
            ],
        ];

        $actividadesPlantilla = [
            [
                'numero_semana' => 1,
                'titulo' => 'Modelación matemática para contratación de Internet y Servidores Cloud',
                'fecha_aplicacion' => '2026-10-21',
                'tiempo_minutos' => 25,
                'orientacion_didactica' => 'Integra la modelación matemática de funciones lineales con la toma de decisiones tecnológicas y financieras (adaptada de las págs. 44 y 67 de la Estrategia Nacional). Los estudiantes asumen el rol de consultores de TI para evaluar dos planes de conectividad y almacenamiento en la nube según el tráfico en GB.',
                'habilidades' => 'Planteamiento de ecuaciones lineales de costo C(x) = 150 + 0,50x, cálculo de tráfico de datos, punto de equilibrio y justificación matemática de presupuestos.',
                'planteamiento' => 'Comparación entre Plan A (Bs 300 fijos/mes ilimitado) y Plan B (Bs 150 fijos + Bs 0,50 por GB) con consumos históricos de 180 GB, 220 GB, 260 GB, 300 GB y 340 GB.',
                'solucionario_docente' => 'Costos Plan B: Mes 1=Bs 240, Mes 2=Bs 260, Mes 3=Bs 280, Mes 4=Bs 300 (Equilibrio en 300 GB), Mes 5=Bs 320. Total 5 meses: Plan A=Bs 1.500 vs Plan B=Bs 1.400. Proyección Mes 6 (450 GB): Plan B cobra Bs 375, por lo que conviene migrar al Plan A.',
                'ev_1_detalle' => 'Matriz comparativa de tráfico mensual (GB) y desglose de costos de los Planes A y B.',
                'ev_2_detalle' => 'Resolución algebraica de la ecuación de equilibrio (150 + 0,50x = 300) y cálculo del promedio mensual (260 GB).',
                'ev_3_detalle' => 'Prueba de escritorio y predicción del costo en el Mes 6 ante un incremento a 450 GB.',
                'ev_4_detalle' => 'Redacción de un dictamen técnico de 5 líneas dirigido al Director recomendando el plan óptimo.',
                'ev_5_detalle' => 'Defensa oral relámpago (1 min) sustentando la decisión con tres argumentos numéricos.',
                'ev_6_detalle' => 'Ficha integradora evaluada con escala cualitativa (Inicial/En Proceso/Logrado) y retroalimentación.',
                'logros_sesion' => 'Los estudiantes comprendieron cómo una función lineal modela un servicio real de TI y localizaron el punto de equilibrio en 300 GB.',
                'dificultades_sesion' => 'Un grupo reducido confundió inicialmente la multiplicación por el decimal 0,50 con dividir entre 5, lo cual se subsanó con modelado en pizarra.',
            ],
            [
                'numero_semana' => 2,
                'titulo' => 'Cálculo de recurso limitante en ensamblaje de PCs y cotización de hardware',
                'fecha_aplicacion' => '2026-10-01',
                'tiempo_minutos' => 30,
                'orientacion_didactica' => 'Basada en las actividades oficiales de Técnica Tecnológica (pág. 57, cálculo de insumos y factor limitante) y Gestión de Recursos (pág. 67, comparación de proveedores con descuento). Determinan cuántas PCs pueden actualizarse con el stock actual y auditan dos proformas comerciales.',
                'habilidades' => 'Razonamiento cuantitativo operacional, división entera y residuo, identificación del cuello de botella (recurso limitante) y cálculo de descuentos porcentuales (10%).',
                'planteamiento' => 'Stock: 35 RAM (2 por PC), 18 SSD (1 por PC) y 64 RJ-45 (4 por PC). Cotización de lote extra: Proveedor A sin descuento vs Proveedor B con 10% de descuento sobre el total.',
                'solucionario_docente' => 'Alcance: RAM=17 PCs (sobra 1), SSD=18 PCs, RJ-45=16 PCs. Recurso limitante: Conectores RJ-45 (máximo 16 PCs completas; sobran 3 RAM y 2 SSD). Cotización: Proveedor A = Bs 2.700; Proveedor B = Subtotal Bs 2.840 - 10% (Bs 284) = Bs 2.556 (Ahorro neto de Bs 144).',
                'ev_1_detalle' => 'Tabla de inventario disponible vs requisito técnico por estación de trabajo.',
                'ev_2_detalle' => 'Cálculo de divisiones de alcance por componente y auditoría aritmética de ambas proformas con descuento del 10%.',
                'ev_3_detalle' => 'Verificación de saldos sobrantes en almacén (3 RAM y 2 SSD) y comprobación del ahorro neto (Bs 144).',
                'ev_4_detalle' => 'Informe escrito de adjudicación de compra dirigido al Gobierno Estudiantil / Dirección.',
                'ev_5_detalle' => 'Exposición oral argumentando por qué un precio unitario mayor con 10% de descuento global resultó más económico.',
                'ev_6_detalle' => 'Guía de presupuesto resuelta, sellada y valorada con criterios de desempeño.',
                'logros_sesion' => 'Excelente participación al descubrir que el proveedor que parecía más caro a simple vista resultaba Bs 144 más barato al aplicar el 10% de descuento.',
                'dificultades_sesion' => 'Algunos estudiantes en nivel Inicial intentaron promediar las cantidades de componentes en lugar de elegir el menor cociente entero como factor limitante.',
            ],
            [
                'numero_semana' => 3,
                'titulo' => 'Lógica de conjuntos y consultas de Bases de Datos con Diagramas de Venn',
                'fecha_aplicacion' => '2026-10-08',
                'tiempo_minutos' => 25,
                'orientacion_didactica' => 'Aplica la teoría de conjuntos y los Diagramas de Venn (pág. 46 del documento del Ministerio) al filtrado de registros en Bases de Datos e Ingeniería de Software, identificando intersecciones (AND), uniones (OR) y exclusiones (NOT).',
                'habilidades' => 'Abstracción formal, representación gráfica de relaciones de pertenencia/exclusión y lógica proposicional aplicada a consultas SQL.',
                'planteamiento' => 'Muestra A (N=40): 24 programan en Python, 20 en JavaScript, 6 en ninguno. Muestra B (N=50): 32 acceden por Celular, 28 por PC y 15 usan ambos.',
                'solucionario_docente' => 'Muestra A: Unión = 34; Intersección (Ambos) = (24+20)-34 = 10 (25%); Solo Python = 14; Solo JS = 10; Ninguno = 6. Muestra B: Ambos = 15 (30%); Solo Celular = 17; Solo PC = 13; Sin acceso = 50 - 45 = 5 estudiantes (10%).',
                'ev_1_detalle' => 'Tabla de extracción de subconjuntos y universo muestral (N=40 y N=50).',
                'ev_2_detalle' => 'Construcción gráfica de los dos Diagramas de Venn y resolución de la ecuación de intersección n(A ∩ B).',
                'ev_3_detalle' => 'Comprobación de suma de regiones disjuntas (14+10+10+6=40 y 17+15+13+5=50) y cálculo porcentual.',
                'ev_4_detalle' => 'Reporte escrito explicando cómo la intersección evita registros duplicados en una consulta de base de datos.',
                'ev_5_detalle' => 'Socialización en pizarra vinculando las zonas del diagrama con los operadores lógicos AND, OR y NOT.',
                'ev_6_detalle' => 'Ficha de lógica y clasificación evaluada y registrada en el seguimiento del curso.',
                'logros_sesion' => 'Se consolidó la relación entre los Diagramas de Venn y las consultas condicionales WHERE en bases de datos.',
                'dificultades_sesion' => 'Al inicio, varios estudiantes colocaron 24 y 20 directamente sin restar la intersección; el gráfico visual en pizarra permitió corregir el error de inmediato.',
            ],
            [
                'numero_semana' => 4,
                'titulo' => 'Dimensionamiento de almacenamiento, conversión de unidades y autonomía de Servidor',
                'fecha_aplicacion' => '2026-10-15',
                'tiempo_minutos' => 30,
                'orientacion_didactica' => 'Adaptada de la Actividad 1 de Matemáticas (pág. 45, capacidad de almacenamiento, conversión de unidades y duración al 30%). Los estudiantes dimensionan un servidor de copias de seguridad (Backups) de 2 TB con generación diaria de 40.000 MB.',
                'habilidades' => 'Conversión de unidades informáticas (TB, GB, MB), cálculo de porcentajes de capacidad útil (30%) y modelización proporcional de autonomía en días y horas.',
                'planteamiento' => 'Servidor de Backups de 2 TB (1 TB = 1.000 GB; 1 GB = 1.000 MB). Flujo diario: 40.000 MB/día. Calcular capacidad en GB/MB, días de duración al 100% y horas de duración al 30% de espacio libre.',
                'solucionario_docente' => 'a) 2 TB = 2.000 GB = 2.000.000 MB; carga diaria = 40 GB/día. b) Al 100%: 2.000 / 40 = 50 días. c) Al 30% (600 GB libres): 600 / 40 = 15 días = 360 horas. Con compresión al 50% (20 GB/día): dura 30 días (720 horas).',
                'ev_1_detalle' => 'Esquema cilíndrico rotulado del servidor de 2 TB y tabla de equivalencias TB, GB y MB.',
                'ev_2_detalle' => 'Desarrollo algebraico de los tres incisos expresando unidades de capacidad y tiempo (días y horas).',
                'ev_3_detalle' => 'Indagación y verificación del impacto de un algoritmo de compresión (.zip al 50%) que duplica la autonomía a 30 días.',
                'ev_4_detalle' => 'Conclusión técnica escrita sobre la viabilidad del servidor y protocolo de mantenimiento recomendado.',
                'ev_5_detalle' => 'Sustentación oral de la cadena de factores de conversión de unidades en la pizarra.',
                'ev_6_detalle' => 'Informe integrador de cierre de ciclo calificado con nivel de logro final y retroalimentación.',
                'logros_sesion' => 'La mayoría del curso alcanzó autonomía en la conversión de unidades y en la interpretación física de los resultados para tomar decisiones preventivas.',
                'dificultades_sesion' => 'Se reforzó el factor de conversión de días a horas (× 24) en estudiantes que requerían apoyo medio.',
            ],
        ];

        foreach ($cursosData as $cData) {
            $curso = Curso::create([
                'nombre' => $cData['nombre'],
                'paralelo' => $cData['paralelo'],
                'area' => 'Técnica Tecnológica Especializada: Sistemas Informáticos',
                'capacidad' => 'Pensamiento Lógico - Matemático',
                'unidad_educativa' => 'Unidad Educativa',
                'distrito' => 'Dirección Distrital de Educación de Mineros (7036)',
                'docente' => 'Prof. de Sistemas Informáticos',
                'director' => 'Lic. Director/a de Unidad Educativa',
                'trimestre' => 'Tercer Trimestre - Gestión 2026',
                'diagnostico_curso' => $cData['diagnostico_curso'],
            ]);

            $actividadesCreadas = [];
            foreach ($actividadesPlantilla as $actData) {
                $fecha = new \DateTimeImmutable($actData['fecha_aplicacion']);
                $actividadesCreadas[$actData['numero_semana']] = Actividad::create(array_merge($actData, [
                    'curso_id' => $curso->id,
                    'mes' => (int) $fecha->format('n'),
                    'anio' => (int) $fecha->format('Y'),
                    'estado' => 'EJECUTADA',
                ]));
            }

            foreach ($cData['estudiantes'] as $idx => $estData) {
                $est = Estudiante::create([
                    'curso_id' => $curso->id,
                    'nombres_apellidos' => $estData['nombres'],
                    'rude' => $estData['rude'],
                    'diagnostico_inicial' => $estData['diag'],
                    'dificultad_detectada' => $estData['dif'],
                ]);

                // Simular progresión pedagógica realista a lo largo de las 4 semanas
                for ($sem = 1; $sem <= 4; $sem++) {
                    $act = $actividadesCreadas[$sem];

                    if ($estData['diag'] === 'INICIAL') {
                        // Progresa de INICIAL (Sem 1) -> EN_PROCESO (Sem 2 y 3) -> EN_PROCESO o LOGRADO (Sem 4)
                        if ($sem === 1) {
                            $nivel = 'INICIAL';
                            $apoyo = 'APOYO_ALTO';
                        } elseif ($sem <= 3) {
                            $nivel = 'EN_PROCESO';
                            $apoyo = 'APOYO_MEDIO';
                        } else {
                            $nivel = ($idx % 2 === 0) ? 'LOGRADO' : 'EN_PROCESO';
                            $apoyo = ($nivel === 'LOGRADO') ? 'APOYO_BAJO' : 'APOYO_MEDIO';
                        }
                    } elseif ($estData['diag'] === 'EN_PROCESO') {
                        // Progresa de EN_PROCESO (Sem 1 y 2) -> LOGRADO (Sem 3 y 4)
                        if ($sem <= 2) {
                            $nivel = 'EN_PROCESO';
                            $apoyo = 'APOYO_MEDIO';
                        } else {
                            $nivel = 'LOGRADO';
                            $apoyo = 'APOYO_BAJO';
                        }
                    } else {
                        $nivel = 'LOGRADO';
                        $apoyo = 'APOYO_BAJO';
                    }

                    $c1 = $nivel;
                    $c2 = $nivel;
                    $c3 = ($sem === 1 && $nivel === 'INICIAL') ? 'INICIAL' : $nivel;
                    $c4 = ($sem <= 2 && $nivel !== 'LOGRADO') ? 'INICIAL' : $nivel;

                    EvaluacionSemanal::create([
                        'actividad_id' => $act->id,
                        'estudiante_id' => $est->id,
                        'criterio_1' => $c1,
                        'criterio_2' => $c2,
                        'criterio_3' => $c3,
                        'criterio_4' => $c4,
                        'nivel_desempeno' => $nivel,
                        'andamiaje_aplicado' => $apoyo,
                        'ev_1' => true,
                        'ev_2' => true,
                        'ev_3' => true,
                        'ev_4' => true,
                        'ev_5' => ($sem === 1 && $nivel === 'INICIAL') ? false : true,
                        'ev_6' => true,
                        'retroalimentacion' => EvaluacionSemanal::generarRetroalimentacionAutomatica($nivel, $apoyo, $sem),
                    ]);
                }
            }
        }
    }
}
