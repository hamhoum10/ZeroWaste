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

            <!-- Comments -->
            <div class="d-flex flex-start mb-4">
              <img class="rounded-circle shadow-1-strong me-3"
                   src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(32).webp"
                   alt="avatar" width="65" height="65" />
              <div class="card w-100">
                <div class="card-body p-4">
                  <h5>Johny Cash</h5>
                  <p class="small text-muted">3 hours ago</p>
                  <p>
                    Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque
                    ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus
                    viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla.
                    Donec lacinia congue felis in faucibus.
                  </p>
                </div>
              </div>
            </div>

            <div class="d-flex flex-start">
              <img class="rounded-circle shadow-1-strong me-3"
                   src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(31).webp"
                   alt="avatar" width="65" height="65" />
              <div class="card w-100">
                <div class="card-body p-4">
                  <h5>Mindy Campbell</h5>
                  <p class="small text-muted">5 hours ago</p>
                  <p>
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Delectus
                    cumque doloribus dolorum dolor repellat nemo animi at iure autem fuga
                    cupiditate architecto ut quam provident neque, inventore nisi eos quas?
                  </p>
                </div>
              </div>
            </div>
          </section>

          <!-- Modal for Adding a Comment -->
          <div class="modal fade" id="addCommentModal" tabindex="-1" aria-labelledby="addCommentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="addCommentModalLabel">Add a Comment</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="mb-3">
                      <label for="commenterName" class="form-label">Name</label>
                      <input type="text" class="form-control" id="commenterName" placeholder="Enter your name">
                    </div>
                    <div class="mb-3">
                      <label for="commentText" class="form-label">Comment</label>
                      <textarea class="form-control" id="commentText" rows="3" placeholder="Write your comment here"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Post Comment</button>
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
