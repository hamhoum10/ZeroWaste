@extends('layouts/contentNavbarLayout')

@section('content')
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  <div class="container-fluid p-0">
    <div class="row vh-100">
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header">
            <h3 class="card-title">{{ ucwords($recyclingCenter->name) }} Recycling Center</h3>
          </div>

          <div class="card-body">
            <small class="text-light fw-semibold">Recycling Center Details</small>
            <dl class="row mt-2">
              <dt class="col-sm-3"><i class="fas fa-map-marker-alt"></i> Address</dt>
              <dd class="col-sm-9">{{ $recyclingCenter->address }}</dd>

              <dt class="col-sm-3"><i class="fas fa-phone"></i> Phone</dt>
              <dd class="col-sm-9">{{ $recyclingCenter->phone }}</dd>

              <dt class="col-sm-3"><i class="fas fa-calendar-alt"></i> Created At</dt>
              <dd class="col-sm-9">{{ $recyclingCenter->created_at->format('Y-m-d \a\t H:i') }}</dd>

              <dt class="col-sm-3"><i class="fas fa-calendar-check"></i> Updated At</dt>
              <dd class="col-sm-9">{{ $recyclingCenter->updated_at->format('Y-m-d \a\t H:i') }}</dd>

              <dt class="col-sm-3"><i class="fas fa-recycle"></i> Waste Category</dt>
              <dd class="col-sm-9">
                <a href="{{ route('wastecategories.show', $recyclingCenter->wasteCategory->id) }}">
                  {{ $recyclingCenter->wasteCategory->name }}
                </a>
              </dd>
            </dl>

            <!-- Waste Category Details -->
            <h4 class="mt-4">Waste Category Details:</h4>
            <dl class="row mt-2">
              <dt class="col-sm-3">Description</dt>
              <dd class="col-sm-9">{{ $recyclingCenter->wasteCategory->description }}</dd>

              <dt class="col-sm-3"><i class="fas fa-calendar-plus"></i> Created At</dt>
              <dd class="col-sm-9">{{ $recyclingCenter->wasteCategory->created_at->format('Y-m-d \a\t H:i') }}</dd>

              <dt class="col-sm-3"><i class="fas fa-calendar-check"></i> Updated At</dt>
              <dd class="col-sm-9">{{ $recyclingCenter->wasteCategory->updated_at->format('Y-m-d \a\t H:i') }}</dd>
            </dl>
          </div>

          <div class="card-footer text-end">
            <a href="{{ route('recycling-centers.index') }}" class="btn btn-secondary">Back</a>
          </div>
        </div>
      </div>

      <!-- Map Column -->
      <div class="col-md-6">
        <div id="map" style="height: 100%;"></div>
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
      .bindPopup("{{ ucwords($recyclingCenter->name) }} Recycling Center") // Show the center's name in the popup
      .openPopup();
  </script>
@endsection
