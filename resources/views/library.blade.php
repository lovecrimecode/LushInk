@extends('layouts.app')

@section('header')
  <div>
    <h1 class="text-xl font-semibold">Mi Biblioteca</h1>
  </div>
@endsection

@section('content')
<div id="lib" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5"></div>

<script>
fetch('/api/library', { credentials: 'same-origin',
  headers: { 'Accept': 'application/json' }
})
  .then(r => r.json())
  .then(data => {
    const el = document.getElementById('lib');

    if (!Array.isArray(data) || data.length === 0) {
      el.innerHTML = `<div class="card p-6 text-zinc-400">Aún no tienes libros en tu biblioteca.</div>`;
      return;
    }

    el.innerHTML = data.map(b => `
      <div class="card card-hover overflow-hidden">
        <div class="p-4 flex gap-4">
          <div class="w-20 shrink-0">
            ${b.cover_url
              ? `<img src="${b.cover_url}" class="h-28 w-20 rounded-lg object-cover border border-white/10" />`
              : `<div class="h-28 w-20 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-zinc-500 text-xs">No cover</div>`}
          </div>
          <div class="min-w-0 flex-1">
            <h3 class="font-semibold text-zinc-100 truncate">${b.title ?? 'Untitled'}</h3>
            <p class="text-sm text-zinc-400 truncate">${b.authors ?? ''}</p>

            <div class="mt-4 flex flex-wrap gap-2">
              ${b.file_path
                ? `<a class="btn-wine" href="/read/${b.id}">📖 Leer</a>`
                : `<span class="badge">Contenido no disponible</span>`}
            </div>
          </div>
        </div>
      </div>
    `).join('');
  })
  .catch(() => {
    document.getElementById('lib').innerHTML =
      `<div class="card p-6 text-zinc-400">Error cargando tu biblioteca.</div>`;
  });
</script>
@endsection
