{{-- @php
  $isNavbar = false;
  $isMenu = false;
$navbarHideToggle = false;
@endphp --}}
@extends('layouts/contentNavbarLayout')

@section('content')
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Create Category</h4>

  <div class="row">
    <div class="col-xl">
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">Add New Category</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('categories.store') }}" method="POST">
            @csrf

            <div class="mb-3">
              <label class="form-label" for="name">Category Name:</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required placeholder="Enter Category Name">
            </div>

            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
