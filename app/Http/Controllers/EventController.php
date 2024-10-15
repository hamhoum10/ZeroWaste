<?php

namespace App\Http\Controllers;
use App\Models\Event;
use Illuminate\Http\Request;


class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();
        return view('events.index', compact('events'));
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
            'event_name' => 'nullable',
            'description' => 'nullable',
            'location' => 'nullable',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'event_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for 
            

        ]);
        // Handle the image upload
    if ($request->hasFile('event_image')) {
        $imageName = time() . '.' . $request->event_image->extension();
        $request->event_image->move(public_path('images'), $imageName);
    } else {
        $imageName = null;
    }

    // Save the event data, including the image path

        // Save the event data, including the image path
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
