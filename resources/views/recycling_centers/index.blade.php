@extends('layouts/contentNavbarLayout')

@section('content')
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  <style>
    /* Custom styles to make map controls smaller */
    .leaflet-control {
      font-size: 2px; /* Adjust control font size */
      padding: 1px;    /* Adjust padding for controls */
      margin-left: -2px;
    }

    .leaflet-control-zoom {
      margin-top: 33px; /* Add space above zoom control */
    }

    /* Hide the attribution control for a cleaner look */
    .leaflet-control-attribution {
      display: none;
    }
  </style>

  <div class="container">
    <h1>Recycling Centers</h1>
    <a href="{{ route('recycling-centers.create') }}" class="btn btn-primary">Add Recycling Center</a>

    @if ($message = Session::get('success'))
      <div class="alert alert-success">{{ $message }}</div>
    @endif

    <table class="table">
      <thead>
      <tr>
        <th>Name</th>
        <th>Address</th>
        <th>Phone</th>
        <th>Waste Category</th>
        <th>Map</th> <!-- Added Map Column -->
        <th>Actions</th>
      </tr>
      </thead>
      <tbody>
      @foreach ($recyclingCenters as $center)
        <tr>
          <td>
            <a href="{{ route('recycling-centers.show', $center->id) }}">{{ $center->name }}</a>
          </td>
          <td>{{ $center->address }}</td>
          <td>{{ $center->phone }}</td>
          <td>{{ $center->wasteCategory->name }}</td>
          <td>
            <!-- Mini Map -->
            <div id="map-{{ $center->id }}" style="height: 100px; width: 150px;"></div>
            <script>
              // Initialize the mini map for each recycling center
              var miniMap{{ $center->id }} = L.map('map-{{ $center->id }}', {
                zoomControl: true // Show zoom controls
              }).setView([{{ $center->latitude }}, {{ $center->longitude }}], 14);

              // Add OpenStreetMap tile layer
              L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
              }).addTo(miniMap{{ $center->id }});

              // Marker for recycling center
              L.marker([{{ $center->latitude }}, {{ $center->longitude }}]).addTo(miniMap{{ $center->id }});
            </script>
          </td>
          <td>
            <a href="{{ route('recycling-centers.edit', $center->id) }}" class="btn btn-warning">Edit</a>
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $center->id }}">Delete</button>

            <!-- Modal -->
            <div class="modal fade" id="deleteModal{{ $center->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $center->id }}" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel{{ $center->id }}">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    Are you sure you want to delete this recycling center?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('recycling-centers.destroy', $center->id) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection
