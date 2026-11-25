<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;

class BookController extends Controller
{
    public function index(Request $request)
    {
        DB::flushQueryLog();
        DB::enableQueryLog();

        $query = Book::query();

        $search = $request->query('search');

        if ($search !== null && $search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        $genre = $request->query('genre');

        if ($genre !== null && $genre !== '') {
            $query->where('genre_id', $genre);
        }

        $year = $request->query('year');

        if ($year !== null && $year !== '') {
            $query->where('year', $year);
        }

        $featured = $request->query('featured');

        if ($featured !== null && $featured !== '') {
            $query->where('is_featured', $featured === '1');
        }

        $allowedSorts = ['title', 'year'];

        $requestedSort = $request->query('sort');

        $sort = in_array($requestedSort, $allowedSorts, true)
            ? $requestedSort
            : 'title';

        $books = $query->with('genre')
                       ->orderBy($sort)
                       ->paginate(5)
                       ->withQueryString();

        $genres = Genre::orderBy('name')->get();

        $queryCount = count(DB::getQueryLog());

        return view('books.index', [
            'books' => $books,
            'genres' => $genres,
            'genre' => $genre,
            'year' => $year,
            'search' => $search,
            'featured' => $featured,
            'sort' => $sort,
            'queryCount' => $queryCount,
        ]);
    }

    public function create()
    {
        Gate::authorize('create', Book::class);

        $genres = Genre::all();

        return view('books.create', compact('genres'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Book::class);

        $validated = $request->validate([
            'title' => 'required|max:100',
            'author' => 'required|max:100',
            'year' => 'required|numeric|min:1000|max:2100',
            'genre_id' => 'required|exists:genres,id',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        $book = Book::create($validated);

        Log::info('Book saved', [
            'id' => $book->id,
        ]);

        return redirect()
            ->route('books.index')
            ->with('success', 'Book added successfully!');
    }

    public function show(Book $book)
    {
        $book->load('genre');

        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        Gate::authorize('update', $book);

        $genres = Genre::all();

        return view('books.edit', compact('book', 'genres'));
    }

    public function update(Request $request, Book $book)
    {
        Gate::authorize('update', $book);

        $validated = $request->validate([
            'title' => 'required|max:100',
            'author' => 'required|max:100',
            'year' => 'required|numeric|min:1000|max:2100',
            'genre_id' => 'required|exists:genres,id',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        $book->update($validated);

        Log::info('Book updated', [
            'id' => $book->id,
        ]);

        return redirect()
            ->route('books.index')
            ->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {
        Gate::authorize('delete', $book);

        abort_if(
            $book->genre()->withCount('books')->first()->books_count === 1,
            403
        );

        $book->delete();

        return redirect()
            ->route('books.index')
            ->with('success', 'Book deleted successfully!');
    }

    public function featured()
    {
        $book = Book::where('is_featured', true)->firstOrFail();

        return view('books.featured', compact('book'));
    }
}
