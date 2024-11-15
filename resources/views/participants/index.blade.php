@extends('layouts/contentNavbarLayout')

@section('content')
<div class="container my-5">
    <h1>Participants</h1>
    <table class="table">
        <thead>
            <tr>
                <th>User Name</th>
                <th>User Email</th>
                <th>Event Name</th>
                <th>Reserved At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($participants as $participant)
                <tr>
                    <td>{{ $participant->user_name }}</td>
                    <td>{{ $participant->user_email }}</td>
                    <td>{{ $participant->event_name }}</td>
                    <td>{{ $participant->created_at->format('d M Y, H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
