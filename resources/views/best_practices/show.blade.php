@extends('layouts/contentNavbarLayout')

@section('content')
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6"> <!-- Wider layout -->
        <div class="card h-100 shadow-lg p-3"> <!-- Taller card with padding -->

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
            <h3 class="card-title mb-3">{{ $bestPractice->title }}</h3>
            <h6 class="card-subtitle text-muted mb-3">
              Category: {{ $bestPractice->category->name }}
            </h6>



            <p class="card-text">
              <strong>Tags:</strong>
              {{ $bestPractice->tags ? $bestPractice->tags : 'No tags available' }}
            </p>
          </div>

          <div class="card-footer bg-white d-flex justify-content-between">
            <a href="{{ route('best_practices.index') }}" class="card-link">Back to Best Practices</a>
            <a href="javascript:void(0);" class="card-link">Another link</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
