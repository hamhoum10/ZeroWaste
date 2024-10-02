@extends('layouts/contentNavbarLayout')

@section('content')
  <div class="container mt-4">
    <div class="card">
      <div class="card-header">
        <h3>Waste Category: {{ $wasteCategory->name }}</h3>
      </div>
      <div class="card-body">
        <p><strong>Description:</strong> {{ $wasteCategory->description }}</p>
        <p><strong>Created At:</strong> {{ $wasteCategory->created_at->format('Y-m-d \a\t H:i') }}</p>
        <p><strong>Updated At:</strong> {{ $wasteCategory->updated_at->format('Y-m-d \a\t H:i') }}</p>
      </div>
      <div class="card-footer text-end">
        <a href="{{ route('wastecategories.index') }}" class="btn btn-secondary">Back to Categories</a>
      </div>
    </div>
  </div>
@endsection
