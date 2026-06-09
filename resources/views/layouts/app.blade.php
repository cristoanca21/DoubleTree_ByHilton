<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DoubleTree by Hilton Trujillo')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .doubletree-gold { color: #C9AA71; }
        .bg-doubletree-gold { background-color: #C9AA71; }
        .bg-doubletree-navy { background-color: #1A3A5C; }
        .border-doubletree-gold { border-color: #C9AA71; }
        .hover\:bg-doubletree-gold:hover { background-color: #B8974F; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

{{-- NAVBAR --}}
<nav class="bg-doubletree-navy shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <a href="{{ route('habitaciones.index') }}" class="flex items-center gap-3">
                <span class="text-white font-bold text-xl tracking-wide">DoubleTree</span>
                <span class="doubletree-gold font-light text-sm">by Hilton Trujillo</span>
            </a>
            <div class="flex items-center gap-4">
                <a href="{{ route('habitaciones.index') }}"
                   class="text-gray-300 hover:text-white text-sm transition">
                    Habitaciones
                </a>
                @auth('cliente')
                    <a href="{{ route('reservas.index') }}"
                       class="text-gray-300 hover:text-white text-sm transition">
                        Mis reservas
                    </a>
                    @if(Auth::guard('cliente')->user()->esAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                           class="doubletree-gold hover:text-yellow-300 text-sm transition">
                            Panel Admin
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline" id="form-logout">
    @csrf
    <button type="button" onclick="confirmarLogout()"
            class="bg-doubletree-gold text-white px-4 py-2 rounded text-sm hover:bg-yellow-600 transition">
        Cerrar sesión
    </button>
</form>

{{-- Modal confirmación logout --}}
<div id="modal-logout"
     class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-sm w-full mx-4">
        <div class="text-center">
            <div class="bg-red-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                <i class="fa fa-right-from-bracket text-2xl text-red-500"></i>
            </div>
            <h3 class="text-lg font-bold text-doubletree-navy mb-2">
                ¿Cerrar sesión?
            </h3>
            <p class="text-gray-500 text-sm mb-6">
                Tu sesión actual se cerrará. ¿Estás seguro que deseas salir?
            </p>
            <div class="flex gap-3">
                <button onclick="cerrarModal()"
                        class="flex-1 bg-gray-100 text-gray-600 py-2.5 rounded-lg font-medium hover:bg-gray-200 transition text-sm">
                    Cancelar
                </button>
                <button onclick="document.getElementById('form-logout').submit()"
                        class="flex-1 bg-red-500 text-white py-2.5 rounded-lg font-medium hover:bg-red-600 transition text-sm">
                    Sí, cerrar sesión
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function confirmarLogout() {
    document.getElementById('modal-logout').classList.remove('hidden');
}
function cerrarModal() {
    document.getElementById('modal-logout').classList.add('hidden');
}
// Cerrar con Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') cerrarModal();
});
// Cerrar click fuera del modal
document.getElementById('modal-logout').addEventListener('click', function(e) {
    if (e.target === this) cerrarModal();
});
</script>
                @else
                    <a href="{{ route('login') }}"
                       class="text-gray-300 hover:text-white text-sm transition">
                        Iniciar sesión
                    </a>
                    <a href="{{ route('registro') }}"
                       class="bg-doubletree-gold text-white px-4 py-2 rounded text-sm hover:bg-doubletree-gold transition">
                        Registrarse
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- ALERTAS --}}
<div class="max-w-7xl mx-auto px-4 pt-4 w-full">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4">
            <i class="fa fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded mb-4">
            <i class="fa fa-exclamation-circle mr-2"></i>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

{{-- CONTENIDO --}}
<main class="flex-1">
    @yield('content')
</main>

{{-- FOOTER --}}
<footer class="bg-doubletree-navy text-gray-400 text-center py-6 mt-8">
    <p class="text-sm">© {{ date('Y') }} DoubleTree by Hilton Trujillo. Todos los derechos reservados.</p>
    <p class="text-xs mt-1 doubletree-gold">Av. El Golf 591, Trujillo, Perú</p>
</footer>

</body>
</html>
