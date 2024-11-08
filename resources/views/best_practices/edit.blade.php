
@extends('layouts/contentNavbarLayout')

@section('content')
  <h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Forms /</span> Edit Best Practice
  </h4>

  <div class="row">
    <div class="col-xl">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Edit Best Practice</h5>
          <div>
            <!-- Link to Manage Categories -->
            <a href="{{ route('categories.index') }}" class="btn btn-secondary me-2">
              <i class="bx bx-category-alt me-1"></i> Manage Categories
            </a>

            <!-- Link to View Best Practices -->
            <a href="{{ route('back_office.best_practices.index') }}" class="btn btn-secondary">
              <i class="bx bx-list-ul me-1"></i> View Best Practices
            </a>
          </div>
        </div>

        <div class="card-body">
          <form action="{{ route('back_office.best_practices.update', $bestPractice->id) }}"
                method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Title Input -->
            <div class="mb-3">
              <label class="form-label" for="title">Title:</label>
              <input type="text" class="form-control" id="title" name="title"
                     value="{{ old('title', $bestPractice->title) }}" required placeholder="Enter Title">
              @error('title')
              <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>

            <!-- Contents Input -->
            <div class="mb-3">
              <label class="form-label" for="contents">Contents:</label>
              <textarea class="form-control" id="contents" name="contents" required
                        placeholder="Enter Contents">{{ old('contents', $bestPractice->contents) }}</textarea>
              @error('contents')
              <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>

            <!-- Category Dropdown -->
            <div class="mb-3">
              <label class="form-label" for="category_id">Category:</label>
              <select class="form-select" id="category_id" name="category_id" required>
                @foreach ($categories as $category)
                  <option value="{{ $category->id }}"
                    {{ $category->id == $bestPractice->category_id ? 'selected' : '' }}>
                    {{ $category->name }}
                  </option>
                @endforeach
              </select>
              @error('category_id')
              <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>

            <!-- Tags Input -->
            <div class="mb-3">
              <label class="form-label" for="tags">Tags:</label>
              <input type="text" class="form-control" id="tags" name="tags"
                     value="{{ old('tags', $bestPractice->tags) }}" placeholder="Enter Tags">
              @error('tags')
              <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>

            <!-- Image Upload -->
            <div class="mb-3">
              <label class="form-label" for="image">Image:</label>
              <input type="file" class="form-control" id="image" name="image">
              @if ($bestPractice->image)
                <div class="mt-2">
                  <img src="{{ asset('storage/' . $bestPractice->image) }}"
                       alt="Current Image" style="max-width: 200px; height: auto;">
                </div>
              @endif
              @error('image')
              <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
