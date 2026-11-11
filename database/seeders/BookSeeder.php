<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Genre;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        // Create or find genres
        $fantasy = Genre::firstOrCreate(['name' => 'Fantasy']);
        $romance = Genre::firstOrCreate(['name' => 'Romance']);
        $technology = Genre::firstOrCreate(['name' => 'Technology']);
        $drama = Genre::firstOrCreate(['name' => 'Drama']);
        $adventure = Genre::firstOrCreate(['name' => 'Adventure']);

        // Book records
        $books = [
            ['Anime', 'Jjun Amaro', 1888, $fantasy->id, false, 'A fantasy book.'],
            ['Holly', 'Justine Tacorda', 1892, $romance->id, false, 'A romance book.'],
            ['Wordtech', 'Ronnie Vargas', 1983, $technology->id, false, 'A technology book.'],
            ['Blank', 'Lhorenz Magtibay', 1985, $drama->id, false, null],
            ['Eimreh', 'Eimreh San', 2009, $adventure->id, false, 'An adventure book.'],
            ['The Last Chapter', 'John Tatel', 2020, $fantasy->id, true, 'A featured book.'],
            ['Dragon Kingdom', 'Alex Morgan', 2015, $fantasy->id, false, 'A magical adventure.'],
            ['The Lost Wizard', 'Daniel Cruz', 2018, $fantasy->id, true, 'A story about a lost wizard.'],
            ['Moonlight Love', 'Sarah Reyes', 2012, $romance->id, false, 'A romantic story.'],
            ['Forever Yours', 'Maria Santos', 2019, $romance->id, true, 'A story about everlasting love.'],
            ['Digital World', 'Mark David', 2021, $technology->id, false, 'A book about technology.'],
            ['Future Code', 'James Lee', 2023, $technology->id, true, 'Exploring future technology.'],
            ['Broken Dreams', 'Angela Flores', 2010, $drama->id, false, 'A dramatic story.'],
            ['Silent Tears', 'Nicole Garcia', 2016, $drama->id, false, 'A story of challenges and hope.'],
            ['The Hidden Island', 'Peter James', 2017, $adventure->id, false, 'An exciting island adventure.'],
            ['Journey Beyond', 'Kevin Torres', 2022, $adventure->id, true, 'An unforgettable journey.'],
            ['The Magic Crown', 'Robert King', 2014, $fantasy->id, false, 'A fantasy about a magical crown.'],
            ['A Beautiful Promise', 'Ella White', 2011, $romance->id, false, 'A story about promises.'],
            ['Modern Machines', 'Chris Allen', 2024, $technology->id, false, 'Discovering modern machines.'],
            ['The Final Journey', 'Lucas Smith', 2025, $adventure->id, true, 'The final adventure.'],
        ];

        foreach ($books as $book) {
            Book::firstOrCreate(
                ['title' => $book[0]],
                [
                    'author' => $book[1],
                    'year' => $book[2],
                    'genre_id' => $book[3],
                    'is_featured' => $book[4],
                    'description' => $book[5],
                ]
            );
        }
    }
}
