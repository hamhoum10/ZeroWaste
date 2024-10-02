@extends('layouts/contentNavbarLayout')

@section('content')
    <h1>Event Details</h1>

    <p><strong>Event Name:</strong> {{ $event->event_name }}</p>
    <p><strong>Description:</strong> {{ $event->description }}</p>
    <p><strong>Location:</strong> {{ $event->location }}</p>
    <p><strong>Start Date:</strong> {{ $event->start_date }}</p>
    <p><strong>End Date:</strong> {{ $event->end_date }}</p>

    <a href="{{ route('events.edit', $event->event_id) }}" class="btn btn-primary">Edit</a>
    <a href="{{ route('events.index') }}" class="btn btn-secondary">Back</a>
@endsection
