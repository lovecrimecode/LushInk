<nav class="sticky top-0 z-50 border-b border-white/5 bg-ink2/60 backdrop-blur">
  <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
    <a href="{{ route('home') }}" class="flex items-center gap-3">
      <img src="{{ asset('images/logo.svg') }}" alt="LushInk" class="h-8 w-8">
      <span class="text-xl font-bold text-red-200">LushInk</span>
    </a>

    <div class="flex items-center gap-5 text-sm">
      <a href="{{ route('book.search') }}" class="text-zinc-300 hover:text-red-200 transition">Buscar</a>

      @auth
        <a href="{{ route('library') }}" class="text-zinc-300 hover:text-red-200 transition">Mi Librería</a>
        <a href="{{ route('dashboard') }}" class="text-zinc-300 hover:text-red-200 transition">Dashboard</a>

        {{-- Nombre como link al perfil --}}
        <a href="{{ route('profile.edit') }}" class="text-zinc-200 hover:text-red-200 font-medium transition">
          {{ Auth::user()->name }}
        </a>

        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button class="text-zinc-400 hover:text-red-200 transition">Logout</button>
        </form>
      @endauth

      @guest
        <a href="{{ route('login') }}" class="text-zinc-300 hover:text-red-200 transition">Login</a>
        <a href="{{ route('register') }}" class="text-zinc-300 hover:text-red-200 transition">Registrar</a>
      @endguest
    </div>
  </div>
</nav>
