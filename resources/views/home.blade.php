@extends('layouts.app')

@section('content')
<div class="grid gap-8 lg:grid-cols-12 items-start">
  <section class="lg:col-span-7">
    <div class="card p-8">
      <h1 class="mt-4 text-4xl font-bold leading-tight">
        Descubre, guarda y lee libros en una experiencia moderna.
      </h1>

      <div class="mt-6 flex flex-col sm:flex-row gap-3">
        <a href="{{ route('book.search') }}" class="btn-wine">Buscar libros</a>
        @auth
          <a href="{{ route('dashboard') }}" class="btn-ghost">Ir al Dashboard</a>
        @else
          <a href="{{ route('login') }}" class="btn-ghost">Iniciar sesión</a>
        @endauth
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
  </aside>
</div>
@endsection
