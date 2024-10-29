@extends('layouts.contentNavbarLayout')

@section('content')
  <h2>User Logs</h2>

  <!-- Search Form -->
  <form method="GET" action="{{ route('admin.user-logs') }}" class="mb-4">
    <div class="row">
      <div class="col-md-3">
        <input type="text" name="user" class="form-control" placeholder="Search by User" value="{{ request('user') }}">
      </div>
      <div class="col-md-3">
        <input type="text" name="action" class="form-control" placeholder="Search by Action"
               value="{{ request('action') }}">
      </div>
      <div class="col-md-3">
        <input type="date" name="date" class="form-control" value="{{ request('date') }}">
      </div>
      <div class="col-md-3">
        <button type="submit" class="btn btn-primary">Search</button>
        <a href="{{ route('admin.user-logs') }}" class="btn btn-secondary">Clear</a>
      </div>
    </div>
  </form>

  <table class="table">
    <thead>
    <tr>
      <th>User</th>
      <th>Action</th>
      <th>Description</th>
      <th>Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($logs as $log)
      <tr>
        <td>{{ $log->user->name }}</td>
        <td>{{ $log->action }}</td>
        <td>{{ $log->description }}</td>
        <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td> <!-- Date formatting -->
      </tr>
    @endforeach
    </tbody>
  </table>
  <!-- Pagination -->
  <div class="d-flex justify-content-end mt-4">
    {{ $logs->links('pagination::bootstrap-5') }}
  </div>
@endsection
