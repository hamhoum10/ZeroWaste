@extends('layouts.front')

@section('content')
  <div class="container py-5">
    <h1 class="text-center mb-4">Edit Recycling Tip</h1>

    <form action="{{ route('recycling-tips.update', $tip->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $tip->title) }}"
               required>
      </div>

      <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" name="description" class="form-control" rows="4"
                  required>{{ old('description', $tip->description) }}</textarea>
      </div>

      <div class="form-group">
        <label for="category">Category:</label>
        <input type="text" id="category" name="category" class="form-control"
               value="{{ old('category', $tip->category) }}" required>
      </div>
      <div class="flex justify-content-between mt-1">
        <button type="submit" class="btn btn-primary btn-block ">Update Tip</button>
        <a href="{{ route('recycling-tips.my-tips') }}" class="btn btn-secondary">Back to My Tips</a>
      </div>
    </form>

  </div>
@endsection
