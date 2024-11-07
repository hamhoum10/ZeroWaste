@extends('layouts/front')

@section('content')
  <div class="container py-5">
    <h1 class="text-center mb-4">My Recycling Tips</h1>

    <div class="text-right mb-4">
      <a href="{{ route('recycling-tips.create') }}" class="btn btn-primary">Create New recycle Tip</a>
    </div>

    @if ($tips->isEmpty())
      <p class="text-center">You have not created any tips yet.</p>
    @else
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead class="thead-dark">
          <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Category</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
          </thead>
          <tbody>
          @foreach ($tips as $tip)
            <tr>
              <td>{{ $tip->title }}</td>
              <td>{{ $tip->description }}</td>
              <td>{{ $tip->category }}</td>
              <td>{{ $tip->approved ? "Approved" : "Pending"}}</td>
              <td class="inline-block gap-2">
                <a href="{{ route('recycling-tips.edit', $tip->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('recycling-tips.delete', $tip->id) }}" method="POST"
                      style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm"
                          onclick="return confirm('Are you sure you want to delete this tip?');">
                    Delete
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>
@endsection
