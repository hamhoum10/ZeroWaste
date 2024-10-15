@extends('layouts/contentNavbarLayout')

@section('content')
  <div class="container my-5">
    <h1 class="mb-4 text-center">Best Practices Guide</h1>

    <!-- Create button -->
    <div class="text-end mb-4">
      <a href="{{ route('best_practices.create') }}" class="btn btn-primary">Create New Best Practice</a>
    </div>

    <div class="row">
      @foreach ($bestPractices as $bestPractice)
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="card h-100 shadow-sm">
            <!-- Display the image if it exists -->
            @if ($bestPractice->image)
              <img src="{{ asset('storage/' . $bestPractice->image) }}"
                   alt="{{ $bestPractice->title }}"
                   class="card-img-top img-fluid"
                   style="height: 200px; object-fit: cover;"
                   data-bs-toggle="modal"
                   data-bs-target="#imageModal{{ $bestPractice->id }}" />
            @endif

            <div class="card-body d-flex flex-column">
              <h5 class="card-title">
                <a href="{{ route('best_practices.show', $bestPractice->id) }}"
                   class="text-decoration-none text-dark">
                  {{ $bestPractice->title }}
                </a>
              </h5>


              <div class="mt-auto"> <!-- Pushes the action links to the bottom -->
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                    <strong>Tags:</strong> #{{ Str::limit($bestPractice->tags, 100) }}
                  </li>
                  <li class="list-group-item">
                    <strong>Category:</strong> {{ $bestPractice->category->name }}
                  </li>
                  <li class="list-group-item text-muted">
                    Last updated: {{ $bestPractice->updated_at->format('M d, Y') }}
                  </li>
                </ul>
                <div class="card-body">
                  <a href="{{ route('best_practices.edit', $bestPractice->id) }}"
                     class="card-link">Edit</a>
                  <form action="{{ route('best_practices.destroy', $bestPractice->id) }}"
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
          </div>

          <!-- Modal for displaying the full image -->
          <div class="modal fade" id="imageModal{{ $bestPractice->id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $bestPractice->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="imageModalLabel{{ $bestPractice->id }}">{{ $bestPractice->title }}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                  <img src="{{ asset('storage/' . $bestPractice->image) }}" alt="{{ $bestPractice->title }}" class="img-fluid" />
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
              </div>
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
