@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{ asset('images/' . $book->images) }}" alt="Book Cover"
                                class="img-fluid rounded shadow-sm mb-3" style="width:200px">
                        </div>
                        <h5 class="card-title text-center">{{ $book->title }}</h5>
                        <p class="text-muted text-center">by <strong>{{ $book->author }}</strong></p>
                        <p class="text-center"><strong>Rating:</strong> {{ $averageRating }} / 5</p>
                        <p>{!! $book->description !!}</p>
                    </div>
                </div>

                <div class="mt-4">
                    <h4>Leave a Review</h4>
                    @if (!$hasReviewed)
                        <form action="{{ route('book.review', ['id' => Crypt::encrypt($book->id)]) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="rating">Rating</label>
                                <select name="rating" class="form-control" id="rating">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="form-group mt-2">
                                <label for="comment">Comment</label>
                                <textarea name="comment" class="form-control" id="comment" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Submit Review</button>
                        </form>
                    @else
                        <p class="text-muted">You have already reviewed this book.</p>
                    @endif
                </div>

                <div class="mt-4">
                    <h4>Reviews</h4>
                    @forelse ($reviews as $review)
                        <div class="card mb-2">
                            <div class="card-body">
                                <p><strong>User:</strong> {{ $review->username }}</p>
                                <p><strong>Rating:</strong> {{ $review->rating }} / 5</p>
                                <p>{!! $review->comments !!}</p>
                                <small class="text-muted">Reviewed on {{ $review->created_at }}</small>
                            </div>
                        </div>
                    @empty
                        <p>No reviews available for this book.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@endsection
