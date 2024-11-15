@extends('layouts/front')

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
            <div class="d-flex mt-3">
            
            <!-- Check if user has already reserved this event -->
            @php
                $userReserved = \App\Models\Participant::where('user_email', auth()->user()->email ?? '')
                                                       ->where('event_id', $event->id)
                                                       ->exists();
            @endphp

            <!-- Reserve Event Button -->
            <form action="{{ route('events.sendReservationEmail', $event->event_id) }}" method="POST" onsubmit="disableButton()">
                @csrf
                <button type="submit" class="btn btn-{{ $userReserved ? 'secondary' : 'success' }}" 
                        id="reserveButton" {{ $userReserved ? 'disabled' : '' }}>
                    {{ $userReserved ? 'Reserved' : 'Reserve Event' }}
                </button>
            </form>

           &nbsp &nbsp&nbsp
            <a href="{{ route('front.index') }}" class="btn btn-secondary">Back to Events</a>
            </div>
        </div>
    </div>
</div>

<script>
    function disableButton() {
        const button = document.getElementById('reserveButton');
        button.disabled = true;
        button.innerText = 'Reserved';
        button.classList.remove('btn-success');
        button.classList.add('btn-secondary'); // Change color to grey
    }
</script>
@endsection
