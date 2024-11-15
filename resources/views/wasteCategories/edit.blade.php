@extends('layouts.contentNavbarLayout')

@section('content')
  <div class="container">
    <h1>Edit Waste Category</h1>

    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    <form action="{{ route('wastecategories.update', $wasteCategory->id) }}" method="POST"> <!-- Update the primary key reference -->
      @csrf
      @method('PUT')

      <div class="form-group">
        <label for="name">Category Name:</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $wasteCategory->name) }}">
        @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mt-3">
        <label for="description">Description:</label>
        <textarea name="description" id="description" class="form-control" rows="3" maxlength="500" placeholder="Enter a description (optional)">{{ old('description', $wasteCategory->description) }}</textarea>
        @error('description')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary">Update Waste Category</button>
      <a href="{{ route('wastecategories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
@endsection
