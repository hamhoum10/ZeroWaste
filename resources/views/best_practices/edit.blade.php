@extends('layouts/contentNavbarLayout')

@section('content')
  <h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Forms/</span> Edit Best Practice
  </h4>

  <div class="row">
    <div class="col-xl">
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">Edit Best Practice</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('best_practices.update', $bestPractice->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label class="form-label" for="title">Title:</label>
              <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $bestPractice->title) }}" required placeholder="Enter Title">
              @error('title')
              <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label class="form-label" for="contents">Contents:</label>
              <textarea class="form-control" id="contents" name="contents" required placeholder="Enter Contents">{{ old('contents', $bestPractice->contents) }}</textarea>
              @error('contents')
              <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label class="form-label" for="category_id">Category:</label>
              <select class="form-select" id="category_id" name="category_id" required>
                @foreach ($categories as $category)
                  <option value="{{ $category->id }}" {{ $category->id == $bestPractice->category_id ? 'selected' : '' }}>
                    {{ $category->name }}
                  </option>
                @endforeach
              </select>
              @error('category_id')
              <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label class="form-label" for="tags">Tags:</label>
              <input type="text" class="form-control" id="tags" name="tags" value="{{ old('tags', $bestPractice->tags) }}" placeholder="Enter Tags">
              @error('tags')
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
