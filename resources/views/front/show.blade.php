@extends('layouts/contentNavbarLayout')  <!-- Assuming you have a front office layout -->

@section('content')
<div class="container my-5">
    <h1>{{ $event->event_name }}</h1>
    <div class="row">
        <div class="col-md-6">
            @if ($event->event_image)
                <img src="{{ asset('images/' . $event->event_image) }}" alt="{{ $event->event_name }}" class="img-fluid" style="max-height: 400px; object-fit: cover;">
            @endif
        </div>
        <div class="col-md-6">
            <p><strong>Description:</strong> {{ $event->description }}</p>
            <p><strong>Location:</strong> {{ $event->location }}</p>
            <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y, H:i') }}</p>
            <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y, H:i') }}</p>
            <a href="{{ route('front.index') }}" class="btn btn-secondary">Back to Events</a>
        </div>
    </div>
</div>
@endsection
