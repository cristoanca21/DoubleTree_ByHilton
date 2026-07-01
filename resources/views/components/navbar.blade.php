@props(['transparent' => false])

<nav id="navbar" class="{{ $transparent ? 'nav-transparent' : 'nav-solid' }} fixed top-0 left-0 right-0 z-50 transition-all duration-500">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">

            {{-- Logo --}}
            <a href="{{ route('welcome') }}" class="flex flex-col leading-none">
                <span class="font-serif text-white text-xs tracking-widest uppercase opacity-80"
                      style="letter-spacing:0.25em">DoubleTree by</span>
                <span class="font-serif text-white text-xl font-light tracking-wide">Hilton Trujillo</span>
                <span class="text-xs uppercase mt-0.5" style="color:#C9AA71;letter-spacing:0.35em">Hotel & Suites</span>
            </a>

            {{-- Links (desktop) --}}
            <div class="hidden lg:flex items-center gap-8">
                <a href="{{ route('habitaciones.index') }}"
                   class="text-white/80 hover:text-yellow-400 text-xs tracking-widest uppercase transition-colors duration-200">
                    Habitaciones
                </a>
                <a href="{{ route('welcome') }}#experiencias"
                   class="text-white/80 hover:text-yellow-400 text-xs tracking-widest uppercase transition-colors duration-200">
                    Experiencias
                </a>
                <a href="{{ route('welcome') }}#nosotros"
                   class="text-white/80 hover:text-yellow-400 text-xs tracking-widest uppercase transition-colors duration-200">
                    El Hotel
                </a>
                <a href="{{ route('welcome') }}#contacto"
                   class="text-white/80 hover:text-yellow-400 text-xs tracking-widest uppercase transition-colors duration-200">
                    Contacto
                </a>
            </div>

            {{-- Auth --}}
            <div class="flex items-center gap-3">
                @auth('cliente')
                    @if(auth('cliente')->user()->rol === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                           class="text-white/80 hover:text-yellow-400 text-xs tracking-widest uppercase transition-colors duration-200">
                            <i class="fas fa-cog mr-1.5" style="color:#C9AA71;opacity:.7"></i>Admin
                        </a>
                    @endif
                    <a href="{{ route('cliente.dashboard') }}"
                       class="text-white/85 hover:text-yellow-400 text-xs tracking-widest uppercase transition-colors duration-200 hidden sm:block">
                        <i class="fas fa-user-circle mr-1.5"></i>{{ auth('cliente')->user()->nombre }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline" id="form-logout-nav">
                        @csrf
                        <button type="button" onclick="confirmarLogout()"
                                class="text-xs tracking-widest uppercase font-semibold px-5 py-2.5 transition-all duration-200"
                                style="background:#C9AA71;color:#0D2137">
                            Salir
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="text-white/85 hover:text-yellow-400 text-xs tracking-widest uppercase transition-colors duration-200 hidden sm:block">
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('registro') }}"
                       class="text-xs tracking-widest uppercase font-semibold px-5 py-2.5 transition-all duration-200"
                       style="background:#C9AA71;color:#0D2137">
                        Reservar
                    </a>
                @endauth

                <button id="mobileMenuBtn"
                        class="lg:hidden text-white/80 hover:text-yellow-400 ml-2 transition-colors">
                    <i class="fas fa-bars text-lg"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div id="mobileMenu" class="hidden lg:hidden border-t" style="background:rgba(13,33,55,.98);border-color:rgba(201,170,113,.2)">
        <div class="px-6 py-4 flex flex-col gap-4">
            <a href="{{ route('habitaciones.index') }}"
               class="text-white/80 hover:text-yellow-400 text-xs tracking-widest uppercase">Habitaciones</a>
            <a href="{{ route('welcome') }}#experiencias"
               class="text-white/80 hover:text-yellow-400 text-xs tracking-widest uppercase">Experiencias</a>
            <a href="{{ route('welcome') }}#nosotros"
               class="text-white/80 hover:text-yellow-400 text-xs tracking-widest uppercase">El Hotel</a>
            <a href="{{ route('welcome') }}#contacto"
               class="text-white/80 hover:text-yellow-400 text-xs tracking-widest uppercase">Contacto</a>
            @guest('cliente')
                <a href="{{ route('login') }}"
                   class="text-white/80 hover:text-yellow-400 text-xs tracking-widest uppercase">Iniciar Sesión</a>
            @endguest
        </div>
    </div>
</nav>

{{-- Modal logout --}}
<div id="modal-logout-nav"
     class="fixed inset-0 z-50 hidden items-center justify-center"
     style="background:rgba(0,0,0,.5)">
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-sm w-full mx-4">
        <div class="text-center">
            <div class="rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4"
                 style="background:#fef2f2">
                <i class="fas fa-right-from-bracket text-2xl text-red-500"></i>
            </div>
            <h3 class="text-lg font-bold mb-2" style="color:#1A3A5C">¿Cerrar sesión?</h3>
            <p class="text-gray-500 text-sm mb-6">Tu sesión actual se cerrará. ¿Estás seguro?</p>
            <div class="flex gap-3">
                <button onclick="cerrarModalLogout()"
                        class="flex-1 py-2.5 rounded-lg font-medium text-sm"
                        style="background:#f3f4f6;color:#4b5563">
                    Cancelar
                </button>
                <button onclick="document.getElementById('form-logout-nav').submit()"
                        class="flex-1 py-2.5 rounded-lg font-medium text-sm text-white"
                        style="background:#ef4444">
                    Sí, salir
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.nav-transparent { background: transparent; }
.nav-solid { background: rgba(13,33,55,0.97); backdrop-filter: blur(12px); box-shadow: 0 2px 20px rgba(0,0,0,0.25); }
</style>

<script>
function confirmarLogout() {
    const m = document.getElementById('modal-logout-nav');
    m.classList.remove('hidden');
    m.classList.add('flex');
}
function cerrarModalLogout() {
    const m = document.getElementById('modal-logout-nav');
    m.classList.add('hidden');
    m.classList.remove('flex');
}
document.getElementById('modal-logout-nav')?.addEventListener('click', function(e) {
    if (e.target === this) cerrarModalLogout();
});
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') cerrarModalLogout();
});
if (document.getElementById('mobileMenuBtn')) {
    document.getElementById('mobileMenuBtn').addEventListener('click', () => {
        document.getElementById('mobileMenu').classList.toggle('hidden');
    });
}
    const navEl = document.getElementById('navbar');
if (navEl && navEl.classList.contains('nav-transparent')) {
    window.addEventListener('scroll', () => {
        if (window.scrollY > 80) {
            navEl.classList.remove('nav-transparent');
            navEl.classList.add('nav-solid');
        } else {
            navEl.classList.add('nav-transparent');
            navEl.classList.remove('nav-solid');
        }
    }, { passive: true });
}
</script>