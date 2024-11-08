@extends('layouts/contentNavbarLayout')

@section('title', 'Add Recycling Center')

@section('content')
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" />

  <div class="container">
    <h1 class="fw-bold py-3 mb-4">Add Recycling Center</h1>
    <div class="card mb-4">
      <div class="card-body">
        <form action="{{ route('recycling-centers.store') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label class="form-label" for="name">Name</label>
            <div class="input-group input-group-merge">
              <span class="input-group-text"><i class="bx bx-user"></i></span>
              <input type="text" class="form-control" id="name" name="name" placeholder="John Doe" required />
            </div>
          </div>
          <div class="mb-3">

            <label class="form-label" for="address">Email Address</label>

            <div class="input-group input-group-merge">
              <span class="input-group-text"><i class="bx bx-envelope"></i></span>
              <input type="email" class="form-control" id="address" name="address" placeholder="example@example.com" required />
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label" for="phone">Phone</label>
            <div class="input-group input-group-merge">
              <span class="input-group-text"><i class="bx bx-phone"></i></span>
              <input type="text" id="phone" class="form-control phone-mask" name="phone" placeholder="658 799 8941" />
            </div>
          </div>
          <div class="mb-3">
            <label for="waste_category_id">Waste Category</label>
            <div class="btn-group">
              <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="selectedCategory">
                Select Waste Category
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
            <input type="hidden" name="waste_category_id" id="waste_category_id" required>
          </div>

          <script>
            // Dropdown selection handling
            document.querySelectorAll('.dropdown-item').forEach(item => {
              item.addEventListener('click', function() {
                const selectedValue = this.getAttribute('data-value');
                const selectedText = this.innerText;

                // Set the hidden input value
                document.getElementById('waste_category_id').value = selectedValue;

                // Update the dropdown button text
                document.getElementById('selectedCategory').innerText = selectedText;
              });
            });
          </script>

          <!-- New Map Field -->
          <div id="map" style="height: 400px; margin-top: 20px;"></div>
          <input type="hidden" name="latitude" id="latitude" required>
          <input type="hidden" name="longitude" id="longitude" required>

          <button type="submit" class="btn btn-primary">Add</button>
        </form>
      </div>
    </div>
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

    // Dropdown selection handling
    document.querySelectorAll('.dropdown-item').forEach(item => {
      item.addEventListener('click', function() {
        const selectedValue = this.getAttribute('data-value');
        const selectedText = this.innerText;

        // Set the hidden input value
        document.getElementById('waste_category_id').value = selectedValue;

        // Update the dropdown button text
        document.querySelector('.dropdown-toggle').innerText = selectedText;
      });
    });
  </script>
@endsection
