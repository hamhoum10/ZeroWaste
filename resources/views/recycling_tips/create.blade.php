@extends('layouts/front')

@section('content')
  <div class="container py-5">
    <h1 class="text-center mb-4">Create Recycling Tip</h1>
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow-sm">
          <div class="card-body">
            <form action="{{ route('recycling-tips.store') }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
              </div>
              <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" name="category" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-primary btn-block mt-2">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
