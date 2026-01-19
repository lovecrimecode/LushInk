{{-- @extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

  <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
    <div>
      <h1 class="text-2xl font-semibold text-zinc-100">Libros Populares</h1>
      <p class="text-sm text-zinc-400">Explora los libros más populares</p>
    </div>
  </div>

  <div id="results" class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5"></div>

<script>
fetch(`/api/books`)
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
        const el = document.getElementById('results');
        el.innerHTML = `<div class="card p-6 text-zinc-400">Error al cargar los libros populares.</div>`;
    });
</script>
</div>
@endsection --}}
