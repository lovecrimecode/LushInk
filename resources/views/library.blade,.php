@extends('layouts.app')

@section('content')
<h2 class="text-2xl text-wine mb-6">My Library</h2>

<div id="library" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6"></div>

<script>
fetch('/api/library')
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById('library');

        if (!data.length) {
            container.innerHTML = '<p>No books purchased yet.</p>';
            return;
        }

        data.forEach(book => {
            container.innerHTML += `
                <div class="glass">
                    <h3 class="font-bold mb-2">${book.title}</h3>
                    <a href="/reader?id=${book.id}"
                       class="text-wine hover:underline">
                        Read
                    </a>
                </div>
            `;
        });
    });
</script>
@endsection
