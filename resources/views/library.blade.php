@extends('layouts.app')

@section('header')
  <div>
    <h1 class="text-xl font-semibold">Mi Biblioteca</h1>
  </div>
@endsection

@section('content')
<div id="lib" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5"></div>

<script>
const csrf = @json(csrf_token());

const saveProgress = async (bookId) => {
  const current = Number(document.getElementById(`current-${bookId}`)?.value || 0);
  const total = Number(document.getElementById(`total-${bookId}`)?.value || 0);
  const messageEl = document.getElementById(`progress-msg-${bookId}`);

  messageEl.textContent = 'Guardando...';

  try {
    const res = await fetch(`/books/${bookId}/progress`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrf,
      },
      credentials: 'same-origin',
      body: JSON.stringify({ current_page: current, total_pages: total }),
    });

    if (!res.ok) throw new Error(`HTTP ${res.status}`);

    const data = await res.json();
    const percent = data.progress?.percentage_completed ?? 0;

    document.getElementById(`percent-${bookId}`).textContent = `${percent}%`;
    messageEl.textContent = '✅ Progreso guardado';
  } catch (err) {
    messageEl.textContent = '❌ Error al guardar';
  }
};

fetch('/api/library', {
  credentials: 'same-origin',
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
            <p class="text-sm text-zinc-400 truncate">${b.author ?? 'Autor desconocido'}</p>
            <div class="mt-3 text-xs text-zinc-400">
              Progreso: <span id="percent-${b.id}">${b.progress?.percentage_completed ?? 0}%</span>
            </div>
            <div class="mt-2 grid grid-cols-2 gap-2">
              <input id="current-${b.id}" class="input text-sm" type="number" min="0" value="${b.progress?.current_page ?? 0}" placeholder="Página actual" />
              <input id="total-${b.id}" class="input text-sm" type="number" min="1" value="${b.progress?.total_pages ?? 0}" placeholder="Total de páginas" />
            </div>

            <div class="mt-3 flex flex-wrap gap-2">
              <button class="btn-ghost" type="button" onclick="saveProgress(${b.id})">Guardar progreso</button>
              ${b.file_path
                ? `<a class="btn-wine" href="/read/${b.id}">📖 Leer</a>`
                : `<span class="badge">Contenido no disponible</span>`}
            </div>

            <p id="progress-msg-${b.id}" class="mt-2 text-xs text-zinc-500"></p>
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
