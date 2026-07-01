<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión — DoubleTree by Hilton Trujillo</title>
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
                        navy:  { DEFAULT: '#1A3A5C', deep: '#0D2137', light: '#2A5080' },
                        gold:  { DEFAULT: '#C9AA71', light: '#D9C08F', dark: '#A8864A', pale: '#F2E8D0' },
                        ivory: { DEFAULT: '#F8F5EF', warm: '#F0EBE0' },
                    },
                    fontFamily: {
                        serif: ['Cormorant Garamond', 'Georgia', 'serif'],
                        sans:  ['Inter', 'system-ui', 'sans-serif'],
                    },
                    letterSpacing: {
                        widest2: '0.25em',
                        widest3: '0.35em',
                    },
                }
            }
        }
    </script>

    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; }

        /* ── Panel izquierdo ── */
        .panel-image {
            background-image:
                linear-gradient(to bottom,
                    rgba(13,33,55,0.30) 0%,
                    rgba(13,33,55,0.55) 50%,
                    rgba(13,33,55,0.90) 100%),
                url('https://dynamic-media-cdn.tripadvisor.com/media/photo-o/2b/33/b8/00/caption.jpg?w=1400&h=-1&s=1');
            background-size: cover;
            background-position: center top;
        }

        /* ── Inputs ── */
        .field-input {
            width: 100%;
            border: 1px solid #D9C08F;
            background: #FAFAF8;
            color: #1A3A5C;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            padding: 0.7rem 0.875rem 0.7rem 2.6rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .field-input:focus {
            border-color: #1A3A5C;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(26,58,92,0.10);
        }
        .field-input.error {
            border-color: #c0392b;
            background: #fff8f8;
            box-shadow: 0 0 0 3px rgba(192,57,43,0.08);
        }
        .field-icon {
            position: absolute;
            left: 0.8rem;
            top: 50%;
            transform: translateY(-50%);
            color: #C9AA71;
            font-size: 0.78rem;
            pointer-events: none;
        }
        .toggle-eye {
            position: absolute;
            right: 0.8rem;
            top: 50%;
            transform: translateY(-50%);
            color: #1A3A5C;
            opacity: 0.35;
            cursor: pointer;
            font-size: 0.78rem;
            transition: opacity 0.2s;
        }
        .toggle-eye:hover { opacity: 0.75; }

        /* ── Botón principal ── */
        .btn-login {
            width: 100%;
            background: #1A3A5C;
            color: #fff;
            font-size: 0.7rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            font-weight: 600;
            padding: 0.9rem 2rem;
            border: none;
            cursor: pointer;
            transition: background 0.2s, box-shadow 0.2s, transform 0.1s;
            position: relative;
            overflow: hidden;
        }
        .btn-login:hover  { background: #0D2137; box-shadow: 0 8px 28px rgba(13,33,55,0.28); }
        .btn-login:active { transform: scale(0.99); }
        .btn-login:disabled { background: #7a9bb5; cursor: not-allowed; }

        /* ── Alertas ── */
        .alert-error {
            background: #fff0ee;
            border-left: 3px solid #c0392b;
            color: #8b1a10;
            padding: 0.75rem 1rem;
            font-size: 0.8rem;
            margin-bottom: 1.25rem;
        }
        .alert-success {
            background: #f0fff7;
            border-left: 3px solid #C9AA71;
            color: #1A3A5C;
            padding: 0.75rem 1rem;
            font-size: 0.8rem;
            margin-bottom: 1.25rem;
        }
        .field-error-msg {
            font-size: 0.7rem;
            color: #c0392b;
            margin-top: 0.3rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        /* ── Checkbox ── */
        .custom-check {
            width: 15px;
            height: 15px;
            border: 1px solid #D9C08F;
            background: #FAFAF8;
            appearance: none;
            cursor: pointer;
            flex-shrink: 0;
            transition: all 0.2s;
        }
        .custom-check:checked {
            background: #1A3A5C;
            border-color: #1A3A5C;
        }
        .custom-check:checked::after {
            content: '✓';
            display: flex;
            align-items: center;
            justify-content: center;
            color: #C9AA71;
            font-size: 9px;
            height: 100%;
        }

        /* ── Spinner ── */
        @keyframes spin { to { transform: rotate(360deg); } }
        .spinner {
            width: 15px; height: 15px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            display: inline-block;
            vertical-align: middle;
            margin-right: 8px;
        }

        /* ── Shake animation para error ── */
        @keyframes shake {
            0%,100% { transform: translateX(0); }
            20%      { transform: translateX(-6px); }
            40%      { transform: translateX(6px); }
            60%      { transform: translateX(-4px); }
            80%      { transform: translateX(4px); }
        }
        .shake { animation: shake 0.4s ease; }

        /* ── Fade in ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.5s ease forwards; }

        /* ── Divider ── */
        .gold-divider {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 1.5rem 0;
        }
        .gold-divider::before,
        .gold-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #C9AA71;
            opacity: 0.30;
        }
    </style>
    {{-- Slot para scripts del componente navbar --}}
    @stack('scripts')
</head>
<body class="bg-ivory min-h-screen">

{{-- Navbar compartido — fondo navy sólido (no hay hero) --}}
<x-navbar :transparent="false" />

{{-- Spacer para compensar el navbar fijo --}}
<div style="height:72px;"></div>

<div class="min-h-screen flex">

    {{-- ══════════════════════════════
         LEFT: imagen decorativa
    ══════════════════════════════ --}}
    <div class="hidden lg:flex lg:w-5/12 xl:w-1/2 panel-image flex-col justify-between p-12 sticky top-0 h-screen">

        {{-- Logo --}}
        <a href="{{ route('welcome') }}" class="flex flex-col leading-none">
        </a>

        {{-- Quote central --}}
        <div>
            <blockquote class="font-serif text-white text-3xl font-light leading-snug italic mb-4">
                "Bienvenido de vuelta<br>a su lugar favorito"
            </blockquote>
            <p class="text-white/50 text-sm font-light max-w-xs leading-relaxed">
                Acceda a su cuenta para gestionar sus reservas, ver su historial y acceder a ofertas exclusivas.
            </p>
        </div>

        {{-- Beneficios de cuenta --}}
        <div class="space-y-4">
            <p class="text-white/35 text-[9px] tracking-widest3 uppercase">Beneficios de su cuenta</p>
            @foreach([
                ['fa-bookmark',       'Reservas guardadas y acceso rápido'],
                ['fa-tag',            'Tarifas exclusivas para miembros'],
                ['fa-clock-rotate-left', 'Historial completo de estancias'],
                ['fa-headset',        'Atención prioritaria al huésped'],
            ] as [$icon, $text])
            <div class="flex items-center gap-3">
                <div class="w-7 h-7 border border-gold/30 flex items-center justify-center flex-shrink-0">
                    <i class="fas {{ $icon }} text-gold text-[10px]"></i>
                </div>
                <span class="text-white/55 text-xs font-light">{{ $text }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ══════════════════════════════
         RIGHT: formulario
    ══════════════════════════════ --}}
    <div class="flex-1 flex flex-col justify-center px-6 sm:px-10 lg:px-14 xl:px-20 py-12 bg-ivory overflow-y-auto">

        {{-- Logo móvil --}}
        <div class="lg:hidden mb-8 text-center">
            <a href="{{ route('welcome') }}" class="inline-flex flex-col items-center leading-none">
                <span class="font-serif text-navy/50 text-[10px] tracking-widest2 uppercase">DoubleTree by</span>
                <span class="font-serif text-navy text-xl font-light tracking-wide">Hilton Trujillo</span>
                <span class="text-gold text-[9px] tracking-widest3 uppercase mt-0.5">Hotel & Suites</span>
            </a>
        </div>

        <div class="max-w-sm w-full mx-auto fade-up">

            {{-- Encabezado --}}
            <div class="mb-8">
                <p class="text-gold text-[9px] tracking-widest3 uppercase font-medium mb-2">Bienvenido</p>
                <h1 class="font-serif text-navy text-3xl sm:text-4xl font-light leading-tight">
                    Iniciar sesión
                </h1>
                <div class="flex items-center gap-2 mt-3">
                    <div class="h-px flex-1 bg-gold/30"></div>
                    <i class="fas fa-star text-gold text-[8px]"></i>
                    <div class="h-px flex-1 bg-gold/30"></div>
                </div>
                <p class="text-navy/45 text-sm font-light mt-3">
                    ¿Aún no tiene cuenta?
                    <a href="{{ route('registro') }}"
                       class="text-navy font-medium border-b border-gold hover:text-gold transition-colors duration-200">
                        Registrarse gratis
                    </a>
                </p>
            </div>

            {{-- ── Alertas Laravel ── --}}
            @if ($errors->has('email') || $errors->has('password') || $errors->has('credentials'))
            <div class="alert-error" id="alertError">
                <div class="flex items-center gap-2 font-medium mb-1">
                    <i class="fas fa-exclamation-circle"></i>
                    Credenciales incorrectas
                </div>
                <p>El correo o la contraseña ingresados no son válidos. Por favor verifique e intente nuevamente.</p>
            </div>
            @endif

            @if (session('success'))
            <div class="alert-success">
                <div class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-gold"></i>
                    {{ session('success') }}
                </div>
            </div>
            @endif

            @if (session('info'))
            <div class="alert-success">
                <div class="flex items-center gap-2">
                    <i class="fas fa-info-circle text-gold"></i>
                    {{ session('info') }}
                </div>
            </div>
            @endif

            {{-- ════════════════════
                 FORMULARIO
            ════════════════════ --}}
            <form id="loginForm"
                  method="POST"
                  action="{{ route('login') }}"
                  novalidate
                  class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email"
                           class="block text-[10px] tracking-widest uppercase text-navy/55 font-medium mb-1.5">
                        Correo Electrónico <span class="text-gold">*</span>
                    </label>
                    <div class="relative">
                        <i class="fas fa-envelope field-icon"></i>
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email') }}"
                               placeholder="correo@ejemplo.com"
                               autocomplete="email"
                               class="field-input {{ $errors->hasAny(['email','credentials']) ? 'error' : '' }}"
                               autofocus>
                    </div>
                    @error('email')
                        <p class="field-error-msg">
                            <i class="fas fa-circle-exclamation"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password"
                               class="block text-[10px] tracking-widest uppercase text-navy/55 font-medium">
                            Contraseña <span class="text-gold">*</span>
                        </label>
                        {{-- ¿Olvidaste contraseña? — descomenta si tienes esa ruta --}}
                        {{-- <a href="{{ route('password.request') }}"
                              class="text-[10px] text-navy/40 hover:text-gold border-b border-gold/0 hover:border-gold/50 transition-all duration-200">
                            ¿Olvidó su contraseña?
                        </a> --}}
                    </div>
                    <div class="relative">
                        <i class="fas fa-lock field-icon"></i>
                        <input type="password"
                               name="password"
                               id="password"
                               placeholder="Su contraseña"
                               autocomplete="current-password"
                               class="field-input pr-10 {{ $errors->hasAny(['password','credentials']) ? 'error' : '' }}">
                        <span class="toggle-eye" id="toggleEye" onclick="togglePass()">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </span>
                    </div>
                    @error('password')
                        <p class="field-error-msg">
                            <i class="fas fa-circle-exclamation"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Recordarme --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2.5 cursor-pointer group">
                        <input type="checkbox"
                               name="remember"
                               id="remember"
                               class="custom-check"
                               {{ old('remember') ? 'checked' : '' }}>
                        <span class="text-xs text-navy/55 group-hover:text-navy/75 transition-colors duration-200 select-none">
                            Recordar mi sesión
                        </span>
                    </label>

                    {{-- Indicador de seguridad --}}
                    <div class="flex items-center gap-1.5 text-[10px] text-navy/30">
                        <i class="fas fa-shield-halved text-gold/50"></i>
                        Conexión segura
                    </div>
                </div>

                {{-- Botón submit --}}
                <div class="pt-1">
                    <button type="submit"
                            class="btn-login"
                            id="submitBtn">
                        <span id="btnText">
                            <i class="fas fa-arrow-right-to-bracket mr-2 text-gold/70"></i>
                            Iniciar Sesión
                        </span>
                        <span id="btnLoading" class="hidden">
                            <span class="spinner"></span>Verificando credenciales…
                        </span>
                    </button>
                </div>

            </form>

            {{-- Divider --}}
            <div class="gold-divider">
                <span class="text-navy/30 text-[10px] tracking-widest uppercase">o</span>
            </div>

            {{-- CTA registro --}}
            <div class="bg-white border border-gold/25 p-5">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 bg-gold/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="fas fa-user-plus text-gold text-sm"></i>
                    </div>
                    <div>
                        <p class="font-serif text-navy text-base font-light mb-1">
                            Primera vez en el hotel
                        </p>
                        <p class="text-navy/50 text-xs leading-relaxed mb-3">
                            Cree su cuenta gratuita y acceda a tarifas exclusivas, historial de reservas y atención personalizada.
                        </p>
                        <a href="{{ route('registro') }}"
                           class="inline-block border border-navy hover:bg-navy hover:text-white text-navy text-[10px] tracking-widest uppercase px-5 py-2.5 transition-all duration-200">
                            Crear Cuenta Gratuita
                        </a>
                    </div>
                </div>
            </div>

            {{-- Trust badges --}}
            <div class="flex items-center justify-center gap-6 mt-7 text-navy/30">
                <div class="flex items-center gap-1.5 text-[10px]">
                    <i class="fas fa-shield-halved text-gold/55 text-sm"></i>
                    Datos seguros
                </div>
                <div class="flex items-center gap-1.5 text-[10px]">
                    <i class="fas fa-lock text-gold/55 text-sm"></i>
                    SSL Encriptado
                </div>
                <div class="flex items-center gap-1.5 text-[10px]">
                    <i class="fas fa-user-shield text-gold/55 text-sm"></i>
                    Privacidad
                </div>
            </div>

            {{-- Volver al inicio --}}
            <p class="text-center mt-7 text-navy/30 text-xs">
                <a href="{{ route('welcome') }}"
                   class="hover:text-gold transition-colors duration-200">
                    <i class="fas fa-arrow-left text-[10px] mr-1"></i>Volver al inicio
                </a>
            </p>

        </div>
    </div>
</div>

{{-- ══════════════════════════════
     SCRIPTS
══════════════════════════════ --}}
<script>
/* ── Toggle contraseña visible ── */
function togglePass() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('eyeIcon');
    const btn   = document.getElementById('toggleEye');
    if (input.type === 'password') {
        input.type   = 'text';
        icon.className = 'fas fa-eye-slash';
        btn.style.opacity = '0.7';
    } else {
        input.type   = 'password';
        icon.className = 'fas fa-eye';
        btn.style.opacity = '0.35';
    }
}

