@extends('layouts/contentNavbarLayout')

@section('content')
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    .btn-spacing {
      margin-bottom: 10px; /* Add space below buttons */
    }

    .btn-edit {
      background-color: orange; /* Set edit button color to orange */
      color: white; /* Ensure text is readable */
    }

    .search-bar-container {
      position: relative;
      margin-bottom: 20px; /* Add space below search bar */
    }

    .search-bar {
      width: 100%;
      padding-left: 40px; /* Add padding for icon */
    }

    .search-icon {
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      color: #6c757d; /* Bootstrap's text-secondary color */
    }
  </style>

  <div class="container">
    <h1>Waste Categories</h1>

    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    <!-- Search Bar -->
    <div class="search-bar-container">
      <i class="bx bx-search search-icon"></i> <!-- Search Icon -->
      <input type="text" id="search" class="form-control search-bar" placeholder="Search Waste Categories" aria-label="Search">
    </div>

    <a href="{{ route('wastecategories.create') }}" class="btn btn-primary mb-3">Create New Waste Category</a>

    <table class="table table-striped" id="wasteCategoriesTable">
      <thead>
      <tr>
        <th>Name</th>
        <th>Description</th> <!-- Added Description Column -->
        <th>Actions</th>
      </tr>
      </thead>
      <tbody>
      @foreach ($wastecategories as $wasteCategory)
        <tr>
          <td>{{ $wasteCategory->name }}</td>
          <td>{{ $wasteCategory->description }}</td> <!-- Display Description -->
          <td>
            <div class="d-flex flex-row">
              <a href="{{ route('wastecategories.edit', $wasteCategory->id) }}" class="btn rounded-pill btn-edit btn-spacing">
                <i class="bx bx-edit-alt me-1"></i> Edit
              </a>
              <form action="{{ route('wastecategories.destroy', $wasteCategory->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn rounded-pill btn-danger btn-spacing" onclick="return confirm('Are you sure you want to delete this category?')">
                  <i class="bx bx-trash me-1"></i> Delete
                </button>
              </form>
            </div>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>

    <!-- Pagination -->
    <div class="card mb-4">
      <h5 class="card-header">Pagination</h5>
      <div class="card-body">
        <div class="row">
          <div class="col text-center">
            <!-- Laravel's built-in pagination links -->
            {{ $wastecategories->links('pagination::bootstrap-4') }}
          </div>
        </div>
      </div>
    </div>
    <!-- End Pagination -->
  </div>

  <script>
    $(document).ready(function() {
      // Debounce function to prevent too many triggers while typing
      function debounce(func, wait, immediate) {
        var timeout;
        return function() {
          var context = this, args = arguments;
          clearTimeout(timeout);
          timeout = setTimeout(function() {
            func.apply(context, args);
          }, wait);
        };
      }

      // Apply the debounce to the search input
      $('#search').on('keyup', debounce(function() {
        var value = $(this).val().toLowerCase();
        $('#wasteCategoriesTable tbody tr').filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
      }, 300)); // 300ms debounce time
    });
  </script>

@endsection
