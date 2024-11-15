@extends('layouts.contentNavbarLayout')

@section('content')
  <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-xl">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Create New Waste Category</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('wastecategories.store') }}" method="POST">
            @csrf

            <div class="mb-3">
              <label class="form-label" for="name">Waste Category Name:</label>
              <div class="input-group input-group-merge">
                <span class="input-group-text"><i class="bx bx-category"></i></span>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter category name" value="{{ old('name') }}">
              </div>
              @error('name')
              <div class="alert alert-danger mt-2">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label class="form-label" for="description">Description:</label>
              <div class="input-group input-group-merge">
                <span class="input-group-text"><i class="bx bx-info-circle"></i></span>
                <textarea name="description" id="description" class="form-control" rows="3" maxlength="500" placeholder="Enter a description (optional)">{{ old('description') }}</textarea>
              </div>
              @error('description')
              <div class="alert alert-danger mt-2">{{ $message }}</div>
              @enderror
            </div>

            <button type="submit" class="btn btn-primary">Create Waste Category</button>
            <a href="{{ route('wastecategories.index') }}" class="btn btn-secondary">Back</a>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
