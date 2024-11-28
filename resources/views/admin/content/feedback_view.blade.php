@extends('admin.layouts.verticalLayoutMaster')

@section('title', 'Feedback Details')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Feedback Details</h4>
        </div>

        <div class="card-body">
            @if ($feedbacks)
                <div class="row">
                    <div class="col-12">
                        <h5><strong>User Name:</strong> {{ $feedbacks->user_name }}</h5>
                        <h5><strong>Book Title:</strong> {{ $feedbacks->book_title }}</h5>
                        <h5><strong>Rating:</strong> {{ $feedbacks->rating }} / 5</h5>
                        <h5><strong>Comments:</strong> 
                            {!! $feedbacks->comments !!}
                        </h5>
                        <h5><strong>Created At:</strong> {{ $feedbacks->created_at->format('d-m-Y H:i') }}</h5>
                    </div>
                </div>
            @else
                <p class="text-center">No feedback details found.</p>
            @endif
        </div>
    </div>
@endsection
