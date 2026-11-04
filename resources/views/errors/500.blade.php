
@extends('layouts.app')

@section('content')
<div class="container text-center py-5">
    <h1>500</h1>
    <h2>Internal Server Error</h2>

    <p>Sorry, something went wrong on our server.</p>

    <a href="{{ route('books.index') }}" class="btn btn-primary">
        Back to Books
    </a>
</div>
@endsection
