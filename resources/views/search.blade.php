@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

  <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
    <div>
      <h1 class="text-2xl font-semibold text-zinc-100">Búsqueda de libros</h1>
      <p class="text-sm text-zinc-400">Encuentra tus libros favoritos</p>
    </div>

    <form class="w-full sm:w-[420px]" method="GET" action="{{ route('book.search') }}">
      <div class="flex gap-2">
        <input name="q" value="{{ $q }}" class="input" placeholder="Ej: Narnia, Tolkien, Dune..." />
        <button class="btn-wine px-5" type="submit">Buscar</button>
      </div>
    </form>
  </div>

  <div class="mt-6">
    <h2 class="text-xl font-semibold">Resultados</h2>
    <p class="text-zinc-400">
      Búsqueda: <span class="text-red-300">"{{ $q }}"</span>
    </p>
  </div>

  <div id="results" class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5"></div>

</div>

<script>
const q = @json($q);

fetch(`/api/search?q=${encodeURIComponent(q)}`)
  .then(r => r.json())
  .then(data => {
    const el = document.getElementById('results');

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
  })
  .catch(() => {
    document.getElementById('results').innerHTML =
      `<div class="card p-6 text-zinc-400">Error cargando resultados.</div>`;
  });
</script>
@endsection
