<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    // Display books with search, filters, sorting, and pagination
    public function index(Request $request)
    {
        DB::flushQueryLog();
        DB::enableQueryLog();

        $query = Book::query();

        // Search by title or author
        $search = $request->query('search');

        if ($search !== null && $search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Filter by genre
        $genre = $request->query('genre');

        if ($genre !== null && $genre !== '') {
            $query->where('genre_id', $genre);
        }

        // Filter by year
        $year = $request->query('year');

        if ($year !== null && $year !== '') {
            $query->where('year', $year);
        }

        // Filter by featured status
        $featured = $request->query('featured');

        if ($featured !== null && $featured !== '') {
            $query->where('is_featured', $featured === '1');
        }

        // Allowed sorting columns
        $allowedSorts = ['title', 'year'];

        // Validate the requested sort value
        $requestedSort = $request->query('sort');

        // Default to title if the sort value is invalid
        $sort = in_array($requestedSort, $allowedSorts, true)
            ? $requestedSort
            : 'title';

        // Sort, load genre, and paginate
        $books = $query->with('genre')
                       ->orderBy($sort)
                       ->paginate(5)
                       ->withQueryString();

        // Get genres for dropdown
        $genres = Genre::orderBy('name')->get();

        // Count database queries
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

    // Show the add book form
    public function create()
    {
        $genres = Genre::all();

        return view('books.create', compact('genres'));
    }

    // Save a new book
    public function store(Request $request)
    {
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

    // Display one book
    public function show(Book $book)
    {
        $book->load('genre');

        return view('books.show', compact('book'));
    }

    // Show the edit form
    public function edit(Book $book)
    {
        $genres = Genre::all();

        return view('books.edit', compact('book', 'genres'));
    }

    // Update an existing book
    public function update(Request $request, Book $book)
    {
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

    // Delete a book
    public function destroy(Book $book)
    {
        // Prevent deleting the last book in its genre
        abort_if(
            $book->genre()->withCount('books')->first()->books_count === 1,
            403
        );

        $book->delete();

        return redirect()
            ->route('books.index')
            ->with('success', 'Book deleted successfully!');
    }

    // Display the featured book
    public function featured()
    {
        $book = Book::where('is_featured', true)->firstOrFail();

        return view('books.featured', compact('book'));
    }
}
