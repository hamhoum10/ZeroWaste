@php
  $isMenu = false;
  $navbarHideToggle = false;
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Recycling Centers Map')

@section('content')
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <style>
    /* Add this CSS rule to style recent searches horizontally */
    /* Add this CSS rule to style recent searches horizontally */
    #recent-searches {
      display: flex; /* Use flexbox for horizontal layout */
      flex-wrap: wrap; /* Allow wrapping to the next line if needed */
      gap: 10px; /* Space between items */
      list-style: none; /* Remove default list styling */
      padding: 0; /* Remove default padding */
      margin-top: 5px; /* Margin for spacing */
    }

    #recent-searches li {
      background: #f0f0f0; /* Background color for visibility */
      padding: 5px 10px; /* Padding for each search item */
      border-radius: 4px; /* Rounded corners */
      cursor: pointer; /* Pointer cursor on hover */
      transition: background 0.3s; /* Smooth background change on hover */
    }

    #recent-searches li:hover {
      background: #e0e0e0; /* Change background color on hover */
    }


    /* Custom CSS for wider offcanvas */
    .offcanvas-lg {
      width: 700px; /* Adjust the width as needed */
    }

    /* Map height */
    #map {
      height: 70vh; /* Full height of viewport */
      width: 100%; /* Full width of parent */
    }

    /* Search results styling */
    #search-results {
      list-style: none;
      padding: 0;
      margin-top: 5px;
      border: 1px solid #ccc;
      display: none; /* Initial state hidden */
      position: absolute; /* Position absolute for dropdown effect */
      background: white; /* Background color to make it readable */
      z-index: 1000; /* Ensure it appears above other elements */
    }

    /* Search bar container styling */
    .search-container {
      width: 100%;
      position: relative; /* For absolute positioning of search results */
    }

  </style>

  <div class="container-fluid p-0">
    <div class="row vh-100">
      <!-- Search bar -->
      <div class="col-md-4 search-container">
        <input type="text" id="search-bar" placeholder="Search for recycling centers..." style="width: 100%; padding: 10px;"/>
        <ul id="search-results"></ul>
        <h5>Recent Searches</h5>
        <ul id="recent-searches"></ul>
      </div>

      <!-- Map container -->
      <div id="map" class="col-md-8"></div>
    </div>
  </div>

  <!-- Offcanvas for Recycling Center Details -->
  <div class="offcanvas offcanvas-end offcanvas-lg" tabindex="-1" id="offcanvasDetails" aria-labelledby="offcanvasDetailsLabel">
    <div class="offcanvas-header">
      <h5 id="offcanvasDetailsLabel" class="offcanvas-title">Recycling Center Details</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" id="offcanvas-center-name">Recycling Center</h3>
        </div>

        <div class="card-body">
          <small class="text-light fw-semibold">Recycling Center Details</small>
          <dl class="row mt-2">
            <dt class="col-sm-3"><i class="fas fa-map-marker-alt"></i> Address</dt>
            <dd class="col-sm-9" id="offcanvas-center-address"></dd>

            <dt class="col-sm-3"><i class="fas fa-phone"></i> Phone</dt>
            <dd class="col-sm-9" id="offcanvas-center-phone"></dd>

            <dt class="col-sm-3"><i class="fas fa-calendar-alt"></i> Created At</dt>
            <dd class="col-sm-9" id="offcanvas-center-created"></dd>

            <dt class="col-sm-3"><i class="fas fa-calendar-check"></i> Updated At</dt>
            <dd class="col-sm-9" id="offcanvas-center-updated"></dd>

            <dt class="col-sm-3"><i class="fas fa-recycle"></i> Waste Category</dt>
            <dd class="col-sm-9" id="offcanvas-center-category"></dd>
          </dl>

          <h4 class="mt-4">Waste Category Details:</h4>
          <dl class="row mt-2">
            <dt class="col-sm-3">Description</dt>
            <dd class="col-sm-9" id="offcanvas-waste-description"></dd>

            <dt class="col-sm-3"><i class="fas fa-calendar-plus"></i> Created At</dt>
            <dd class="col-sm-9" id="offcanvas-waste-created"></dd>

            <dt class="col-sm-3"><i class="fas fa-calendar-check"></i> Updated At</dt>
            <dd class="col-sm-9" id="offcanvas-waste-updated"></dd>
          </dl>
          <!-- Google Street View Section -->
          <div id="street-view">a</div>
        </div>

        <div class="card-footer text-end">
          <a href="{{ route('recycling-centers.index') }}" class="btn btn-secondary">Back</a>
        </div>
      </div>
    </div>
  </div>

  <script>

    // Initialize the map and set its view to the first recycling center's location (or a default location)
    var map = L.map('map').setView([{{ $recyclingCenters->first()->latitude ?? 36.8065 }}, {{ $recyclingCenters->first()->longitude ?? 10.1815 }}], 10);

    // Add a tile layer to the map (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    function updateDetails(center) {
      if (!center) {
        console.error('Center is undefined');
        return; // Exit if center is undefined
      }

      console.log('Updating details for center:', center); // Log the center data

      // Update offcanvas content
      document.getElementById('offcanvas-center-name').textContent = center.name || 'N/A';
      document.getElementById('offcanvas-center-address').textContent = center.address || 'N/A';
      document.getElementById('offcanvas-center-phone').textContent = center.phone || 'N/A';
      document.getElementById('offcanvas-center-created').textContent = center.created_at || 'N/A';
      document.getElementById('offcanvas-center-updated').textContent = center.updated_at || 'N/A';

      // Update waste category details
      if (center.waste_category) {
        const categoryDetails = `
          <strong>${center.waste_category.name || 'N/A'}</strong><br>
          <span>Description: ${center.waste_category.description || 'N/A'}</span><br>
          <span>Created At: ${center.waste_category.created_at || 'N/A'}</span><br>
          <span>Updated At: ${center.waste_category.updated_at || 'N/A'}</span>
        `;

        console.log('Waste Category:', center.waste_category); // Log the waste category data
        document.getElementById('offcanvas-center-category').innerHTML = `<a href="{{ url('wastecategories') }}/${center.waste_category.id}">${center.waste_category.name || 'N/A'}</a>`;
        document.getElementById('offcanvas-waste-description').innerHTML = categoryDetails;
        document.getElementById('offcanvas-waste-created').textContent = center.waste_category.created_at || 'N/A';
        document.getElementById('offcanvas-waste-updated').textContent = center.waste_category.updated_at || 'N/A';
      } else {
        document.getElementById('offcanvas-center-category').textContent = 'N/A';
        document.getElementById('offcanvas-waste-description').textContent = 'N/A';
        document.getElementById('offcanvas-waste-created').textContent = 'N/A';
        document.getElementById('offcanvas-waste-updated').textContent = 'N/A';
      }

      // Show the offcanvas
      var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasDetails'));
      offcanvas.show();
    }

    // Recycling centers data
    var recyclingCenters = @json($recyclingCenters);
    var markers = []; // Store marker references
    var recentSearches = []; // Store recent searches

    // Add a marker for each recycling center and bind click event
    function addMarkers(centers) {
      // Clear existing markers
      markers.forEach(marker => map.removeLayer(marker));
      markers = []; // Reset markers array

      centers.forEach(function(center) {
        var marker = L.marker([center.latitude, center.longitude]).addTo(map);
        markers.push(marker); // Store the marker

        // Add click event to the marker
        marker.on('click', function() {
          console.log('Marker Clicked:', center); // Log the center data
          updateDetails(center);  // Update the details section in the offcanvas
          map.setView([center.latitude, center.longitude], 14); // Zoom to the center
        });

        // Optionally, bind a popup as well (if desired)
        marker.bindPopup("<b>" + center.name + "</b><br>" + center.address);
      });
    }

    // Initially add all markers
    addMarkers(recyclingCenters);

    // Search functionality
    var searchBar = document.getElementById('search-bar');
    var searchResults = document.getElementById('search-results');
    var recentSearchesList = document.getElementById('recent-searches');

    searchBar.addEventListener('input', function() {
      const query = this.value.toLowerCase();
      searchResults.innerHTML = ''; // Clear previous results
      searchResults.style.display = 'none'; // Hide results initially

      // Filter recycling centers
      recyclingCenters.forEach(function(center) {
        if (center.name.toLowerCase().includes(query) && query) {
          // Create a list item for each matching center
          var li = document.createElement('li');
          li.textContent = center.name;
          li.style.padding = '5px';
          li.style.cursor = 'pointer';
          li.onclick = function() {
            console.log('Search Result Clicked:', center); // Log the center data
            updateDetails(center);
            if(center.latitude && center.longitude) {
              map.setView([center.latitude, center.longitude], 17); // Zoom to the center
            } else {
              console.error('Invalid coordinates:', center.latitude, center.longitude); // Log error if coordinates are invalid
            }
            searchResults.innerHTML = ''; // Clear results
            searchResults.style.display = 'none'; // Hide results
            searchBar.value = ''; // Clear the search bar

            // Add to recent searches
            addToRecentSearches(center);
          };
          searchResults.appendChild(li);
        }
      });

      if (searchResults.innerHTML) {
        searchResults.style.display = 'block'; // Show results if there are matches
      }
    });
    // Function to load recent searches from local storage
    function loadRecentSearches() {
      const storedSearches = localStorage.getItem('recentSearches');
      if (storedSearches) {
        recentSearches = JSON.parse(storedSearches);
        updateRecentSearchesList(); // Display loaded searches
      }
    }

    // Load recent searches when the page is loaded
    loadRecentSearches();

    function addToRecentSearches(center) {
      // Check if the center is already in the recent searches
      if (!recentSearches.some(search => search.id === center.id)) {
        // Limit to the last 5 searches
        if (recentSearches.length >= 5) {
          recentSearches.shift(); // Remove the oldest search
        }
        recentSearches.push(center); // Add the new search

        // Save to local storage
        localStorage.setItem('recentSearches', JSON.stringify(recentSearches));

        // Update the recent searches list
        updateRecentSearchesList();
      }
    }

    function updateRecentSearchesList() {
      recentSearchesList.innerHTML = ''; // Clear previous list
      recentSearches.forEach(function(center) {
        var li = document.createElement('li'); // Create a new list item
        li.textContent = center.name; // Set the text content
        li.style.padding = '5px 10px'; // Adjust padding as needed
        li.style.cursor = 'pointer'; // Set cursor for pointer on hover
        li.onclick = function() {
          console.log('Recent Search Clicked:', center); // Log the center data
          updateDetails(center);
          map.setView([center.latitude, center.longitude], 17); // Zoom to the center
        };
        recentSearchesList.appendChild(li); // Append the list item to the recent searches list
      });

      // Show recent searches only if there are any
      recentSearchesList.style.display = recentSearches.length > 0 ? 'flex' : 'none'; // Show if items exist
    }

  </script>
@endsection
