@extends('layouts/contentNavbarLayout')

@section('content')
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  <div class="container">
    <h1>Add Recycling Center</h1>
    <form action="{{ route('recycling-centers.store') }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" required>
      </div>
      <div class="form-group">
        <label for="address">Address</label>
        <input type="text" class="form-control" name="address" required>
      </div>
      <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" class="form-control" name="phone">
      </div>
      <div class="form-group">
        <label for="waste_category_id">Waste Category</label>
        <select name="waste_category_id" class="form-control" required>
          @foreach ($wasteCategories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
          @endforeach
        </select>
      </div>

      <!-- New Map Field -->
      <div id="map" style="height: 400px; margin-top: 20px;"></div>
      <input type="hidden" name="latitude" id="latitude" required>
      <input type="hidden" name="longitude" id="longitude" required>

      <button type="submit" class="btn btn-primary">Add</button>
    </form>
  </div>

  <script>
    // Initialize the map
    var map = L.map('map').setView([36.8065, 10.1815], 13); // Set to default coordinates (e.g., Tunis, Tunisia)

    // Add OpenStreetMap tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // Marker for selected location
    var marker;

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

      // Debugging: Log latitude and longitude
      console.log("Latitude: " + e.latlng.lat);
      console.log("Longitude: " + e.latlng.lng);
    }

    // Add click event to the map
    map.on('click', onMapClick);
  </script>
@endsection
