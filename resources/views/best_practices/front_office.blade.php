@extends('layouts/contentNavbarLayout')

@section('content')
  <div class="container my-5">
    <h1 class="mb-4 text-center">Best Practices</h1>

    <div class="row">
      @foreach ($bestPractices as $bestPractice)
        <div class="col-md-6 col-lg-4 mb-4"> <!-- Changed to mb-4 for better spacing -->
          <div class="card h-100 shadow-sm"> <!-- Added shadow for depth -->
            <!-- Display the image if it exists -->
            @if ($bestPractice->image)
              <img class="card-img-top img-fluid"
                   src="{{ asset('storage/' . $bestPractice->image) }}"
                   alt="{{ $bestPractice->title }}"
                   style="height: 200px; object-fit: cover;" />
            @endif

            <div class="card-body">
              <h5 class="card-title">
                <a href="{{ route('best_practices.show', $bestPractice->id) }}" class="text-decoration-none text-dark">
                  {{ $bestPractice->title }}
                </a>
              </h5>
              <h6 class="card-subtitle text-muted">{{ $bestPractice->category->name }}</h6>
              <p class="card-text">Tags: #{{ Str::limit($bestPractice->tags, 100) }}</p>
            </div>

            <div class="card-footer text-center">
              <a href="{{ route('best_practices.show', $bestPractice->id) }}" class="btn btn-primary">View Details</a>
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
