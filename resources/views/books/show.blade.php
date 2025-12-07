@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 glass" >
    <h1 class="text-3xl font-bold text-wine mb-2">{{ $book->title }}</h1>
    <p class="text-gray-400 mb-6">{{ $book->author }}</p>

    <div class="prose prose-invert">
        {!! nl2br(e($book->description)) !!}
    </div>
</div>
@endsection
