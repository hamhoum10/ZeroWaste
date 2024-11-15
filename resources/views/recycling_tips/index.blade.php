@extends('layouts/front')

@section('content')
  <div class="container py-5">
    <div class="">
      <h1 class="text-center mb-5">Recycling Tips</h1>
      <div style="width: 100%; text-align: end">
        <a class="btn btn-outline-dark text-uppercase" style="font-size: 12px"
                href="{{ url('/my-recycling-tips') }}">show yours
        </a>

      </div>
    </div>
    <div class="row">
      @foreach ($tips as $tip)
        <div class="col-md-6 mb-4">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <h2 class="card-title">{{ $tip->title }}</h2>
              <p class="card-text">{{ $tip->description }}</p>
              <small class="text-muted">Category: {{ $tip->category }} | Likes: {{ $tip->likes_count }}</small>

              @if (!$tip->likedByUsers->contains(auth()->id()))
                <form action="{{ route('recycling-tips.like', $tip->id) }}" method="POST" class="mt-3">
                  @csrf
                  <button type="submit" class="btn btn-primary btn-sm">Like</button>
                </form>
              @else
                <p class="mt-3 text-success">You already liked this tip.</p>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection
