@extends('layouts.app')
@section('title', 'Crear Cuenta')

@section('content')
<div class="min-h-screen flex">

    {{-- ══ PANEL IZQUIERDO ══ --}}
    <div class="hidden lg:flex lg:w-5/12 relative flex-col justify-between"
         style="background: #1A3A5C;
                background-image: url('{{ asset('images/hotel.jpg') }}');
                background-size: cover;
                background-position: center;">

        {{-- Overlay oscuro --}}
        <div class="absolute inset-0" style="background: rgba(15,28,45,0.72);"></div>

        {{-- Contenido sobre el overlay --}}
        <div class="relative z-10 p-10 flex flex-col h-full justify-between">

            {{-- Logo --}}
            <div>
                <p class="text-xs tracking-widest uppercase mb-1" style="color:#C9AA71">DoubleTree by</p>
                <h1 class="text-3xl font-light text-white tracking-wide">Hilton Trujillo</h1>
                <p class="text-xs tracking-widest uppercase mt-1" style="color:#8aabb5">Hotel & Suites</p>
                <div class="mt-4 w-10 h-px" style="background:#C9AA71"></div>
            </div>

            {{-- Mensaje central --}}
            <div>
                <h2 class="text-2xl font-light text-white leading-snug mb-4">
                    Bienvenido a una <br>
                    <span style="color:#C9AA71">experiencia única</span><br>
                    en Trujillo
                </h2>
                <p class="text-sm leading-relaxed" style="color:#8aabb5">
                    Crea tu cuenta y accede a tarifas exclusivas,
                    historial de reservas y beneficios para
                    huéspedes frecuentes.
                </p>
            </div>

            {{-- Tipos de habitación --}}
            <div class="space-y-3">
                <p class="text-xs tracking-widest uppercase mb-3" style="color:#C9AA71">
                    Nuestras habitaciones
                </p>
                @php
                    $tipos = \App\Models\TipoHabitacion::all();
                @endphp
                @foreach($tipos as $tipo)
                    <div class="flex items-center justify-between py-2 border-b"
                         style="border-color: rgba(255,255,255,0.1)">
                        <div>
                            <p class="text-sm font-medium text-white">{{ $tipo->nombre }}</p>
                            <p class="text-xs" style="color:#8aabb5">
                                Hasta {{ $tipo->capacidad }} personas
                            </p>
                        </div>
                        <p class="text-sm font-semibold" style="color:#C9AA71">
                            S/ {{ number_format($tipo->precio_noche, 2) }}
                            <span class="text-xs font-normal" style="color:#8aabb5">/noche</span>
                        </p>
                    </div>
                @endforeach
            </div>

            {{-- Footer --}}
            <p class="text-xs" style="color:#8aabb5">
                © {{ date('Y') }} DoubleTree by Hilton Trujillo
            </p>
        </div>
    </div>

    {{-- ══ PANEL DERECHO: FORMULARIO ══ --}}
    <div class="w-full lg:w-7/12 flex items-center justify-center px-6 py-12 bg-gray-50">
        <div class="w-full max-w-lg">

            {{-- Header --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold mb-1" style="color:#1A3A5C">Crear cuenta</h2>
                <p class="text-sm text-gray-500">Completa los datos para registrarte</p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-6 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('registro') }}" autocomplete="off" class="space-y-4">
                @csrf

                {{-- Nombre y Apellido --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">
                            Nombre
                        </label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}" required
                               autocomplete="off" placeholder="Ej: Carlos"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:border-transparent"
                               style="focus:ring-color:#1A3A5C">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">
                            Apellido
                        </label>
                        <input type="text" name="apellido" value="{{ old('apellido') }}" required
                               autocomplete="off" placeholder="Ej: López"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:border-transparent">
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">
                        Correo electrónico
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           autocomplete="new-password" placeholder="correo@ejemplo.com"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:border-transparent">
                </div>

                {{-- Tipo de documento --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">
                        Tipo de documento
                    </label>
                    <div class="grid grid-cols-3 gap-2" id="tipo-doc-btns">
                        @foreach(['DNI','Pasaporte','Carnet de extranjería'] as $tipo)
                            <button type="button"
                                    onclick="selDoc('{{ $tipo }}')"
                                    data-tipo="{{ $tipo }}"
                                    class="tipo-btn py-2 px-3 rounded-xl text-xs font-medium border transition
                                           {{ old('tipo_documento') == $tipo ? 'border-navy bg-navy text-white' : 'border-gray-200 bg-white text-gray-600 hover:border-gray-400' }}">
                                {{ $tipo }}
                            </button>
                        @endforeach
                    </div>
                    <input type="hidden" name="tipo_documento" id="tipo_documento_input"
                           value="{{ old('tipo_documento', 'DNI') }}">
                </div>

                {{-- Número de documento --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">
                        Número de documento
                    </label>
                    <input type="text" name="dni" id="num_documento"
                           value="{{ old('dni') }}" required autocomplete="off"
                           placeholder="Ej: 12345678" maxlength="8"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:border-transparent">
                    <p class="text-xs text-gray-400 mt-1" id="hint_documento">
                        DNI: exactamente 8 dígitos numéricos
                    </p>
                </div>

                {{-- Nacionalidad --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">
                        Nacionalidad
                    </label>
                    <select name="nacionalidad" required
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:border-transparent">
                        <option value="" disabled {{ old('nacionalidad') ? '' : 'selected' }}>
                            Selecciona tu nacionalidad
                        </option>
                        @php
                        $nacionalidades = [
                            'Peruana','Argentina','Boliviana','Brasileña','Chilena',
                            'Colombiana','Cubana','Ecuatoriana','Española','Estadounidense',
                            'Francesa','Guatemalteca','Italiana','Japonesa','Mexicana',
                            'Panameña','Paraguaya','Uruguaya','Venezolana','Alemana',
                            'Australiana','Canadiense','China','Coreana','Portuguesa',
                            'Rusa','Turca','Otra',
                        ];
                        @endphp
                        @foreach($nacionalidades as $nac)
                            <option value="{{ $nac }}"
                                {{ old('nacionalidad') == $nac ? 'selected' : '' }}>
                                {{ $nac }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Contraseña --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">
                            Contraseña
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="pw1" required
                                   minlength="8" autocomplete="new-password"
                                   placeholder="Mínimo 8 caracteres"
                                   class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:border-transparent pr-10">
                            <button type="button" onclick="togglePw('pw1','eye1')"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="fa fa-eye text-sm" id="eye1"></i>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">
                            Confirmar
                        </label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="pw2"
                                   required autocomplete="new-password"
                                   placeholder="Repite tu contraseña"
                                   class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:border-transparent pr-10">
                            <button type="button" onclick="togglePw('pw2','eye2')"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="fa fa-eye text-sm" id="eye2"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Botón --}}
                <button type="submit"
                        class="w-full py-3 rounded-xl text-sm font-semibold text-white tracking-wide transition hover:opacity-90 mt-2"
                        style="background:#1A3A5C">
                    Crear cuenta
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" class="font-semibold hover:underline"
                   style="color:#C9AA71">
                    Inicia sesión
                </a>
            </p>
        </div>
    </div>
</div>

<style>
.tipo-btn.activo {
    background: #1A3A5C !important;
    color: #fff !important;
    border-color: #1A3A5C !important;
}
</style>

<script>
const docConfig = {
    'DNI':                  { max: 8,  ph: 'Ej: 12345678',  hint: 'Exactamente 8 dígitos numéricos' },
    'Pasaporte':            { max: 20, ph: 'Ej: AB123456',  hint: 'Hasta 20 caracteres alfanuméricos' },
    'Carnet de extranjería':{ max: 12, ph: 'Ej: 000123456', hint: 'Hasta 12 caracteres' },
};

function selDoc(tipo) {
    document.querySelectorAll('.tipo-btn').forEach(b => b.classList.remove('activo'));
    document.querySelectorAll(`[data-tipo="${tipo}"]`).forEach(b => b.classList.add('activo'));
    document.getElementById('tipo_documento_input').value = tipo;
    const cfg = docConfig[tipo] || docConfig['DNI'];
    const inp = document.getElementById('num_documento');
    inp.maxLength   = cfg.max;
    inp.placeholder = cfg.ph;
    inp.value       = '';
    document.getElementById('hint_documento').textContent = cfg.hint;
}

function togglePw(id, ico) {
    const inp  = document.getElementById(id);
    const icon = document.getElementById(ico);
    const show = inp.type === 'password';
    inp.type       = show ? 'text' : 'password';
    icon.className = show ? 'fa fa-eye-slash text-sm' : 'fa fa-eye text-sm';
}

// Activar DNI por defecto
document.addEventListener('DOMContentLoaded', () => {
    const inicial = document.getElementById('tipo_documento_input').value || 'DNI';
    selDoc(inicial);
});
</script>
@endsection