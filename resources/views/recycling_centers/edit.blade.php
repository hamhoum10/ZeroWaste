@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Recycling Center')

@section('content')
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" />

  <div class="container">
    <h1 class="fw-bold py-3 mb-4">Edit Recycling Center</h1>

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('recycling-centers.update', $recyclingCenter->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label class="form-label" for="name">Name</label>
        <div class="input-group input-group-merge">
          <span class="input-group-text"><i class="bx bx-user"></i></span>
          <input
            type="text"
            class="form-control"
            name="name"
            value="{{ old('name', $recyclingCenter->name) }}"
            >
        </div>
        @error('name')
        <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <div class="mb-3">
        <label class="form-label" for="address">Email Address</label>
        <div class="input-group input-group-merge">
          <span class="input-group-text"><i class="bx bx-envelope"></i></span>
          <input
            type="email"
            class="form-control"
            name="address"
            value="{{ old('address', $recyclingCenter->address) }}"
            >
        </div>
        @error('address')
        <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <div class="mb-3">
        <label class="form-label" for="phone">Phone</label>
        <div class="input-group input-group-merge">
          <span class="input-group-text"><i class="bx bx-phone"></i></span>
          <input
            type="text"
            class="form-control"
            name="phone"
            value="{{ old('phone', $recyclingCenter->phone) }}">
        </div>
        @error('phone')
        <small class="text-danger">{{ $message }}</small>
        @enderror
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
        <input type="hidden" name="waste_category_id" id="waste_category_id" value="{{ old('waste_category_id', $recyclingCenter->waste_category_id) }}" >
        @error('waste_category_id')
        <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <div id="map" style="height: 400px; margin-top: 20px;"></div>
      <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $recyclingCenter->latitude) }}" >
      <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $recyclingCenter->longitude) }}" >
      @error('latitude')
      <small class="text-danger">{{ $message }}</small>
      @enderror
      @error('longitude')
      <small class="text-danger">{{ $message }}</small>
      @enderror

      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>

  <script>
    // Dropdown selection handling
    document.querySelectorAll('.dropdown-item').forEach(item => {
      item.addEventListener('click', function() {
        const selectedValue = this.getAttribute('data-value');
        const selectedText = this.innerText;

        document.getElementById('waste_category_id').value = selectedValue;
        document.getElementById('selectedCategory').innerText = selectedText;
      });
    });

    // Initialize the map
    var map = L.map('map').setView([{{ old('latitude', $recyclingCenter->latitude) }}, {{ old('longitude', $recyclingCenter->longitude) }}], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var marker = L.marker([{{ old('latitude', $recyclingCenter->latitude) }}, {{ old('longitude', $recyclingCenter->longitude) }}]).addTo(map);

    function onMapClick(e) {
      if (marker) map.removeLayer(marker);
      marker = L.marker(e.latlng).addTo(map);
      document.getElementById('latitude').value = e.latlng.lat;
      document.getElementById('longitude').value = e.latlng.lng;
    }

    map.on('click', onMapClick);
  </script>
@endsection
