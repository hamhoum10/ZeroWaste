@extends('layouts/contentNavbarLayout')

@section('content')
    <h1>Events</h1>
    <a href="{{ route('events.create') }}" class="btn btn-primary">Create New Event</a>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">{{ $message }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Event Name</th>
                <th>Description</th>
                <th>Location</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
                <tr>
                    <td><a href="{{ route('events.show', $event->event_id) }}">{{ $event->event_name }}</a></td>
                    <td>{{ $event->description }}</td>
                    <td>{{ $event->location }}</td>
                    <td>{{ $event->start_date->format('Y-m-d H:i') }}</td>
                    <td>{{ $event->end_date->format('Y-m-d H:i') }}</td>
                    <td>
                        <a href="{{ route('events.edit', $event->event_id) }}" class="btn btn-warning">Edit</a>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $event->event_id }}">Delete</button>

                        <!-- Modal -->
                        <div class="modal fade" id="deleteModal{{ $event->event_id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $event->event_id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $event->event_id }}">Confirm Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this event?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('events.destroy', $event->event_id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
