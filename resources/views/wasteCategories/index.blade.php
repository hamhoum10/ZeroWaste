{{-- resources/views/wastecategories/index.blade.php --}}
@extends('layouts.contentNavbarLayout')

@section('content')
  <div class="container">
    <h1>Waste Categories</h1>

    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    <a href="{{ route('wastecategories.create') }}" class="btn btn-primary mb-3">Create New Waste Category</a>

    <table class="table">
      <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th> <!-- Added Description Column -->
        <th>Actions</th>
      </tr>
      </thead>
      <tbody>
      @foreach ($wastecategories as $wasteCategory)
        <tr>
          <td>{{ $wasteCategory->id }}</td>
          <td>{{ $wasteCategory->name }}</td>
          <td>{{ $wasteCategory->description }}</td> <!-- Display Description -->
          <td>
            <a href="{{ route('wastecategories.edit', $wasteCategory->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('wastecategories.destroy', $wasteCategory->id) }}" method="POST" style="display: inline;">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
            </form>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection
