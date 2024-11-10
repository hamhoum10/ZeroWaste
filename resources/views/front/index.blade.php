@extends('layouts/front')

@section('content')
<div class="container my-5">
    <h1>Upcoming Events</h1>
    
    <!-- Date Search Form -->
    <form method="GET" action="{{ route('front.index') }}" class="mb-4">
        <div class="form-group row">
            <label for="date" class="col-md-2 col-form-label">Filter by Date:</label>
            <div class="col-md-4">
                <input type="date" id="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>

    @if($events->count() > 0)
        <div class="row">
            @foreach($events as $event)
                <div class="col-md-4">
                    <div class="card mb-4">
                        @if ($event->event_image)
                            <img src="{{ asset('images/' . $event->event_image) }}" alt="{{ $event->event_name }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $event->event_name }}</h5>
                            <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                            
                            <!-- Display the Start Date -->
                            <p class="card-text">
                                <strong>Start Date:</strong> 
                                {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y, H:i') }}
                            </p>
                            
                            <!-- Link to the Event Details Page -->
                            <a href="{{ route('front.show', $event->event_id) }}" class="btn btn-primary">View Event</a>
                            
                            <!-- Join Button -->
                            <a class="btn btn-success ">Join Event</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No upcoming events at the moment.</p>
    @endif
</div>
@endsection
