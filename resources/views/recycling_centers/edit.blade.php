@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Recycling Center')

@section('content')
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" />

  <div class="container">
    <h1 class="fw-bold py-3 mb-4">Edit Recycling Center</h1>
    <form action="{{ route('recycling-centers.update', $recyclingCenter->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label class="form-label" for="name">Name</label>
        <div class="input-group input-group-merge">
          <span class="input-group-text"><i class="bx bx-user"></i></span>
          <input type="text" class="form-control" name="name" value="{{ $recyclingCenter->name }}" required>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label" for="address">Email Address</label>
        <div class="input-group input-group-merge">
          <span class="input-group-text"><i class="bx bx-envelope"></i></span>
          <input type="email" class="form-control" name="address" value="{{ $recyclingCenter->address }}" required>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label" for="phone">Phone</label>
        <div class="input-group input-group-merge">
          <span class="input-group-text"><i class="bx bx-phone"></i></span>
          <input type="text" class="form-control" name="phone" value="{{ $recyclingCenter->phone }}">
        </div>
      </div>
      <div class="mb-3">
        <label for="waste_category_id">Waste Category</label>
        <div class="btn-group">
          <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="selectedCategory">
            @if ($recyclingCenter->waste_category_id)
              {{ $wasteCategories->firstWhere('id', $recyclingCenter->waste_category_id)->name }}
            @else
              Select Waste Category
            @endif
          </button>
          <ul class="dropdown-menu">
            @foreach ($wasteCategories as $category)
              <li>
                <a class="dropdown-item" href="javascript:void(0);" data-value="{{ $category->id }}">
                  {{ $category->name }}
                </a>
              </li>
            @endforeach
          </ul>
        </div>
        <input type="hidden" name="waste_category_id" id="waste_category_id" value="{{ $recyclingCenter->waste_category_id }}" required>
      </div>

      <input type="hidden" name="waste_category_id" id="waste_category_id" value="{{ $recyclingCenter->waste_category_id }}" required>
      </div>

      <!-- New Map Field -->
      <div id="map" style="height: 400px; margin-top: 20px;"></div>
      <input type="hidden" name="latitude" id="latitude" value="{{ $recyclingCenter->latitude }}" required>
      <input type="hidden" name="longitude" id="longitude" value="{{ $recyclingCenter->longitude }}" required>

      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>

  <script>
    // Initialize the map
    var map = L.map('map').setView([{{ $recyclingCenter->latitude }}, {{ $recyclingCenter->longitude }}], 13); // Center the map on the recycling center location

    // Add OpenStreetMap tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // Add a marker for the existing recycling center location
    var marker = L.marker([{{ $recyclingCenter->latitude }}, {{ $recyclingCenter->longitude }}]).addTo(map);

    // Function to handle map click
    function onMapClick(e) {
      // Remove the existing marker if there is one
      if (marker) {
        map.removeLayer(marker);
      }
      // Add a new marker
      marker = L.marker(e.latlng).addTo(map);
      // Set latitude and longitude values in hidden fields
      document.getElementById('latitude').value = e.latlng.lat;
      document.getElementById('longitude').value = e.latlng.lng;
    }

    // Add click event to the map
    map.on('click', onMapClick);
  </script>
@endsection
