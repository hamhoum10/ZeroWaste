<h1>{{ $recyclingCenter->name }}</h1>
<p>Address: {{ $recyclingCenter->address }}</p>
<p>Phone: {{ $recyclingCenter->phone }}</p>
<p>Waste Category: {{ $recyclingCenter->wasteCategory->name }}</p>
<p>Location: {{ $recyclingCenter->latitude }}, {{ $recyclingCenter->longitude }}</p>
