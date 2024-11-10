@extends('layouts.front')

@section('content')
  <div class="container py-5">
    <h1 class="text-center mb-4">Ongoing and Upcoming Challenges</h1>

    @if ($challenges->isEmpty())
      <p class="text-center">No challenges available at the moment.</p>
    @else
      <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
          <th>Title</th>
          <th>Description</th>
          <th>Category</th>
          <th>Start Date</th>
          <th>End Date</th>
          <th>Participants</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($challenges as $challenge)
          <tr>
            <td>{{ $challenge->title }}</td>
            <td>{{ $challenge->description }}</td>
            <td>{{ $challenge->category }}</td>
            <td>{{ \Carbon\Carbon::parse($challenge->start_date)->format('d M Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($challenge->end_date)->format('d M Y') }}</td>
            <td>{{ $challenge->participants_count }}</td>
            <td>
              <form action="{{ route('challenges.participate', $challenge->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-success btn-sm">Participate</button>
              </form>
              <form action="{{ route('challenges.leave', $challenge->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to leave this challenge?');">Leave</button>
              </form>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    @endif

    <h2 class="mt-5">Suggest a New Challenge</h2>
    <form action="{{ route('challenges.suggest') }}" method="POST" class="mt-4">
      @csrf
      <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" name="description" class="form-control" required></textarea>
      </div>

      <div class="form-group">
        <label for="category">Category:</label>
        <input type="text" id="category" name="category" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-primary">Suggest Challenge</button>
    </form>
  </div>
@endsection
