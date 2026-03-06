@extends('layouts.app')

@section('content')
<div id="show" class="max-w-4xl mx-auto"></div>

<script>
const id = @json($id);
const csrf = @json(csrf_token());
const isAuth = @json(auth()->check());

const createPurchaseSection = (book) => {
  if (!isAuth) {
    return `
      <div class="card p-4 bg-white/5 border-white/10">
        <p class="text-zinc-400">Inicia sesión para agregar este libro a tu biblioteca.</p>
        <div class="mt-3 flex gap-3">
          <a class="btn-wine" href="{{ route('login') }}">Login</a>
          <a class="btn-ghost" href="{{ route('register') }}">Register</a>
        </div>
      </div>
    `;
  }

  return `
    <div class="flex flex-wrap gap-3 items-center">
      <button id="purchase-btn" class="btn-wine" type="button">Añadir a mi biblioteca</button>
      <a href="{{ route('library') }}" class="btn-ghost">Ir a biblioteca</a>
      <span id="purchase-msg" class="text-sm text-zinc-400"></span>
    </div>
  `;
};

fetch(`/api/show/${encodeURIComponent(id)}`)
  .then(r => r.json())
  .then(book => {
    const title = book.title ?? 'Untitled';
    const description = book.description ?? 'No descripción disponible';
    const cover = book.cover_url ?? null;

    document.getElementById('show').innerHTML = `
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

            <p class="mt-5 text-zinc-300 leading-relaxed">${description}</p>

            <div class="mt-6">${createPurchaseSection(book)}</div>
          </div>
        </div>
      </div>
    `;

    if (!isAuth) return;

    const purchaseBtn = document.getElementById('purchase-btn');
    const purchaseMsg = document.getElementById('purchase-msg');

    purchaseBtn?.addEventListener('click', async () => {
      purchaseBtn.disabled = true;
      purchaseMsg.textContent = 'Guardando en tu biblioteca...';

      try {
        const payload = {
          api_id: id,
          title,
          author: 'Autor desconocido',
          cover,
          description,
          price: 0,
        };

        const res = await fetch('{{ route('purchase') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrf,
          },
          credentials: 'same-origin',
          body: JSON.stringify(payload),
        });

        if (!res.ok) {
          throw new Error(`HTTP ${res.status}`);
        }

        purchaseMsg.textContent = '✅ Libro agregado a tu biblioteca.';
      } catch (e) {
        purchaseMsg.textContent = '❌ No se pudo agregar el libro. Inténtalo nuevamente.';
      } finally {
        purchaseBtn.disabled = false;
      }
    });
  })
  .catch(() => {
    document.getElementById('show').innerHTML =
      `<div class="card p-6 text-zinc-400">Error cargando los datos del libro.</div>`;
  });
</script>
@endsection