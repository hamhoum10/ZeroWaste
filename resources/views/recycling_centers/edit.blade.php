@extends('layouts/contentNavbarLayout')

@section('content')
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  <div class="container">
    <h1>Edit Recycling Center</h1>
    <form action="{{ route('recycling-centers.update', $recyclingCenter->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" value="{{ $recyclingCenter->name }}" required>
      </div>
      <div class="form-group">
        <label for="address">Address</label>
        <input type="text" class="form-control" name="address" value="{{ $recyclingCenter->address }}" required>
      </div>
      <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" class="form-control" name="phone" value="{{ $recyclingCenter->phone }}">
      </div>
      <div class="form-group">
        <label for="waste_category_id">Waste Category</label>
        <select name="waste_category_id" class="form-control" required>
          @foreach ($wasteCategories as $category)
            <option value="{{ $category->id }}" {{ $recyclingCenter->waste_category_id == $category->id ? 'selected' : '' }}>
              {{ $category->name }}
            </option>
          @endforeach
        </select>
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
