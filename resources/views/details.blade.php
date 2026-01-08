@extends('layouts.app')

@section('content')
<div id="details" class="max-w-3xl mx-auto glass"></div>

<script>
const id = @json($id);

fetch(`/api/details/${encodeURIComponent(id)}`)
  .then(res => res.json())
  .then(book => {
    const title = book.title ?? 'Untitled';
    const description = book.description ?? 'No description available';

    document.getElementById('details').innerHTML = `
      <h1 class="text-3xl text-wine mb-4">${title}</h1>
      ${book.cover_url ? `<img class="rounded mb-4" src="${book.cover_url}" />` : ''}
      <p class="text-gray-400 mb-6">${description}</p>

      @auth
        <form method="POST" action="/purchase">
          @csrf
          <input type="hidden" name="work_id" value="${id}">
          <input type="hidden" name="title" value="${title}">
          <button class="bg-wine px-6 py-2 rounded text-white hover:bg-wineLight">
            Purchase
          </button>
        </form>
      @else
        <p class="text-gray-500">Login to purchase this book</p>
      @endauth
    `;
  })
  .catch(() => {
    document.getElementById('details').innerHTML = '<p>Error loading book details.</p>';
  });
</script>
@endsection
