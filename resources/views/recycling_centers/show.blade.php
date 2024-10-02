@extends('layouts/contentNavbarLayout')

@section('content')
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  <div class="container mt-4">
    <div class="card">
      <div class="card-header">
        <h3>{{ $recyclingCenter->name }}</h3>
      </div>
      <div class="card-body">
        <p><strong>Address:</strong> {{ $recyclingCenter->address }}</p>
        <p><strong>Phone:</strong> {{ $recyclingCenter->phone }}</p>
        <p><strong>Created At:</strong> {{ $recyclingCenter->created_at->format('Y-m-d \a\t H:i') }}</p>
        <p><strong>Updated At:</strong> {{ $recyclingCenter->updated_at->format('Y-m-d \a\t H:i') }}</p>
        <p>
          <strong>Waste Category:</strong>
          <a href="{{ route('wastecategories.show', $recyclingCenter->wasteCategory->id) }}">
            {{ $recyclingCenter->wasteCategory->name }}
          </a>
        </p>

        <!-- Displaying all details of the waste category -->
        <h4 class="mt-4">Waste Category Details:</h4>
        <p><strong>Description:</strong> {{ $recyclingCenter->wasteCategory->description }}</p>
        <p><strong>Created At:</strong> {{ $recyclingCenter->wasteCategory->created_at->format('Y-m-d \a\t H:i') }}</p>
        <p><strong>Updated At:</strong> {{ $recyclingCenter->wasteCategory->updated_at->format('Y-m-d \a\t H:i') }}</p>

        <!-- New Map Field -->
        <div id="map" style="height: 400px; margin-top: 20px;"></div>
      </div>
      <div class="card-footer text-end">
        <a href="{{ route('recycling-centers.index') }}" class="btn btn-secondary">Back</a>
      </div>
    </div>
  </div>

  <script>
    // Initialize the map and set the view to the recycling center's location
    var map = L.map('map').setView([{{ $recyclingCenter->latitude }}, {{ $recyclingCenter->longitude }}], 13); // Center the map on the recycling center location

    // Add OpenStreetMap tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // Add a marker for the recycling center location
    L.marker([{{ $recyclingCenter->latitude }}, {{ $recyclingCenter->longitude }}]).addTo(map)
      .bindPopup("{{ $recyclingCenter->name }}") // Optional: Show the center's name in the popup
      .openPopup();
  </script>
@endsection
