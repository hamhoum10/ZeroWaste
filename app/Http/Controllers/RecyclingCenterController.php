<?php

namespace App\Http\Controllers;

use App\Models\RecyclingCenter;
use App\Models\WasteCategory; // Ensure you import the WasteCategory model
use App\Services\LogService;
use App\Services\StatisticService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecyclingCenterController extends Controller
{
  public function __construct()
  {
    // Middleware for admin-only methods
    $this->middleware('role:admin')->only(['admin', 'create', 'store', 'show', 'edit', 'update', 'destroy']);

    // Redirect users who are not admins
    $this->middleware(function ($request, $next) {
      if (Auth::check() && Auth::user()->role !== 'admin') {
        return redirect('/front/recycling-centers');
      }
      return $next($request);
    });
  }
  public function index()
  {
    $recyclingCenters = RecyclingCenter::with('wasteCategory')->paginate(5);
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
      'latitude' => 'required|numeric',
      'longitude' => 'required|numeric',
    ], [
      'name.required' => 'The name field is required.',
      'address.required' => 'The address field is required.',
      'waste_category_id.required' => 'Please select a waste category.',
      'latitude.required' => 'Latitude is required and must be a valid number.',
      'longitude.required' => 'Longitude is required and must be a valid number.',
    ]);

    RecyclingCenter::create($request->all());
    return redirect()->route('recycling-centers.index')->with('success', 'Recycling Center created successfully.');
  }

  public function update(Request $request, RecyclingCenter $recyclingCenter)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'address' => 'required|string|max:255',
      'phone' => 'nullable|string|max:15',
      'waste_category_id' => 'required|exists:waste_categories,id',
      'latitude' => 'required|numeric',
      'longitude' => 'required|numeric',
    ], [
      'name.required' => 'The name field is required.',
      'address.required' => 'The address field is required.',
      'waste_category_id.required' => 'Please select a waste category.',
      'latitude.required' => 'Latitude is required and must be a valid number.',
      'longitude.required' => 'Longitude is required and must be a valid number.',
    ]);

    $recyclingCenter->update($request->all());
    return redirect()->route('recycling-centers.index')->with('success', 'Recycling Center updated successfully.');
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



  public function destroy(RecyclingCenter $recyclingCenter)
  {
    $recyclingCenter->delete();
    return redirect()->route('recycling-centers.index')->with('success', 'Recycling Center deleted successfully.');
  }
}
