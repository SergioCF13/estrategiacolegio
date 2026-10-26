<?php

use App\Http\Controllers\EstrategiaController;
use Illuminate\Support\Facades\Route;

// Autenticación del Panel de Administración
Route::get('/login', [EstrategiaController::class, 'showLogin'])->name('login');
Route::post('/login', [EstrategiaController::class, 'login'])->name('login.post');
Route::post('/logout', [EstrategiaController::class, 'logout'])->name('logout');

// Dashboard Principal y Módulos del Panel de Administración
Route::get('/', [EstrategiaController::class, 'index'])->name('estrategia.index');
Route::get('/admin', [EstrategiaController::class, 'index'])->name('estrategia.admin.dashboard');

// 1. Módulo Admin: CRUD de Cursos (Crear, Ver, Editar, Eliminar)
Route::get('/admin/cursos', [EstrategiaController::class, 'adminCursos'])->name('estrategia.admin.cursos');
Route::post('/admin/cursos', [EstrategiaController::class, 'crearCurso'])->name('estrategia.curso.crear');
Route::post('/cursos/{curso}/actualizar', [EstrategiaController::class, 'actualizarCurso'])->name('estrategia.curso.actualizar');
Route::delete('/admin/cursos/{curso}', [EstrategiaController::class, 'eliminarCurso'])->name('estrategia.curso.eliminar');

// 2. Módulo Admin: Gestión de Actividades y 6 Evidencias (Texto + Imágenes + Videos)
Route::get('/admin/actividades', [EstrategiaController::class, 'adminActividades'])->name('estrategia.admin.actividades');
Route::post('/admin/actividades/{actividad}', [EstrategiaController::class, 'guardarActividad'])->name('estrategia.actividad.guardar');
Route::post('/admin/actividades/{actividad}/subir-evidencia', [EstrategiaController::class, 'subirArchivoEvidencia'])->name('estrategia.evidencia.subir');
Route::delete('/admin/evidencias/{archivo}', [EstrategiaController::class, 'eliminarArchivoEvidencia'])->name('estrategia.evidencia.eliminar');

// 3. Módulo Admin: CRUD de Estudiantes (Registrar con su Curso, Ver, Editar, Eliminar, Importar)
Route::get('/admin/estudiantes', [EstrategiaController::class, 'adminEstudiantes'])->name('estrategia.admin.estudiantes');
Route::post('/admin/estudiantes/crear', [EstrategiaController::class, 'crearEstudianteIndividual'])->name('estrategia.estudiantes.crear');
Route::post('/cursos/{curso}/importar-estudiantes', [EstrategiaController::class, 'importarEstudiantes'])->name('estrategia.estudiantes.importar');
Route::post('/admin/estudiantes/{estudiante}/actualizar', [EstrategiaController::class, 'actualizarEstudiante'])->name('estrategia.estudiantes.actualizar');
Route::delete('/estudiantes/{estudiante}', [EstrategiaController::class, 'eliminarEstudiante'])->name('estrategia.estudiantes.eliminar');

// 4. Módulo Admin: Evaluación y Checklist por Semana
Route::get('/cursos/{curso}/semana/{semana}', [EstrategiaController::class, 'evaluarSemana'])->name('estrategia.evaluar');
Route::post('/cursos/{curso}/semana/{semana}', [EstrategiaController::class, 'guardarEvaluacionSemana'])->name('estrategia.evaluar.guardar');

// 5. Módulo Admin: Centro de Reportes y Exportación PDF
Route::get('/admin/reportes', [EstrategiaController::class, 'adminReportes'])->name('estrategia.admin.reportes');
Route::get('/cursos/{curso}/pdf-informe-general', [EstrategiaController::class, 'pdfInformeGeneralCurso'])->name('estrategia.pdf.curso');
Route::get('/cursos/{curso}/pdf-informes-estudiantes', [EstrategiaController::class, 'pdfInformesEstudiantesCurso'])->name('estrategia.pdf.estudiantes');
Route::get('/estudiantes/{estudiante}/pdf-informe-individual', [EstrategiaController::class, 'pdfInformeIndividualEstudiante'])->name('estrategia.pdf.estudiante.individual');
