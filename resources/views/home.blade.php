@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto glass text-center">
    <h1 class="text-4xl font-bold text-wine mb-6">LushInk</h1>
    <p class="text-gray-400 mb-6">Search and collect your books</p>

    <form action="/book/search" method="GET">
        <input
            type="text"
            name="q"
            class="w-full p-3 rounded bg-paper text-white"
            placeholder="Search books by title, author..."
            required
        >

        <button class="mt-6 bg-wine px-8 py-2 rounded text-white hover:bg-wineLight">
            Search
        </button>
    </form>
</div>
@endsection
