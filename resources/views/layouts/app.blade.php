<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DoubleTree by Hilton Trujillo')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v={{ time() }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
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

    {{-- Estilos extra por vista --}}
    @stack('styles')
</head>
<body class="antialiased bg-ivory" style="font-family:'Inter',sans-serif">

    {{-- ══ NAVBAR COMPARTIDO ══ --}}
    {{--
        transparent=true  → solo para welcome (hero de fondo)
        transparent=false → fijo navy para todas las demás vistas
        Cada vista puede sobreescribir con @section('navbar') si necesita algo especial
    --}}
    @hasSection('navbar')
        @yield('navbar')
    @else
        <x-navbar :transparent="false" />
        {{-- Spacer para compensar navbar fijo de 72px --}}
        <div style="height:72px"></div>
    @endif

    {{-- ══ CONTENIDO PRINCIPAL ══ --}}
    <main>
        @yield('content')
    </main>

    {{-- ══ FOOTER COMPARTIDO ══ --}}
    <footer style="background:#0D2137;color:rgba(255,255,255,.65)">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-10">

                {{-- Brand --}}
                <div>
                    <div style="font-family:'Cormorant Garamond',serif;color:rgba(255,255,255,.45);font-size:9px;letter-spacing:.22em;text-transform:uppercase">DoubleTree by</div>
                    <div style="font-family:'Cormorant Garamond',serif;color:#fff;font-size:20px;font-weight:300">Hilton Trujillo</div>
                    <div style="color:#C9AA71;font-size:8px;letter-spacing:.3em;text-transform:uppercase;margin-top:2px">Hotel & Suites</div>
                    <p style="font-size:11px;color:rgba(255,255,255,.4);margin-top:12px;line-height:1.7">
                        La referencia de hospitalidad de lujo en el norte del Perú.
                    </p>
                </div>

                {{-- Links --}}
                <div>
                    <div style="color:#fff;font-size:8px;letter-spacing:.22em;text-transform:uppercase;font-weight:500;margin-bottom:14px">Navegación</div>
                    <ul style="list-style:none;display:flex;flex-direction:column;gap:8px">
                        <li><a href="{{ route('habitaciones.index') }}" style="color:rgba(255,255,255,.5);font-size:12px;text-decoration:none;transition:color .2s" onmouseover="this.style.color='#C9AA71'" onmouseout="this.style.color='rgba(255,255,255,.5)'">Habitaciones</a></li>
                        <li><a href="{{ route('welcome') }}#experiencias" style="color:rgba(255,255,255,.5);font-size:12px;text-decoration:none" onmouseover="this.style.color='#C9AA71'" onmouseout="this.style.color='rgba(255,255,255,.5)'">Experiencias</a></li>
                        <li><a href="{{ route('welcome') }}#nosotros" style="color:rgba(255,255,255,.5);font-size:12px;text-decoration:none" onmouseover="this.style.color='#C9AA71'" onmouseout="this.style.color='rgba(255,255,255,.5)'">El Hotel</a></li>
                        @guest('cliente')
                        <li><a href="{{ route('login') }}" style="color:rgba(255,255,255,.5);font-size:12px;text-decoration:none" onmouseover="this.style.color='#C9AA71'" onmouseout="this.style.color='rgba(255,255,255,.5)'">Iniciar Sesión</a></li>
                        <li><a href="{{ route('registro') }}" style="color:rgba(255,255,255,.5);font-size:12px;text-decoration:none" onmouseover="this.style.color='#C9AA71'" onmouseout="this.style.color='rgba(255,255,255,.5)'">Crear Cuenta</a></li>
                        @endguest
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <div style="color:#fff;font-size:8px;letter-spacing:.22em;text-transform:uppercase;font-weight:500;margin-bottom:14px">Contacto</div>
                    <ul style="list-style:none;display:flex;flex-direction:column;gap:9px">
                        <li style="display:flex;align-items:flex-start;gap:8px;font-size:11px;color:rgba(255,255,255,.5)">
                            <i class="fas fa-map-marker-alt" style="color:#C9AA71;margin-top:2px;flex-shrink:0"></i>
                            <span>Av. El Golf 591, Trujillo 13009<br>La Libertad, Perú</span>
                        </li>
                        <li style="display:flex;align-items:center;gap:8px;font-size:11px;color:rgba(255,255,255,.5)">
                            <i class="fas fa-phone" style="color:#C9AA71;flex-shrink:0"></i>
                            <span>(044) 123-456</span>
                        </li>
                        <li style="display:flex;align-items:center;gap:8px;font-size:11px;color:rgba(255,255,255,.5)">
                            <i class="fas fa-envelope" style="color:#C9AA71;flex-shrink:0"></i>
                            <span>reservas@doubletreetrujillo.com</span>
                        </li>
                        <li style="display:flex;align-items:center;gap:8px;font-size:11px;color:rgba(255,255,255,.5)">
                            <i class="fas fa-clock" style="color:#C9AA71;flex-shrink:0"></i>
                            <span>Recepción 24 horas</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div style="border-top:1px solid rgba(255,255,255,.08);padding-top:16px;display:flex;flex-wrap:wrap;justify-content:space-between;align-items:center;gap:10px">
                <span style="font-size:10px;color:rgba(255,255,255,.25)">
                    © {{ date('Y') }} DoubleTree by Hilton Trujillo. Todos los derechos reservados.
                </span>
                <div style="display:flex;gap:14px;align-items:center">
                    <a href="#" style="font-size:10px;color:rgba(255,255,255,.25);text-decoration:none">Privacidad</a>
                    <span style="color:rgba(255,255,255,.12)">·</span>
                    <a href="#" style="font-size:10px;color:rgba(255,255,255,.25);text-decoration:none">Términos</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- Scripts del navbar (inyectado por el componente) --}}
    @stack('scripts')

    {{-- Scripts extra por vista --}}
    @stack('page-scripts')

</body>
</html>