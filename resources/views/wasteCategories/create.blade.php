@extends('layouts/contentNavbarLayout')

@section('content')
  <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="w-100">
      <h1>Create New Waste Category</h1>

      <form action="{{ route('wastecategories.store') }}" method="POST">
        @csrf
        <div class="form-group">
          <label for="name">Waste Category Name:</label>
          <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="form-group mt-3">
          <label for="description">Description:</label>
          <textarea name="description" id="description" class="form-control" rows="3" maxlength="500" placeholder="Enter a description (optional)"></textarea>
        </div>

        <br>
        <button type="submit" class="btn btn-primary">Create Waste Category</button>
        <a href="{{ route('wastecategories.index') }}" class="btn btn-secondary">Back</a>
      </form>
    </div>
  </div>
@endsection
