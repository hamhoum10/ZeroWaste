

@extends('layouts/contentNavbarLayout')

@section('content')
  <h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Forms /</span> Edit Category
  </h4>

  <div class="row">
    <div class="col-xl">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Edit Category</h5>
          <div>
            <!-- Link to Manage Categories -->
            <a href="{{ route('categories.index') }}" class="btn btn-secondary me-2">
              <i class="bx bx-category-alt me-1"></i> Manage Categories
            </a>

            <!-- Link to Best Practices -->
            <a href="{{ route('back_office.best_practices.index') }}" class="btn btn-secondary">
              <i class="bx bx-list-ul me-1"></i> View Best Practices
            </a>
          </div>
        </div>

        <div class="card-body">
          <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Category Name Input -->
            <div class="mb-3">
              <label class="form-label" for="name">Category Name:</label>
              <input type="text" class="form-control" id="name" name="name"
                     value="{{ old('name', $category->name) }}" required
                     placeholder="Enter Category Name">
            </div>

            <!-- Error Handling -->
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <button type="submit" class="btn btn-primary">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
