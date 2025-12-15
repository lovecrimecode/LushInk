@extends('layouts.app')

@section('content')
<h2 class="text-2xl text-wine mb-6">
    Results for "{{ request('q') }}"
</h2>

<div id="results" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6"></div>

<script>
fetch(`/api/search?q={{ request('q') }}`)
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById('results');

        if (!data.length) {
            container.innerHTML = '<p>No results found.</p>';
            return;
        }

        data.slice(0, 16).forEach(book => {
            const cover = book.cover_i
                ? `https://covers.openlibrary.org/b/id/${book.cover_i}-M.jpg`
                : '';

            const workId = book.key.replace('/works/', '');

            container.innerHTML += `
                <div class="glass">
                    ${cover ? `<img src="${cover}" class="rounded mb-4">` : ''}
                    <h3 class="font-bold">${book.title}</h3>
                    <p class="text-sm text-gray-400">${book.author_name?.[0] ?? ''}</p>

                    <a href="/book?id=${workId}"
                       class="inline-block mt-4 text-wine hover:underline">
                        View details
                    </a>
                </div>
            `;
        });
    });
</script>
@endsection
