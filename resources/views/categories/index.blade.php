

@extends('layouts/contentNavbarLayout')

@section('content')
  <div class="container my-5">
    <h1 class="mb-5 text-center fw-bold">Category Management</h1>

    <!-- Success Alert -->
    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <!-- Action Buttons -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-semibold">All Categories</h4>
      <div>
        <!-- Navigate to Best Practices -->
        <a href="{{ route('back_office.best_practices.index') }}" class="btn btn-secondary btn-lg me-2">
          <i class="bx bx-list-ul me-1"></i> View Best Practices
        </a>

        <!-- Create New Category -->
        <a href="{{ route('categories.create') }}" class="btn btn-primary btn-lg">
          <i class="bx bx-plus me-1"></i> Create New Category
        </a>
      </div>
    </div>

    <!-- Category List -->
    <div class="list-group shadow-sm rounded-3">
      @forelse ($categories as $category)
        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
          <span class="fs-5">{{ $category->name }}</span>
          <div class="d-flex">
            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-outline-warning btn-sm me-2">
              <i class="bx bx-edit-alt"></i> Edit
            </a>

            <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this category?');" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-outline-danger btn-sm">
                <i class="bx bx-trash"></i> Delete
              </button>
            </form>
          </div>
        </div>
      @empty
        <div class="list-group-item text-center py-4">
          <p class="text-muted mb-0">No categories found.</p>
        </div>
      @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-center">
      {{ $categories->links('pagination::bootstrap-5') }}
    </div>
  </div>
@endsection
