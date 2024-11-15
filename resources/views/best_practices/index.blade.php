@extends('layouts/contentNavbarLayout')

@section('content')
  <div class="container my-5">
    <h1 class="mb-4 text-center">Best Practices Guide</h1>

    <!-- Buttons: Create New Best Practice & Manage Categories -->
    <div class="d-flex justify-content-end mb-4">
      <a href="{{ route('categories.index') }}" class="btn btn-secondary me-2">Manage Categories</a>
      <a href="{{ route('back_office.best_practices.create') }}" class="btn btn-primary">
        Create New Best Practice
      </a>
    </div>

    <!-- Search form -->
    <form method="GET" action="{{ route('back_office.best_practices.index') }}" class="mb-4">
      <div class="input-group">
        <input type="text" class="form-control" name="search" value="{{ request('search') }}"
               placeholder="Search Best Practices">
        <button class="btn btn-outline-secondary" type="submit">Search</button>
      </div>
    </form>

    <div class="row">
      @foreach ($bestPractices as $bestPractice)
        <div class="col-md-6 col-lg-4 mb-3">
          <div class="card h-100">
            <div class="card-body">
              <h5 class="card-title">
                <a href="{{ route('back_office.best_practices.show', $bestPractice->id) }}"
                   class="text-decoration-none text-dark">
                  {{ $bestPractice->title }}
                </a>
              </h5>
              <h6 class="card-subtitle text-muted">{{ $bestPractice->category->name }}</h6>
            </div>

            @if ($bestPractice->image)
              <img class="img-fluid"
                   src="{{ asset($bestPractice->image) }}"
                   alt="{{ $bestPractice->title }}"/>
            @endif

            <div class="card-body">
              <p class="card-text">#{{ Str::limit($bestPractice->tags, 100) }}</p>
              <a href="{{ route('back_office.best_practices.edit', $bestPractice->id) }}" class="card-link">Edit</a>

              <form action="{{ route('back_office.best_practices.destroy', $bestPractice->id) }}"
                    method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="card-link text-danger border-0 bg-transparent"
                        onclick="return confirm('Are you sure you want to delete this best practice?');">
                  Delete
                </button>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="mt-4">
      {{ $bestPractices->links() }}
    </div>
  </div>
@endsection
