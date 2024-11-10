<?php

namespace App\Http\Controllers\FrontOffice;

use App\Http\Controllers\Controller;
use App\Models\RecyclingCenter;
use App\Models\WasteCategory;
use Illuminate\Http\Request;


class RecyclingCenterControllerF extends Controller
{
  // Display the list of recycling centers to the public with pagination
  public function index()
  {
    $wasteCategories = WasteCategory::all(); // Fetch all waste categories

    $recyclingCenters = RecyclingCenter::with('wasteCategory')->get();
    return view('front.recycling_centers.index', compact('recyclingCenters', 'wasteCategories'));
  }


  // Show a specific recycling center to the public
  public function show(RecyclingCenter $recyclingCenter)
  {
    return view('front.recycling_centers.show', compact('recyclingCenter'));
  }
}
