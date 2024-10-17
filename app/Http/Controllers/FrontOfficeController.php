<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class FrontOfficeController extends Controller
{
     // Display all events for the front office
     public function index()
     {
         $events = Event::all(); // Get all events
         return view('front.index', compact('events'));
     }
 
     // Display a specific event for the front office
     public function show($id)
     {
         $event = Event::findOrFail($id); // Get event by ID or show 404
         return view('front.show', compact('event'));
     }
}
