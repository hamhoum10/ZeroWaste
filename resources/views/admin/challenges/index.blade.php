@extends('layouts.contentNavbarLayout')

@section('content')
  <div class="container py-5">
    <h1 class="text-center mb-4">Challenges Management</h1>
    <div class="text-right mb-4">
      <a href="{{ route('admin.challenges.create') }}" class="btn btn-primary">Create New Challenge</a>
    </div>

    @if ($challenges->isEmpty())
      <p class="text-center">No challenges available.</p>
    @else
      <table class="table table-bordered">
        <thead class="thead-dark">
        <tr>
          <th>Title</th>
          <th>Description</th>
          <th>Category</th>
          <th>Start Date</th>
          <th>End Date</th>
          <th>Status</th>
          <th>Participants</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($challenges as $challenge)
          <tr class="{{ $challenge->status == 'Ended' ? 'bg-light-red' : ''}}">
            <td>{{ $challenge->title }}</td>
            <td>{{ $challenge->description }}</td>
            <td>{{ $challenge->category }}</td>
            <td>{{ \Carbon\Carbon::parse($challenge->start_date)->format('d M Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($challenge->end_date)->format('d M Y') }}</td>
            <td>{{ $challenge->status }}</td>
            <td>{{ $challenge->participants_count }}</td>
            <td>
              <a href="{{ route('admin.challenges.edit', $challenge->id) }}" style="width: 60px; margin-bottom: 10px"
                 class="btn btn-warning btn-sm">Edit</a>
              <form action="{{ route('admin.challenges.delete', $challenge->id) }}" method="POST"
                    style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm" style="width: 60px"
                        onclick="return confirm('Are you sure you want to delete this challenge?');">Delete
                </button>
              </form>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
      <div class="d-flex justify-content-end mt-4">
        {{ $challenges->links('pagination::bootstrap-5') }}
      </div>
    @endif
  </div>
@endsection
