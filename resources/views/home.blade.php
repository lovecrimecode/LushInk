@extends('layouts.app')

@section('content')
<div class="grid gap-8 lg:grid-cols-12 items-start">
  <section class="lg:col-span-7">
    <div class="card p-8">
      <h2 class="mt-4 text-4xl font-bold leading-tight">
        Descubre, guarda y lee libros en una experiencia moderna.
      </h2>

      <div class="mt-6 flex flex-col sm:flex-row gap-3">
        <a href="{{ route('book.search') }}" class="btn-wine">Buscar libros</a>
        @auth
          <a href="{{ route('dashboard') }}" class="btn-ghost">Ir al Dashboard</a>
        @else
          <a href="{{ route('login') }}" class="btn-ghost">Iniciar sesión</a>
        @endauth
      </div>
    </div>

    <form class="mt-8" method="GET" action="{{ route('book.index') }}">

    <div class="mt-8 text-zinc-400">
      <h2 class="text-2xl font-semibold">Libros Populares</h2>
      <div id="trendingBooks" class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5"></div>

      <script>
      document.addEventListener('DOMContentLoaded', async () => {
        const el = document.getElementById('trendingBooks');
        el.innerHTML = `<div class="card p-6 text-zinc-400">Cargando libros...</div>`;

        try {
          const res = await fetch('/api/books', { headers: { 'Accept': 'application/json' } });
          if (!res.ok) throw new Error(`HTTP ${res.status}`);
          const data = await res.json();

          if (!Array.isArray(data) || data.length === 0) {
            el.innerHTML = `<div class="card p-6 text-zinc-400">No se encontraron resultados.</div>`;
            return;
          }

          el.innerHTML = data.map(b => `
            <a class="card card-hover block overflow-hidden" href="/book/${b.work_id}">
              <div class="p-4 flex gap-4">
                <div class="w-20 shrink-0">
                  ${b.cover_url
                    ? `<img src="${b.cover_url}" class="h-28 w-20 rounded-lg object-cover border border-white/10" />`
                    : `<div class="h-28 w-20 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-zinc-500 text-xs">No cover</div>`}
                </div>
                <div class="min-w-0 flex-1">
                  <h3 class="font-semibold text-zinc-100 truncate">${b.title ?? ''}</h3>
                  <p class="text-sm text-zinc-400 truncate">${b.author ?? 'Autor desconocido'}</p>
                  <div class="mt-3 flex gap-2">
                    ${b.published_year ? `<span class="badge">📅 ${b.published_year}</span>` : ''}
                  </div>
                </div>
              </div>
            </a>
          `).join('');
        } catch (err) {
          console.error(err);
          el.innerHTML = `<div class="card p-6 text-zinc-400">Error al cargar los libros populares.</div>`;
        }
      });
      </script>
    </div>
  </section>

  <aside class="lg:col-span-5">
    <div class="card p-6">
      <h2 class="text-xl font-semibold">Empieza escribiendo un título o autor:</h2>

      <form class="mt-4" method="GET" action="{{ route('book.search') }}">
        <input name="q" class="input" placeholder="Ej: Narnia, Tolkien, Dune..." />
        <button class="btn-wine w-full mt-3" type="submit">Buscar</button>
      </form>

      <div class="mt-6 text-xs text-zinc-500">
        *OpenLibrary solo provee metadatos. La lectura depende de tu biblioteca interna.
      </div>
    </div>

    <div class="mt-6 grid sm:grid-cols-3 gap-4">
      <div class="card p-5">
        <h3 class="font-semibold">Datos</h3>
        <p class="text-sm text-zinc-400 mt-2">Búsqueda impulsada por OpenLibrary.</p>
      </div>
      <div class="card p-5">
        <h3 class="font-semibold">Progreso</h3>
        <p class="text-sm text-zinc-400 mt-2">Seguimiento de libros guardados en tu biblioteca.</p>
      </div>
      <div class="card p-5">
        <h3 class="font-semibold">Interfaz</h3>
        <p class="text-sm text-zinc-400 mt-2">Lectura comoda y personalizada.</p>
      </div>
    </div>
  </aside>
</div>
@endsection
