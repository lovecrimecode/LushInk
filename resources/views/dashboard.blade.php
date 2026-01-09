@extends('layouts.app')

@section('header')
  <div>
    <h1 class="text-xl font-semibold">Dashboard</h2>
    <p class="text-sm text-zinc-400">Tu progreso y tu biblioteca</p>
  </div>
@endsection

@section('content')
<div class="grid lg:grid-cols-12 gap-6">
  <section class="lg:col-span-8">
    <div class="card p-6">
      <h3 class="text-lg font-semibold">📈 Progreso de lectura</h3>

      <div class="mt-5 space-y-4">
        @foreach([['Book A', 35], ['Book B', 70], ['Book C', 15]] as $p)
          <div>
            <div class="flex justify-between text-sm">
              <span class="text-zinc-300">{{ $p[0] }}</span>
              <span class="text-zinc-400">{{ $p[1] }}%</span>
            </div>
            <div class="mt-2 h-2 rounded-full bg-white/10 overflow-hidden">
              <div class="h-2 bg-red-900" style="width: {{ $p[1] }}%"></div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <aside class="lg:col-span-4 space-y-6">
    <div class="card p-6">
      <h3 class="text-lg font-semibold">📚 Mi biblioteca</h3>

      <div id="libPreview" class="mt-4 space-y-3 text-zinc-400">
        Cargando...
      </div>

      <a href="/library" class="btn-ghost w-full mt-4">Ver biblioteca completa</a>
    </div>
  </aside>
</div>

<script>
fetch('/api/library', { headers: { 'Accept': 'application/json' }})
  .then(r => r.json())
  .then(data => {
    const el = document.getElementById('libPreview');
    if (!Array.isArray(data) || data.length === 0) {
      el.innerHTML = '<p>No tienes libros aún.</p>';
      return;
    }

    el.innerHTML = data.slice(0, 3).map(b => `
      <div class="card p-4">
        <div class="font-semibold text-zinc-100">${b.title ?? 'Untitled'}</div>
        <div class="text-sm text-zinc-400">${b.authors ?? ''}</div>
      </div>
    `).join('');
  })
  .catch(() => {
    document.getElementById('libPreview').innerHTML = '<p>Error cargando biblioteca.</p>';
  });
</script>
@endsection
