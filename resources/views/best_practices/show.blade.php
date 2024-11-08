
@extends('layouts/contentNavbarLayout')

@section('content')
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6"> <!-- Wider layout -->
        <div class="card h-100 shadow-lg p-4"> <!-- Taller card with padding -->

          <!-- Display the image if it exists -->
          @if ($bestPractice->image)
            <div class="text-center mb-4">
              <img src="{{ asset('storage/' . $bestPractice->image) }}"
                   alt="{{ $bestPractice->title }}"
                   class="img-fluid rounded"
                   style="max-width: 100%; height: auto;">
            </div>
          @endif

          <div class="card-body">
            <h3 class="card-title mb-3 text-primary">{{ $bestPractice->title }}</h3>
            <h6 class="card-subtitle text-muted mb-4">
              <strong>Category:</strong> {{ $bestPractice->category->name }}
            </h6>

            <p class="card-text mb-3">
              <strong>Contents:</strong>
              <br>
              <span class="text-dark">{{ $bestPractice->contents }}</span> <!-- Displaying the full contents -->
            </p>

            <p class="card-text">
              <strong>Tags:</strong>
              <span class="badge bg-secondary">{{ $bestPractice->tags ? $bestPractice->tags : 'No tags available' }}</span>
            </p>
          </div>

          <div class="card-footer bg-light d-flex justify-content-center">
            <!-- Corrected Link -->
            <a href="{{ url('best-practices-BackOffice/best_practices') }}" class="card-link text-decoration-none">
              Back to Best Practices
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
