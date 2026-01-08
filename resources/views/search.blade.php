@extends('layouts.app')

@section('content')
<h2 class="text-2xl text-wine mb-6">
    Results for "{{ $q }}"
</h2>

<div id="results" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6"></div>

<script>
const q = @json($q);

fetch(`/api/search?q=${encodeURIComponent(q)}`)
  .then(res => res.json())
  .then(data => {
    const container = document.getElementById('results');

    if (!Array.isArray(data) || data.length === 0) {
      container.innerHTML = '<p>No results found.</p>';
      return;
    }

    container.innerHTML = data.slice(0, 16).map(book => `
      <div class="glass">
        ${book.cover_url ? `<img src="${book.cover_url}" class="rounded mb-4" />` : ''}
        <h3 class="font-bold">${book.title ?? ''}</h3>
        <p class="text-sm text-gray-400">${book.author ?? ''}</p>

        <a href="/book/${book.work_id}"
           class="inline-block mt-4 text-wine hover:underline">
          View details
        </a>
      </div>
    `).join('');
  })
  .catch(() => {
    document.getElementById('results').innerHTML = '<p>Error loading results.</p>';
  });
</script>
@endsection
