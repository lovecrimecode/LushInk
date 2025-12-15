@extends('layouts.app')

@section('content')
<div id="details" class="max-w-3xl mx-auto glass"></div>

<script>
const id = new URLSearchParams(window.location.search).get('id');

fetch(`/api/details/${id}`)
    .then(res => res.json())
    .then(book => {
        document.getElementById('details').innerHTML = `
            <h1 class="text-3xl text-wine mb-4">${book.title}</h1>
            <p class="text-gray-400 mb-6">
                ${book.description?.value ?? book.description ?? 'No description available'}
            </p>

            @auth
            <button onclick="purchase('${book.title}')"
                class="bg-wine px-6 py-2 rounded text-white hover:bg-wineLight">
                Purchase
            </button>
            @else
            <p class="text-gray-500">Login to purchase this book</p>
            @endauth
        `;
    });

function purchase(title) {
    fetch('/api/purchase', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            api_id: id,
            title: title
        })
    }).then(() => {
        alert('Book added to your library');
        window.location.href = '/library';
    });
}
</script>
@endsection
