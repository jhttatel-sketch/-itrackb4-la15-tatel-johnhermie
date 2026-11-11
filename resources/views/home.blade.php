
@extends('layouts.app')

@section('content')

<style>
    .home-page {
        max-width: 950px;
        margin: 35px auto;
        padding: 25px;
    }

    .welcome-section {
        background: #f4f7fb;
        border: 1px solid #dce3ec;
        border-radius: 12px;
        padding: 35px 20px;
        text-align: center;
        margin-bottom: 25px;
    }

    .welcome-section h2 {
        color: #263b5e;
        font-weight: bold;
        margin-bottom: 12px;
    }

    .welcome-section p {
        color: #555;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.7;
    }

    .profile-photo {
        width: 145px;
        height: 145px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid white;
        box-shadow: 0 3px 10px rgba(0,0,0,0.15);
        margin: 20px 0 12px;
    }

    .profile-name {
        color: #263b5e;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .stats-title {
        color: #263b5e;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .stat-box {
        background: white;
        border: 1px solid #dce3ec;
        border-radius: 10px;
        padding: 22px;
        text-align: center;
        height: 100%;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .stat-box h3 {
        color: #315b91;
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .stat-box p {
        color: #666;
        margin: 0;
    }

    .explore-section {
        text-align: center;
        margin-top: 30px;
    }

    .explore-section .btn {
        padding: 10px 28px;
        border-radius: 6px;
    }
</style>

<div class="container home-page">

    <!-- Welcome Section -->
    <div class="welcome-section">

        <h2>Welcome to the Book Portal!</h2>

        <p>
            Discover, explore, and manage your collection of books.
            Browse different genres and find interesting books
            that you might enjoy reading.
        </p>

        <!-- Profile Photo -->
        <img src="{{ asset('img/hermie.jpg') }}"
             alt="John Hermie T. Tatel"
             class="profile-photo">

        <h5 class="profile-name">John Hermie T. Tatel</h5>
        <small class="text-muted">Book Portal Student Developer</small>

    </div>

    <!-- Database Statistics -->
    <h4 class="stats-title text-center">Book Portal Overview</h4>

    <div class="row text-center">

        <div class="col-md-6 mb-3">
            <div class="stat-box">
                <h3>{{ $bookCount }}</h3>
                <p>Total Books</p>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="stat-box">
                <h3>{{ $genreCount }}</h3>
                <p>Total Genres</p>
            </div>
        </div>

    </div>

    <!-- Explore Books Button -->
    <div class="explore-section">

        <p class="text-muted">
            Ready to explore the collection?
        </p>

        <a href="{{ route('books.index') }}" class="btn btn-primary">
            Explore Books
        </a>

    </div>

</div>

@endsection
