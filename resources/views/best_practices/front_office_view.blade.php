@extends('layouts/front')

@section('content')
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card h-100 shadow-lg p-4">

          <!-- Best Practice Image -->
          @if ($bestPractice->image)
            <div class="text-center mb-4">
              <img src="{{ asset('storage/' . $bestPractice->image) }}"
                   alt="{{ $bestPractice->title }}"
                   class="img-fluid rounded"
                   style="max-width: 100%; height: auto;">
            </div>
          @endif

          <!-- Best Practice Content -->
          <div class="card-body">
            <h3 class="card-title mb-3 text-primary">{{ $bestPractice->title }}</h3>
            <h6 class="card-subtitle text-muted mb-4">
              <strong>Category:</strong> {{ $bestPractice->category->name }}
            </h6>

            <p class="card-text mb-3">
              <strong>Contents:</strong><br>
              <span class="text-dark">{{ $bestPractice->contents }}</span>
            </p>

            <p class="card-text">
              <strong>Tags:</strong>
              <span class="badge bg-secondary">
                            #{{ $bestPractice->tags ?? 'No tags available' }}
                        </span>
            </p>
          </div>

          <!-- Comments Section -->
          <section class="bg-light p-4 mt-4 rounded">
            <div class="text-end mb-4">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCommentModal">
                Add Comment
              </button>
            </div>

            <!-- Display Existing Comments -->
            @foreach ($bestPractice->comments as $comment)
              <div class="d-flex flex-start mb-4">
                <img class="rounded-circle shadow-1-strong me-3" src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(32).webp" alt="avatar" width="65" height="65" />
                <div class="card w-100">
                  <div class="card-body p-4">
                    <h5>{{ $comment->user->name }}</h5> <!-- Display user's name -->
                    <p class="small text-muted">{{ $comment->created_at->diffForHumans() }}</p>
                    <p>
                      <span class="comment-content">{{ $comment->content }}</span>
                    </p>
                    <div class="d-flex justify-content-end">
                      <!-- Edit Comment Button -->
                      <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editCommentModal-{{ $comment->id }}">
                        Edit
                      </button>
                      <!-- Delete Comment Button -->
                      <form action="{{ route('comments.destroy', [$bestPractice, $comment]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Modal for Editing a Comment -->
              <div class="modal fade" id="editCommentModal-{{ $comment->id }}" tabindex="-1" aria-labelledby="editCommentModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="editCommentModalLabel">Edit Comment</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="{{ route('comments.update', [$bestPractice, $comment]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                          <label for="commentText-{{ $comment->id }}" class="form-label">Comment</label>
                          <textarea class="form-control" id="commentText-{{ $comment->id }}" name="content" rows="3" required>{{ $comment->content }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Comment</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach



          </section>

          <!-- Modal for Adding a Comment -->
          <div class="modal fade" id="addCommentModal" tabindex="-1" aria-labelledby="addCommentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="addCommentModalLabel">Add Comment</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="{{ route('comments.store', $bestPractice) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                      <label for="commentText" class="form-label">Comment</label>
                      <textarea class="form-control" id="commentText" name="content" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Comment</button>
                  </form>
                </div>
              </div>
            </div>
          </div>


          <!-- Back Link -->
          <div class="card-footer bg-light text-center mt-4">
            <a href="{{ route('best_practices.front_office') }}" class="text-decoration-none">Back to Best Practices</a>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
