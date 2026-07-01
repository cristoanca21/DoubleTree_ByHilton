<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Crear Cuenta — DoubleTree by Hilton Trujillo</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v={{ time() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy:  { DEFAULT: '#1A3A5C', deep: '#0D2137' },
                        gold:  { DEFAULT: '#C9AA71', dark: '#A8864A' },
                        ivory: { DEFAULT: '#F8F5EF' },
                    },
                    fontFamily: {
                        serif: ['Cormorant Garamond', 'Georgia', 'serif'],
                        sans:  ['Inter', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .panel-image {
            background-image:
                linear-gradient(to bottom, rgba(13,33,55,0.45) 0%, rgba(13,33,55,0.75) 100%),
                url('https://dynamic-media-cdn.tripadvisor.com/media/photo-o/33/9b/ee/9f/recreational-facility.jpg?w=1400&h=-1&s=1');
            background-size: cover;
            background-position: center;
        }
        .field-input {
            width: 100%;
            border: 1px solid #D9C08F;
            background: #FAFAF8;
            color: #1A3A5C;
            font-size: 0.875rem;
            padding: 0.65rem 0.875rem 0.65rem 2.4rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-family: 'Inter', sans-serif;
        }
        .field-input:focus {
            border-color: #1A3A5C;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(26,58,92,0.10);
        }
        .field-input.has-error { border-color: #c0392b; background: #fff8f8; }
        .field-icon {
            position: absolute; left: 0.75rem; top: 50%;
            transform: translateY(-50%);
            color: #C9AA71; font-size: 0.78rem; pointer-events: none;
        }
        .toggle-pw {
            position: absolute; right: 0.75rem; top: 50%;
            transform: translateY(-50%);
            color: #1A3A5C; opacity: 0.4; cursor: pointer; font-size: 0.78rem;
        }
        .toggle-pw:hover { opacity: 0.8; }
        .btn-primary {
            width: 100%; background: #1A3A5C; color: #fff;
            font-size: 0.7rem; letter-spacing: 0.18em; text-transform: uppercase;
            font-weight: 600; padding: 0.9rem 2rem; border: none; cursor: pointer;
            transition: background 0.2s, box-shadow 0.2s;
        }
        .btn-primary:hover { background: #0D2137; box-shadow: 0 8px 24px rgba(13,33,55,0.25); }
        .field-err { font-size: 0.7rem; color: #c0392b; margin-top: 0.2rem; }
        .alert-err {
            background: #fff0ee; border-left: 3px solid #c0392b;
            color: #8b1a10; padding: 0.75rem 1rem; font-size: 0.8rem; margin-bottom: 1.25rem;
        }
    </style>
    @stack('scripts')
</head>
<body class="bg-ivory min-h-screen">

<x-navbar :transparent="false" />
<div style="height:72px;"></div>

<div class="min-h-screen flex">

    {{-- Panel izquierdo --}}
    <div class="hidden lg:flex lg:w-5/12 xl:w-1/2 panel-image flex-col justify-between p-12 sticky top-0 h-screen">
        <a href="{{ route('welcome') }}" class="flex flex-col leading-none">
        </a>
        <div>
            <blockquote class="font-serif text-white text-3xl font-light leading-snug italic mb-4">
                "Su viaje al norte<br>del Perú comienza aquí"
            </blockquote>
            <p class="text-white/55 text-sm font-light max-w-xs leading-relaxed">
                Cree su cuenta y acceda a tarifas exclusivas, historial de reservas y atención personalizada.
            </p>
        </div>
        <div class="grid grid-cols-3 gap-4 border-t border-white/15 pt-8">
            @foreach([['147','Habitaciones'],['★ 5','Estrellas'],['24/7','Soporte']] as [$v,$l])
            <div>
                <div class="font-serif text-xl font-light" style="color:#C9AA71">{{ $v }}</div>
                <div class="text-white/45 text-[9px] uppercase mt-0.5" style="letter-spacing:.1em">{{ $l }}</div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Panel derecho: formulario --}}
    <div class="flex-1 flex flex-col justify-center px-6 sm:px-10 lg:px-14 xl:px-20 py-12 bg-ivory overflow-y-auto">

        <div class="max-w-md w-full mx-auto">

            {{-- Header --}}
            <div class="mb-7">
                <p class="text-[9px] uppercase font-medium mb-2" style="color:#C9AA71;letter-spacing:.35em">Bienvenido</p>
                <h1 class="font-serif text-navy text-3xl sm:text-4xl font-light">Crear su cuenta</h1>
                <div class="flex items-center gap-2 mt-3">
                    <div class="h-px flex-1" style="background:rgba(201,170,113,.3)"></div>
                    <i class="fas fa-star text-[8px]" style="color:#C9AA71"></i>
                    <div class="h-px flex-1" style="background:rgba(201,170,113,.3)"></div>
                </div>
                <p class="text-navy/50 text-sm font-light mt-3">
                    ¿Ya tiene una cuenta?
                    <a href="{{ route('login') }}" class="text-navy font-medium border-b hover:text-gold transition-colors" style="border-color:#C9AA71">
                        Iniciar sesión
                    </a>
                </p>
            </div>

            {{-- Errores Laravel --}}
            @if($errors->any())
            <div class="alert-err">
                <div class="flex items-center gap-2 font-medium mb-1">
                    <i class="fas fa-exclamation-circle"></i> Corrija los siguientes errores:
                </div>
                <ul class="list-disc pl-4 space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- FORMULARIO --}}
            <form method="POST" action="{{ route('registro') }}" class="space-y-4">
                @csrf

                {{-- Nombre y Apellido --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] uppercase font-medium mb-1.5" style="color:rgba(26,58,92,.6);letter-spacing:.05em">
                            Nombre <span style="color:#C9AA71">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-user field-icon"></i>
                            <input type="text" name="nombre" value="{{ old('nombre') }}"
                                   placeholder="Carlos" required autocomplete="given-name"
                                   class="field-input {{ $errors->has('nombre') ? 'has-error' : '' }}">
                        </div>
                        @error('nombre')<p class="field-err">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase font-medium mb-1.5" style="color:rgba(26,58,92,.6);letter-spacing:.05em">
                            Apellido <span style="color:#C9AA71">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-user field-icon"></i>
                            <input type="text" name="apellido" value="{{ old('apellido') }}"
                                   placeholder="Rodríguez" required autocomplete="family-name"
                                   class="field-input {{ $errors->has('apellido') ? 'has-error' : '' }}">
                        </div>
                        @error('apellido')<p class="field-err">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-[10px] uppercase font-medium mb-1.5" style="color:rgba(26,58,92,.6);letter-spacing:.05em">
                        Correo electrónico <span style="color:#C9AA71">*</span>
                    </label>
                    <div class="relative">
                        <i class="fas fa-envelope field-icon"></i>
                        <input type="email" name="email" value="{{ old('email') }}"
                               placeholder="correo@ejemplo.com" required autocomplete="new-password"
                               class="field-input {{ $errors->has('email') ? 'has-error' : '' }}">
                    </div>
                    @error('email')<p class="field-err">{{ $message }}</p>@enderror
                </div>

                {{-- Tipo de documento --}}
                <div>
                    <label class="block text-[10px] uppercase font-medium mb-1.5" style="color:rgba(26,58,92,.6);letter-spacing:.05em">
                        Tipo de documento <span style="color:#C9AA71">*</span>
                    </label>
                    <div class="flex gap-2">
                        @foreach(['DNI','Pasaporte','Carnet de extranjería'] as $tipo)
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="tipo_documento" value="{{ $tipo }}"
                                   class="sr-only peer"
                                   {{ old('tipo_documento','DNI') === $tipo ? 'checked' : '' }}>
                            <span class="block text-center text-[9px] uppercase py-2.5 border transition-all duration-200 peer-checked:text-white peer-checked:border-navy"
                                  style="letter-spacing:.05em;border-color:rgba(201,170,113,.4);color:rgba(26,58,92,.6)"
                                  id="tipo-label-{{ $loop->index }}"
                                  onclick="this.closest('label').querySelector('input').checked=true;updateDocLabel()">
                                {{ $tipo }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                    @error('tipo_documento')<p class="field-err">{{ $message }}</p>@enderror
                </div>

                {{-- Número de documento --}}
                <div>
                    <label class="block text-[10px] uppercase font-medium mb-1.5" style="color:rgba(26,58,92,.6);letter-spacing:.05em">
                        Número de documento <span style="color:#C9AA71">*</span>
                    </label>
                    <div class="relative">
                        <i class="fas fa-id-card field-icon"></i>
                        <input type="text" name="dni" id="dni" value="{{ old('dni') }}"
                               placeholder="Ej: 12345678" required autocomplete="off" maxlength="20"
                               class="field-input {{ $errors->has('dni') ? 'has-error' : '' }}">
                    </div>
                    <p class="text-[10px] mt-1" id="dniHint" style="color:rgba(26,58,92,.4)">
                        DNI: exactamente 8 dígitos numéricos
                    </p>
                    @error('dni')<p class="field-err">{{ $message }}</p>@enderror
                </div>

                {{-- Teléfono y Nacionalidad --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] uppercase font-medium mb-1.5" style="color:rgba(26,58,92,.6);letter-spacing:.05em">
                            Teléfono
                        </label>
                        <div class="relative">
                            <i class="fas fa-phone field-icon"></i>
                            <input type="tel" name="telefono" value="{{ old('telefono') }}"
                                   placeholder="987 654 321" autocomplete="tel"
                                   class="field-input {{ $errors->has('telefono') ? 'has-error' : '' }}">
                        </div>
                        @error('telefono')<p class="field-err">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase font-medium mb-1.5" style="color:rgba(26,58,92,.6);letter-spacing:.05em">
                            Nacionalidad <span style="color:#C9AA71">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-flag field-icon"></i>
                            <select name="nacionalidad" required
                                    class="field-input {{ $errors->has('nacionalidad') ? 'has-error' : '' }}">
                                @php $paises = ['Peruana','Argentina','Boliviana','Brasileña','Chilena',
                                    'Colombiana','Ecuatoriana','Española','Estadounidense','Francesa',
                                    'Italiana','Mexicana','Panameña','Paraguaya','Uruguaya','Venezolana','Otra']; @endphp
                                @foreach($paises as $pais)
                                <option value="{{ $pais }}" {{ old('nacionalidad','Peruana') === $pais ? 'selected':'' }}>
                                    {{ $pais }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('nacionalidad')<p class="field-err">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Contraseña --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] uppercase font-medium mb-1.5" style="color:rgba(26,58,92,.6);letter-spacing:.05em">
                            Contraseña <span style="color:#C9AA71">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-lock field-icon"></i>
                            <input type="password" name="password" id="pw1" required
                                   placeholder="Mínimo 8 caracteres" autocomplete="new-password"
                                   class="field-input pr-10 {{ $errors->has('password') ? 'has-error' : '' }}">
                            <span class="toggle-pw" onclick="togglePw('pw1','eye1')">
                                <i class="fas fa-eye" id="eye1"></i>
                            </span>
                        </div>
                        @error('password')<p class="field-err">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase font-medium mb-1.5" style="color:rgba(26,58,92,.6);letter-spacing:.05em">
                            Confirmar <span style="color:#C9AA71">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-lock field-icon"></i>
                            <input type="password" name="password_confirmation" id="pw2" required
                                   placeholder="Repita su contraseña" autocomplete="new-password"
                                   class="field-input pr-10">
                            <span class="toggle-pw" onclick="togglePw('pw2','eye2')">
                                <i class="fas fa-eye" id="eye2"></i>
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Botón --}}
                <div class="pt-2">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-check mr-2" style="color:rgba(201,170,113,.8)"></i>
                        Crear cuenta
                    </button>
                </div>
            </form>

            {{-- Footer --}}
            <div class="flex items-center justify-center gap-6 mt-7" style="color:rgba(26,58,92,.35)">
                <span class="flex items-center gap-1.5 text-[10px]">
                    <i class="fas fa-shield-halved text-sm" style="color:rgba(201,170,113,.6)"></i>Datos seguros
                </span>
                <span class="flex items-center gap-1.5 text-[10px]">
                    <i class="fas fa-lock text-sm" style="color:rgba(201,170,113,.6)"></i>SSL Encriptado
                </span>
            </div>

            <p class="text-center mt-6 text-xs" style="color:rgba(26,58,92,.35)">
                <a href="{{ route('welcome') }}" class="hover:text-gold transition-colors">
                    <i class="fas fa-arrow-left text-[10px] mr-1"></i>Volver al inicio
                </a>
            </p>
        </div>
    </div>
</div>

<script>
function togglePw(id, ico) {
    const inp  = document.getElementById(id);
    const icon = document.getElementById(ico);
    const show = inp.type === 'password';
    inp.type       = show ? 'text' : 'password';
    icon.className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
}

function updateDocLabel() {
    const checked = document.querySelector('input[name="tipo_documento"]:checked');
    const hint    = document.getElementById('dniHint');
    const dni     = document.getElementById('dni');
    if (!checked) return;
    const configs = {
        'DNI':                   { max: 8,  ph: 'Ej: 12345678', hint: 'DNI: exactamente 8 dígitos numéricos' },
        'Pasaporte':             { max: 20, ph: 'Ej: AB123456', hint: 'Pasaporte: hasta 20 caracteres' },
        'Carnet de extranjería': { max: 12, ph: 'Ej: 000123456', hint: 'Carnet: hasta 12 caracteres' },
    };
    const cfg = configs[checked.value] || configs['DNI'];
    dni.maxLength   = cfg.max;
    dni.placeholder = cfg.ph;
    hint.textContent = cfg.hint;
    // Resaltar seleccionado
    document.querySelectorAll('input[name="tipo_documento"]').forEach(r => {
        const span = r.nextElementSibling;
        if (r.checked) {
            span.style.background   = '#1A3A5C';
            span.style.color        = '#fff';
            span.style.borderColor  = '#1A3A5C';
        } else {
            span.style.background  = '';
            span.style.color       = 'rgba(26,58,92,.6)';
            span.style.borderColor = 'rgba(201,170,113,.4)';
        }
    });
}

document.querySelectorAll('input[name="tipo_documento"]').forEach(r => {
    r.addEventListener('change', updateDocLabel);
});

document.addEventListener('DOMContentLoaded', updateDocLabel);
</script>

</body>
</html>