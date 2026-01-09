@extends('layouts.app')

@section('content')
<div id="details" class="max-w-4xl mx-auto"></div>

<script>
const id = @json($id);

fetch(`/api/details/${encodeURIComponent(id)}`)
  .then(r => r.json())
  .then(book => {
    const title = book.title ?? 'Untitled';
    const description = book.description ?? 'No descripcion disponible';
    const cover = book.cover_url ?? null;

    document.getElementById('details').innerHTML = `
      <div class="card p-6 md:p-8">
        <div class="grid md:grid-cols-12 gap-6">
          <div class="md:col-span-4">
            ${cover
              ? `<img class="rounded-xl border border-white/10 w-full object-cover" src="${cover}" alt="Cover de ${title}">`
              : `<div class="rounded-xl border border-white/10 bg-white/5 h-80 flex items-center justify-center text-zinc-500">No cover</div>`}
          </div>

          <div class="md:col-span-8">
            <div class="flex items-start justify-between gap-4">
              <div>
                <h1 class="text-3xl font-bold text-red-200">${title}</h1>
                <div class="mt-3 flex flex-wrap gap-2">
                  ${(book.subjects?.length) ? `<span class="badge">🏷️ ${book.subjects[0]}</span>` : ''}
                </div>
              </div>
              <a href="{{ route('book.search') }}" class="btn-ghost">Volver</a>
            </div>

            <p class="mt-5 text-zinc-300 leading-relaxed">
              ${description}
            </p>

            <div class="mt-6">
              @auth
                <form method="POST" action="{{ route('purchase') }}" class="flex flex-wrap gap-3">
                  @csrf
                  <input type="hidden" name="work_id" value="${id}">
                  <input type="hidden" name="title" value="${title}">
                  <button class="btn-wine">Añadir a mi biblioteca</button>
                  <a href="{{ route('library') }}" class="btn-ghost">Mi Library</a>
                </form>
              @else
                <div class="card p-4 bg-white/5 border-white/10">
                  <p class="text-zinc-400">Inicia sesión para agregar este libro a tu biblioteca.</p>
                  <div class="mt-3 flex gap-3">
                    <a class="btn-wine" href="{{ route('login') }}">Login</a>
                    <a class="btn-ghost" href="{{ route('register') }}">Register</a>
                  </div>
                </div>
              @endauth
            </div>
          </div>
        </div>
      </div>
    `;
  })
  .catch(() => {
    document.getElementById('details').innerHTML =
      `<div class="card p-6 text-zinc-400">Error cargando los datos del libro.</div>`;
  });
</script>
@endsection
