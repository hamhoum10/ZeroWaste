@extends('layouts/contentNavbarLayout')

@section('content')
    <h1>Event Details</h1>

    <p><strong>Event Name:</strong> {{ $event->event_name }}</p>
    <p><strong>Description:</strong> {{ $event->description }}</p>
    <p><strong>Location:</strong> {{ $event->location }}</p>
    <p><strong>Start Date:</strong> {{ $event->start_date }}</p>
    <p><strong>End Date:</strong> {{ $event->end_date }}</p>
    <a href="{{ route('events.edit', $event->event_id) }}" class="btn btn-primary">Edit</a>
    <a href="{{ route('events.index') }}" class="btn btn-secondary">Back</a><br>
    <!-- Centered Image Section -->
    <div class="d-flex justify-content-center">
            <img src="{{ asset('images/' . $event->event_image) }}" alt="Event Image" class="img-fluid event-image">
        </div>
        <style>
        .event-image {
            width: 300px;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
    

    
@endsection
