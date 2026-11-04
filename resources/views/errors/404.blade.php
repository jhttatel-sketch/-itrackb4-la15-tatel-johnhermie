
@extends('layouts.app')

@section('content')
<div class="container text-center py-5">
    <h1>404</h1>
    <h2>Page Not Found</h2>

    <p>Sorry, the page you are looking for does not exist.</p>

    <a href="{{ route('books.index') }}" class="btn btn-primary">
        Back to Books
    </a>
</div>
@endsection
