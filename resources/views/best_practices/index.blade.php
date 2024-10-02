@extends('layouts/contentNavbarLayout')

@section('content')
  <div class="container my-4">
    <h1 class="mb-4 text-center">Best Practices Guide</h1>

    <!-- Create button -->
    <div class="text-end mb-3">
      <a href="{{ route('best_practices.create') }}" class="btn btn-primary">Create New Best Practice</a>
    </div>

    <div class="list-group">
      @foreach ($bestPractices as $bestPractice)
        <div class="list-group-item border rounded shadow-sm mb-3 p-3">
          <h5 class="mb-1">
            <a href="{{ route('best_practices.show', $bestPractice->id) }}" class="text-decoration-none text-dark">
              {{ $bestPractice->title }}
            </a>
          </h5>
          <p class="mb-1 text-muted">{{ Str::limit($bestPractice->contents, 100) }}</p> <!-- Display a short excerpt of contents -->
          <p class="mb-1"><strong>Tags:</strong> #{{ Str::limit($bestPractice->tags, 100) }}</p> <!-- Display a short excerpt of tags with # -->
          <p class="mb-1"><strong>Category:</strong> {{ $bestPractice->category->name }}</p>
          <small class="text-muted">Last updated: {{ $bestPractice->updated_at->format('M d, Y') }}</small>

          <!-- Edit and Delete Buttons -->
          <div class="mt-2">
            <a href="{{ route('best_practices.edit', $bestPractice->id) }}" class="btn btn-warning btn-sm me-2">Edit</a>
            <form action="{{ route('best_practices.destroy', $bestPractice->id) }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this best practice?');">Delete</button>
            </form>
          </div>
        </div>
      @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="mt-3">
      {{ $bestPractices->links() }}
    </div>
  </div>
@endsection
