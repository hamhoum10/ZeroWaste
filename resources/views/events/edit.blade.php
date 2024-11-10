@extends('layouts/contentNavbarLayout')  <!-- Use your admin layout here -->

@section('content')
    <h1>Edit Event</h1>

    <form action="{{ route('events.update', $event->event_id) }}" method="POST"method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="event_name">Event Name:</label>
            <input type="text" name="event_name" id="event_name" class="form-control" value="{{ $event->event_name }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" id="description" class="form-control" required>{{ $event->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" name="location" id="location" class="form-control" value="{{ $event->location }}" required>
        </div>

        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="datetime-local" name="start_date" id="start_date" class="form-control" value="{{ $event->start_date }}" required>
        </div>

        <div class="form-group">
            <label for="end_date">End Date:</label>
            <input type="datetime-local" name="end_date" id="end_date" class="form-control" value="{{ $event->end_date }}" required>
        </div>
         <!-- Display the current image -->
         @if ($event->event_image)
                    <div class="form-group">
                        <label>Current Event Image:</label><br>
                        <img src="{{ asset('images/' . $event->event_image) }}" alt="Event Image" class="img-fluid" width="200">
                    </div>
                @endif

                <!-- Option to upload a new image -->
                <div class="form-group">
                    <label for="event_image">Change Event Image:</label>
                    <input type="file" name="event_image" id="event_image" class="form-control" accept="image/*">
                </div>

        <button type="submit" class="btn btn-primary">Update Event</button>
        <a href="{{ route('events.index') }}" class="btn btn-secondary">Back</a>
    </form>
@endsection
