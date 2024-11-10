@extends('layouts.contentNavbarLayout')

@section('content')
  <div class="container py-5">
    <h1 class="text-center mb-4">Pending Recycling Tips</h1>

    @if ($tips->isEmpty())
      <p class="text-center">No pending tips to review.</p>
    @else
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead class="thead-dark">
          <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Category</th>
            <th>Posted By</th>
            <th>Actions</th>
          </tr>
          </thead>
          <tbody>
          @foreach ($tips as $tip)
            <tr>
              <td>{{ $tip->title }}</td>
              <td>{{ $tip->description }}</td>
              <td>{{ $tip->category }}</td>
              <td>{{ $tip->user->name ?? 'Unknown' }}</td>
              <td class="d-flex align-items-center justify-content-center gap-2">
                <form action="{{ route('admin.recycling-tips.approve', $tip->id) }}" method="POST" style="display: inline-block;">
                  @csrf
                  <button type="submit" class="btn btn-success btn-sm">Approve</button>
                </form>

                <form action="{{ route('admin.recycling-tips.reject', $tip->id) }}" method="POST" style="display: inline-block;">
                  @csrf
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to reject this tip?')">Reject</button>
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
