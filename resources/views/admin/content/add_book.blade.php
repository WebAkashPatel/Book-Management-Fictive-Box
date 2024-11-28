@extends('admin.layouts.verticalLayoutMaster')

@section('title', isset($book) ? 'Edit Book' : 'Add Book')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ isset($book) ? 'Edit' : 'Add' }} Book Form</h4>
        </div>

        <div class="card-body">
            <form action="{{ isset($book) ? route('admin.books.update', $book->id) : route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($book))
                    @method('PUT')
                @endif
        
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $book->title ?? '') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
        
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="author">Author <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author" value="{{ old('author', $book->author ?? '') }}" required>
                            @error('author')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
        
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="images">Book Image <span class="text-danger">*</span></label>
                            @if (isset($book->images) && $book->images)
                                <div>
                                    <img src="{{ asset('images/' . $book->images) }}" alt="Current Book Image" width="100" height="100">
                                    <br>
                                    <small>Current Image</small>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('images') is-invalid @enderror" id="images" name="images">
                            @error('images')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
        
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" rows ='5' id="description" name="description" required>{{ old('description', $book->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
        
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        
    </div>
@endsection
