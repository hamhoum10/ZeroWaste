@extends('layouts/contentNavbarLayout')

@section('content')
  <div class="container my-4">
    <h1 class="mb-3">{{ $bestPractice->title }}</h1>

    <div class="card mb-4">
      <div class="card-body">
        <p class="card-text">{{ $bestPractice->contents }}</p>

        <p class="card-text"><strong>Category:</strong> {{ $bestPractice->category->name }}</p>
        <p class="card-text"><strong>Tags:</strong> {{ $bestPractice->tags ? $bestPractice->tags : 'No tags available' }}</p>
      </div>
    </div>

    <a href="{{ route('best_practices.index') }}" class="btn btn-secondary">Back to Best Practices</a>
  </div>
@endsection
