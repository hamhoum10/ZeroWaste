@extends('layouts/contentNavbarLayout')

@section('content')
  <div class="container my-4">
    <h1 class="mb-4 text-center">Categories</h1>

    <!-- Create button -->
    <div class="text-end mb-3">
      <a href="{{ route('categories.create') }}" class="btn btn-primary">Create New Category</a>
    </div>

    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    <div class="list-group">
      @foreach ($categories as $category)
        <div class="list-group-item d-flex justify-content-between align-items-center">
          <span>{{ $category->name }}</span>
          <div>
            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm me-2">Edit</a>
            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?');">Delete</button>
            </form>
          </div>
        </div>
      @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="mt-3">
      {{ $categories->links() }}
    </div>
  </div>
@endsection
