<?php

namespace App\Http\Controllers;

use App\Models\RecyclingCenter;
use App\Models\WasteCategory; // Ensure you import the WasteCategory model
use Illuminate\Http\Request;

class RecyclingCenterController extends Controller
{
  public function index()
  {
    $recyclingCenters = RecyclingCenter::all();
    return view('recycling_centers.index', compact('recyclingCenters'));
  }

  public function create()
  {
    $wasteCategories = WasteCategory::all(); // Fetch all waste categories for the dropdown
    return view('recycling_centers.create', compact('wasteCategories'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'address' => 'required|string|max:255',
      'phone' => 'nullable|string|max:15',
      'waste_category_id' => 'required|exists:waste_categories,id',
      'latitude' => 'required|numeric', // Validate latitude
      'longitude' => 'required|numeric', // Validate longitude
    ]);

    // Create the Recycling Center with latitude and longitude
    RecyclingCenter::create($request->all());
    return redirect()->route('recycling-centers.index')->with('success', 'Recycling Center created successfully.');
  }

  public function show(RecyclingCenter $recyclingCenter)
  {
    return view('recycling_centers.show', compact('recyclingCenter'));
  }

  public function edit(RecyclingCenter $recyclingCenter)
  {
    $wasteCategories = WasteCategory::all(); // Fetch all waste categories for the dropdown
    return view('recycling_centers.edit', compact('recyclingCenter', 'wasteCategories'));
  }

  public function update(Request $request, RecyclingCenter $recyclingCenter)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'address' => 'required|string|max:255',
      'phone' => 'nullable|string|max:15',
      'waste_category_id' => 'required|exists:waste_categories,id',
      'latitude' => 'required|numeric', // Validate latitude
      'longitude' => 'required|numeric', // Validate longitude
    ]);

    // Update the Recycling Center with latitude and longitude
    $recyclingCenter->update($request->all());
    return redirect()->route('recycling-centers.index')->with('success', 'Recycling Center updated successfully.');
  }

  public function destroy(RecyclingCenter $recyclingCenter)
  {
    $recyclingCenter->delete();
    return redirect()->route('recycling-centers.index')->with('success', 'Recycling Center deleted successfully.');
  }
}