/* ── Submit: validación cliente + loading state ── */
function handleSubmit(e) {
    const email    = document.getElementById('email');
    const password = document.getElementById('password');
    let   valid    = true;

    // Reset
    [email, password].forEach(f => {
        f.classList.remove('error');
    });

    // Validar email
    if (!email.value.trim()) {
        markError(email, 'El correo es obligatorio.');
        valid = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
        markError(email, 'Ingrese un correo válido.');
        valid = false;
    }

    // Validar password
    if (!password.value) {
        markError(password, 'La contraseña es obligatoria.');
        valid = false;
    }

    if (!valid) {
        e.preventDefault();
        // Shake en el botón
        const btn = document.getElementById('submitBtn');
        btn.classList.add('shake');
        btn.addEventListener('animationend', () => btn.classList.remove('shake'), { once: true });
        return;
    }

    // Loading state
    document.getElementById('btnText').classList.add('hidden');
    const loading = document.getElementById('btnLoading');
    loading.classList.remove('hidden');
    loading.style.display = 'inline-flex';
    loading.style.alignItems = 'center';
    loading.style.justifyContent = 'center';
    loading.style.gap = '6px';
    document.getElementById('submitBtn').disabled = true;
}

function markError(input, msg) {
    input.classList.add('error');
    // Insertar mensaje si no existe
    const existing = input.closest('div').parentElement.querySelector('.field-error-msg.js-err');
    if (!existing) {
        const p = document.createElement('p');
        p.className = 'field-error-msg js-err';
        p.innerHTML = `<i class="fas fa-circle-exclamation"></i> ${msg}`;
        input.closest('div').insertAdjacentElement('afterend', p);
    }
}

/* ── Auto-focus al cargar ── */
document.addEventListener('DOMContentLoaded', () => {
    const emailField = document.getElementById('email');
    if (emailField && !emailField.value) emailField.focus();

    // Si hay error de Laravel, hacer shake visible
    @if($errors->any())
        const form = document.getElementById('loginForm');
        if (form) {
            form.classList.add('shake');
            form.addEventListener('animationend', () => form.classList.remove('shake'), { once: true });
        }
    @endif
});
</script>

</body>
</html>