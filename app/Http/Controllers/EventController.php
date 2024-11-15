<?php

namespace App\Http\Controllers;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventReservation;


class EventController extends Controller
{
    public function sendReservationEmail($id)
    {
        $user = auth()->user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Please log in to reserve the event.');
    }

    // Retrieve the event by its ID
    $event = Event::findOrFail($id);

    // Send email with the event data
    Mail::to($user->email)->send(new EventReservation($event, $user));

    return back()->with('success', 'Reservation email sent successfully!');
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Event::query();

        // Filter by date if provided
        if ($request->has('date') && $request->date) {
            $query->whereDate('start_date', $request->date);
        }

        // Filter by event name if provided
        if ($request->has('event_name') && $request->event_name) {
            $query->where('event_name', 'like', '%' . $request->event_name . '%');
        }

        $events = $query->get(); // Get events based on filters
        return view('events.index', compact('events')); // Adjust path if necessary
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  public function store(Request $request)
  {
    $request->validate([
      'event_name' => 'required|string|max:255', // Event name is required, string, max 255 characters
      'description' => 'required|string', // Description is required and must be a string
      'location' => 'required|string', // Location is required and must be a string
      'start_date' => 'required|date', // Start date is required and must be a valid date
      'end_date' => 'required|date|after_or_equal:start_date', // End date is required, must be a valid date and after the start date
      'event_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Event image is required, must be an image file, and the size is limited to 2MB
    ], [
      // Custom validation error messages
      'event_name.required' => 'The event name is required.',
      'event_name.string' => 'The event name must be a string.',
      'event_name.max' => 'The event name may not be greater than 255 characters.',

      'description.required' => 'The description is required.',
      'description.string' => 'The description must be a string.',

      'location.required' => 'The location is required.',
      'location.string' => 'The location must be a string.',

      'start_date.required' => 'The start date is required.',
      'start_date.date' => 'The start date must be a valid date.',

      'end_date.required' => 'The end date is required.',
      'end_date.date' => 'The end date must be a valid date.',
      'end_date.after_or_equal' => 'The end date must be a date after or equal to the start date.',

      'event_image.required' => 'The event image is required.',
      'event_image.image' => 'The event image must be an image file.',
      'event_image.mimes' => 'The event image must be a file of type: jpeg, png, jpg, gif.',
      'event_image.max' => 'The event image may not be larger than 2MB.',
    ]);

    // Handle the image upload
    if ($request->hasFile('event_image')) {
      $imageName = time() . '.' . $request->event_image->extension();
      $request->event_image->move(public_path('images'), $imageName);
    } else {
      $imageName = null;
    }

    // Save the event data
    Event::create([
      'event_name' => $request->input('event_name'),
      'description' => $request->input('description'),
      'location' => $request->input('location'),
      'start_date' => $request->input('start_date'),
      'end_date' => $request->input('end_date'),
      'event_image' => $imageName, // Save image name or null
    ]);

    return redirect()->route('events.index')->with('success', 'Event created successfully!');
  }


  /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)

    {
        $event = Event::findOrFail($id);
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the form data
        $request->validate([
            'event_name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'event_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image upload
        ]);

        // Find the event by ID
        $event = Event::findOrFail($id);

        // Handle the image upload if a new image is provided
        if ($request->hasFile('event_image')) {
            // Delete the old image if it exists
            if ($event->event_image && file_exists(public_path('images/' . $event->event_image))) {
                unlink(public_path('images/' . $event->event_image));
            }

            // Save the new image
            $imageName = time() . '.' . $request->event_image->extension();
            $request->event_image->move(public_path('images'), $imageName);
            $event->event_image = $imageName;  // Update the image path
        }

        // Update the other fields
        $event->event_name = $request->input('event_name');
        $event->description = $request->input('description');
        $event->location = $request->input('location');
        $event->start_date = $request->input('start_date');
        $event->end_date = $request->input('end_date');

        // Save the updated event
        $event->save();

        // Redirect with a success message
        return redirect()->route('events.index')->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully.');
    }
}
