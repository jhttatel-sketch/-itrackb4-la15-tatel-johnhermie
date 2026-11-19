@extends('layouts.app')

@section('title', 'Book List')

@section('content')

<style>
    .books-container {
        max-width: 850px;
        margin: 50px auto;
    }

    .books-title {
        font-size: 34px;
        font-weight: 600;
        margin-bottom: 35px;
    }

    .filter-heading {
        font-size: 21px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .genre-btn {
        color: #0d6efd;
        border: 1px solid #0d6efd;
        background: white;
        padding: 7px 12px;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
        margin-right: 3px;
        margin-bottom: 5px;
    }

    .genre-btn:hover {
        background: #0d6efd;
        color: white;
    }

    .year-btn {
        color: #198754;
        border: 1px solid #198754;
        background: white;
        padding: 7px 12px;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
        margin-right: 3px;
        margin-bottom: 5px;
    }

    .year-btn:hover {
        background: #198754;
        color: white;
    }

    .books-table {
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
    }

    .books-table th {
        background: #212529;
        color: white;
        padding: 12px 10px;
    }

    .books-table td {
        padding: 12px 10px;
    }

    .books-table a.book-title {
        color: #0d6efd;
    }

    .pagination {
        justify-content: flex-end;
    }
</style>

<div class="container books-container">

    {{-- Heading --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="books-title">Book List</h2>

        @auth
            <a href="{{ route('books.create') }}"
               class="btn btn-success btn-lg">
                + Add New Book
            </a>
        @endauth

    </div>

    {{-- Search and Filters --}}
    <form action="{{ route('books.index') }}" method="GET" class="mb-4">

        <div class="row g-2 mb-3">

            {{-- Search --}}
            <div class="col-md-6">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Search by title or author..."
                    value="{{ request('search') }}"
                >
            </div>

            {{-- Genre Dropdown --}}
            <div class="col-md-3">
                <select name="genre" class="form-select">
                    <option value="">All Genres</option>

                    @foreach ($genres as $item)
                        <option value="{{ $item->id }}"
                            @selected(request('genre') == $item->id)>
                            {{ $item->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- Featured Dropdown --}}
            <div class="col-md-3">
                <select name="featured" class="form-select">

                    <option value="">All Books</option>

                    <option value="1"
                        @selected(request('featured') === '1')>
                        Featured
                    </option>

                    <option value="0"
                        @selected(request('featured') === '0')>
                        Not Featured
                    </option>

                </select>
            </div>

        </div>

        {{-- Sorting Dropdown --}}
        <div class="row g-2 mb-3">

            <div class="col-md-4">

                <label class="form-label fw-semibold">
                    Sort Books By
                </label>

                <select name="sort" class="form-select">

                    <option value="title"
                        @selected($sort === 'title')>
                        Title
                    </option>

                    <option value="year"
                        @selected($sort === 'year')>
                        Year
                    </option>

                </select>

            </div>

        </div>

        {{-- Buttons --}}
        <button type="submit" class="btn btn-primary">
            Search / Filter
        </button>

        <a href="{{ route('books.index') }}"
           class="btn btn-danger">
            Clear Filters
        </a>

    </form>

    {{-- Genre Links --}}
    <h4 class="filter-heading">Filter by Genre ID</h4>

    <div class="mb-3">

        @foreach ($genres as $item)

            <a href="{{ route('books.index', ['genre' => $item->id]) }}"
               class="genre-btn">
                {{ $item->name }}
            </a>

        @endforeach

    </div>

    {{-- Year Links --}}
    <h4 class="filter-heading">Filter by Year</h4>

    <div class="mb-3">

        @foreach ([1888, 1892, 1983, 1985, 2009, 2020] as $yearOption)

            <a href="{{ route('books.index', ['year' => $yearOption]) }}"
               class="year-btn">
                {{ $yearOption }}
            </a>

        @endforeach

    </div>

    {{-- Query Counter --}}
    <div class="small text-secondary mb-2">
        Queries: {{ $queryCount }}
    </div>

    {{-- Books Table --}}
    <div class="table-responsive">

        <table class="table table-bordered table-hover books-table">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Year</th>
                    <th>Genre</th>

                    @auth
                        <th>Actions</th>
                    @endauth
                </tr>
            </thead>

            <tbody>

                @forelse ($books as $book)

                    <tr>

                        <td>{{ $book->id }}</td>

                        <td>
                            <a class="book-title"
                               href="{{ route('books.show', $book) }}">
                                {{ $book->title }}
                            </a>
                        </td>

                        <td>{{ $book->author }}</td>

                        <td>{{ $book->year }}</td>

                        <td>
                            {{ $book->genre->name ?? 'Unknown' }}
                        </td>

                        @auth
                            <td>

                                <a href="{{ route('books.edit', $book) }}"
                                   class="btn btn-primary btn-sm">
                                    Edit
                                </a>

                                <form
                                    action="{{ route('books.destroy', $book) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Delete this book?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger btn-sm">
                                        Delete
                                    </button>

                                </form>

                            </td>
                        @endauth

                    </tr>

                @empty

                    <tr>
                        <td colspan="{{ auth()->check() ? 6 : 5 }}"
                            class="text-center">
                            No books found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $books->links() }}
    </div>

</div>

@endsection
