@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="GET" action="{{ route('home') }}">
            <div class="row mb-4">
                <div class="col-md-3">
                    <input type="text" name="title" class="form-control" placeholder="Search by Title"
                        value="{{ request('title') }}">
                </div>
                <div class="col-md-3">
                    <input type="text" name="author" class="form-control" placeholder="Search by Author"
                        value="{{ request('author') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('home') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
            </div>
        </form>

        <div class="row mt-2">
            @if ($books->count())
                @foreach ($books as $book)
                    <div class="col-md-4 mb-1">
                        <div class="card">
                            <a href="{{ route('book.show', ['id' => Crypt::encrypt($book->id)]) }}"
                                style="text-decoration: none;">
                                <div class="card-body">
                                    <div class="text-center">
                                        <img src="{{ asset('images/' . $book->images) }}" alt="Book Cover"
                                            class="img-fluid rounded shadow-sm mb-3" style="width:150px">
                                    </div>
                                    <h5 class="card-title text-center">Title: {{ $book->title ?? '' }}</h5>
                                    <p class="text-muted text-center">Author: <strong>{{ $book->author ?? '' }}</strong></p>
                                    <p class="text-center">
                                        <strong>Rating:</strong>
                                        {{ $book->averageRating }} / 5
                                    </p>
                                    <p class="text-center">
                                        <a href="{{ route('book.show', ['id' => Crypt::encrypt($book->id)]) }}"
                                            class="btn btn-secondary btn-sm">
                                            View Details
                                        </a>
                                    </p>

                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center">
                    <p>No records found.</p>
                </div>
            @endif
        </div>

    </div>
@endsection
