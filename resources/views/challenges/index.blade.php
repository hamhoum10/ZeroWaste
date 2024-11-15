@extends('layouts.front')

@section('content')
  <div class="container py-5" style="height: 80vh; margin-top: 50px">
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
              @if($challenge->users->contains(Auth::id()))
                <form action="{{ route('challenges.leave', $challenge->id) }}" method="POST" style="display:inline;">
                  @csrf
                  <button type="submit" class="btn btn-danger btn-sm"
                          onclick="return confirm('Are you sure you want to leave this challenge?');">Leave
                  </button>
                </form>
              @else
                <form action="{{ route('challenges.participate', $challenge->id) }}" method="POST"
                      style="display:inline;">
                  @csrf
                  <button type="submit" class="btn btn-success btn-sm">Participate</button>
                </form>
              @endif
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    @endif
  </div>
@endsection
