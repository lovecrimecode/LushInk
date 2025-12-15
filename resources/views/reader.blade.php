@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto glass">
    <h2 class="text-2xl text-wine mb-4">Reader</h2>

    <iframe
        src="/api/library/{{ request('id') }}/read"
        class="w-full h-[80vh] rounded bg-black">
    </iframe>
</div>
@endsection
