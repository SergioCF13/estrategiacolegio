<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Panel de Administración — Estrategia Nacional 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 min-h-screen flex flex-col justify-between">

    <div class="flex h-2 w-full">
        <div class="flex-1 bg-red-600"></div>
        <div class="flex-1 bg-yellow-400"></div>
        <div class="flex-1 bg-green-700"></div>
    </div>

    <div class="flex-1 flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="bg-slate-800 p-6 text-center border-b border-slate-700">
                <div class="w-14 h-14 rounded-xl bg-amber-500 text-slate-950 font-black text-2xl flex items-center justify-center mx-auto mb-3 shadow-lg">
                    SI
                </div>
                <p class="text-[11px] uppercase tracking-widest text-amber-400 font-bold">
                    Dirección Distrital de Educación de Mineros (7036)
                </p>
                <h1 class="text-lg font-extrabold text-white mt-1">
                    Panel de Administración Docente
                </h1>
                <p class="text-xs text-slate-400 mt-0.5">
                    Estrategia Nacional de Fortalecimiento de Logro de Aprendizajes (2026)
                </p>
            </div>

            <div class="p-6 space-y-4">
                @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-600 text-red-800 p-3 rounded text-xs font-medium">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Correo del Administrador / Docente</label>
                        <input type="email" name="email" value="{{ old('email', 'admin@mineros.edu.bo') }}" required
                               class="w-full border border-slate-300 rounded-lg px-3.5 py-2 text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Contraseña</label>
                        <input type="password" name="password" value="12345678" required
                               class="w-full border border-slate-300 rounded-lg px-3.5 py-2 text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                    </div>

                    <div class="flex items-center justify-between text-xs text-slate-600">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" checked class="rounded text-amber-600">
                            <span>Mantener sesión activa</span>
                        </label>
                        <span class="text-slate-400">Clave local: <code>12345678</code></span>
                    </div>

                    <button type="submit"
                            class="w-full bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold py-2.5 rounded-lg shadow-md text-sm transition">
                        🔐 Ingresar al Panel de Administración
                    </button>
                </form>

                <div class="pt-3 border-t border-slate-100 text-center">
                    <a href="{{ route('estrategia.index') }}" class="text-xs text-slate-500 hover:text-slate-800 underline">
                        Ir directamente al Dashboard sin iniciar sesión →
                    </a>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-4 text-xs text-slate-500">
        Área: Técnica Tecnológica Especializada — Sistemas Informáticos (5.º y 6.º de Secundaria)
    </footer>
</body>
</html>
