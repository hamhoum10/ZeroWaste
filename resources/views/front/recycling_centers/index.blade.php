{{-- @php
  $isMenu = false;
  $navbarHideToggle = false;
@endphp --}}

@extends('layouts/front')

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
      margin-top: 100px;
      border: 1px solid #ccc; /* Light border for separation */
      display: none; /* Hidden by default */
      position: absolute; /* For dropdown effect */
      background: white; /* Background color */
      z-index: 10009; /* Ensure it appears above other elements */
      border-radius: 8px; /* Rounded corners for the dropdown */
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    }

    /* Individual search result item styling */
    #search-results li {
      padding: 10px 15px; /* Padding for each search item */
      border-bottom: 1px solid #e0e0e0; /* Light border between items */
      cursor: pointer; /* Pointer cursor on hover */
      transition: background 0.3s, transform 0.2s; /* Smooth transitions */
    }

    /* Hover effect for each item */
    #search-results li:hover {
      background: #f8f8f8; /* Light background color on hover */
      transform: scale(1.02); /* Slight scale effect on hover */
    }

    /* Search bar container styling */
    .search-container {
      width: 100%;
      position: relative; /* For absolute positioning of search results */
    }

  </style>

  <div class="container-fluid p-0">
    <div class="row vh-100">
      <div class="col-md-4 search-container d-flex align-items-center">
        <select id="category-dropdown" class="form-select me-2" style="    min-width: 172px;flex: 1;">
          <option value="">Select a category</option>
          @foreach ($wasteCategories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
          @endforeach
        </select>
        <!-- Search bar -->
        <input type="text" id="search-bar" class="form-control" placeholder="Search for recycling centers..." style="    min-width: 220px;flex: 2;"/>
        <ul id="recent-searches"></ul>
      </div>
      <ul id="search-results"></ul>

      <!-- Map container -->
      <div id="map" class="col-md-8"></div>
    </div>
  </div>

  <!-- Offcanvas for Recycling Center Details -->
  <div class="offcanvas offcanvas-end offcanvas-lg" style="    width: 500px;" tabindex="-1" id="offcanvasDetails" aria-labelledby="offcanvasDetailsLabel">
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

        </div>

        <div class="card-footer text-end">
          <a href="{{ url('front/recycling-centers') }}" class="btn btn-secondary">Back</a>
        </div>
      </div>
    </div>
  </div>

  <script>

    // Initialize the map and set its view to the first recycling center's location (or a default location)
    var map = L.map('map', {
      minZoom: 2,  // Set minimum zoom level to prevent excessive zooming out
      maxZoom: 15  // Optional: Set maximum zoom level (adjust as needed)
    }).setView([{{ $recyclingCenters->first()->latitude ?? 36.8065 }}, {{ $recyclingCenters->first()->longitude ?? 10.1815 }}], 10);

    // Add a tile layer to the map (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    function formatDateTime(dateTime) {
      if (!dateTime) return 'N/A'; // Return 'N/A' if dateTime is falsy

      const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: true // Set to true for 12-hour format
      };

      // Create a new Date object and format it
      return new Date(dateTime).toLocaleString('en-US', options);
    }
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
      document.getElementById('offcanvas-center-created').textContent = formatDateTime(center.created_at) || 'N/A';
      document.getElementById('offcanvas-center-updated').textContent = formatDateTime(center.updated_at) || 'N/A';

      // Update waste category details
      if (center.waste_category) {
        const categoryDetails = `
      <strong>${center.waste_category.name || 'N/A'}</strong><br>
      <span>Description: ${center.waste_category.description || 'N/A'}</span><br>
      <span>Created At: ${formatDateTime(center.waste_category.created_at) || 'N/A'}</span><br>
      <span>Updated At: ${formatDateTime(center.waste_category.updated_at) || 'N/A'}</span>
    `;

        console.log('Waste Category:', center.waste_category); // Log the waste category data
        document.getElementById('offcanvas-center-category').innerHTML = `<a href="{{ url('wastecategories') }}/${center.waste_category.id}">${center.waste_category.name || 'N/A'}</a>`;
        document.getElementById('offcanvas-waste-description').innerHTML = categoryDetails;
        document.getElementById('offcanvas-waste-created').textContent = formatDateTime(center.waste_category.created_at )|| 'N/A';
        document.getElementById('offcanvas-waste-updated').textContent = formatDateTime(center.waste_category.updated_at) || 'N/A';
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
    // Get the category dropdown element
    var categoryDropdown = document.getElementById('category-dropdown');

    // Event listener for category selection
    categoryDropdown.addEventListener('change', function() {
      const selectedCategoryId = this.value;

      // Filter recycling centers based on the selected category
      const filteredCenters = selectedCategoryId
        ? recyclingCenters.filter(center => center.waste_category && center.waste_category.id == selectedCategoryId)
        : recyclingCenters;

      // Add markers for the filtered centers
      addMarkers(filteredCenters);

      // If there are filtered centers, fit the map to the bounds
      if (filteredCenters.length > 0) {
        const bounds = L.latLngBounds(filteredCenters.map(center => [center.latitude, center.longitude]));
        map.fitBounds(bounds); // Adjust the map to fit the bounds of the filtered centers
      } else {
        // Optionally, reset the map view to the default location if no centers are found
        map.setView([{{ $recyclingCenters->first()->latitude ?? 36.8065 }}, {{ $recyclingCenters->first()->longitude ?? 10.1815 }}], 10);
      }
    });

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

    // Search functionality
    searchBar.addEventListener('input', function() {
      const query = this.value.toLowerCase();
      searchResults.innerHTML = ''; // Clear previous results
      searchResults.style.display = 'none'; // Hide results initially

      // Filter recycling centers by name and waste category
      recyclingCenters.forEach(function(center) {
        // Check if the center name or waste category matches the query
        const categoryMatches = center.waste_category && center.waste_category.name.toLowerCase().includes(query);
        if ((center.name.toLowerCase().includes(query) || categoryMatches) && query) {
          // Create a list item for each matching center
          var li = document.createElement('li');
          li.textContent = center.name + (categoryMatches ? ' (Category: ' + center.waste_category.name + ')' : '');
          li.style.padding = '5px';
          li.style.cursor = 'pointer';
          li.onclick = function() {
            console.log('Search Result Clicked:', center); // Log the center data
            updateDetails(center);
            if (center.latitude && center.longitude) {
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
      } else {
        searchResults.style.display = 'none'; // Ensure it hides if no results
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
