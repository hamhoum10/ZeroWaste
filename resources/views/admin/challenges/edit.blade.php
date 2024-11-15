@extends('layouts.contentNavbarLayout')

@section('content')
  <div class="container py-5">
    <h1 class="text-center mb-4">Edit Challenge</h1>

    <!-- Display Validation Errors -->
    @if($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('admin.challenges.update', $challenge->id) }}" method="POST" class="bg-light p-4 rounded shadow">
      @csrf
      <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $challenge->title) }}" required>
      </div>

      <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" name="description" class="form-control" required>{{ old('description', $challenge->description) }}</textarea>
      </div>

      <div class="form-group">
        <label for="category">Category:</label>
        <input type="text" id="category" name="category" class="form-control" value="{{ old('category', $challenge->category) }}" required>
      </div>

      <div class="form-group">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" class="form-control" value="{{ old('start_date', $challenge->start_date) }}" required>
      </div>

      <div class="form-group">
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" class="form-control" value="{{ old('end_date', $challenge->end_date) }}" required>
      </div>

      <button type="submit" class="btn btn-primary">Update Challenge</button>
    </form>

    <div class="mt-3">
      <a href="{{ route('admin.challenges.index') }}" class="btn btn-secondary">Back to Challenges</a>
    </div>
  </div>
@endsection
