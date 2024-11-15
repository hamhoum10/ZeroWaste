<?php

namespace App\Http\Controllers;

use App\Models\RecyclingTip;
use Illuminate\Http\Request;
use Gemini\Laravel\Facades\Gemini;

class RecyclingTipController extends Controller
{
  public function index()
  {
    $tips = RecyclingTip::where('approved', true)->get(); // Only show approved tips
    return view('recycling_tips.index', compact('tips'));
  }

  public function myTips()
  {
    // Fetch tips created by the authenticated user
    $tips = RecyclingTip::where('posted_by', auth()->id())->get();

    return view('recycling_tips.my_tips', compact('tips'));
  }


  public function create()
  {
    return view('recycling_tips.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'title' => 'required|string|max:255',
      'description' => 'required|string',
      'category' => 'required|string',
    ], [
      'title.required' => 'The title field is required.',
      'description.required' => 'The description field is required.',
      'category.required' => 'The category field is required.',
    ]);

    RecyclingTip::create([
      'title' => $request->title,
      'description' => $request->description,
      'category' => $request->category,
      'posted_by' => auth()->id(), // Current user
      'likes_count' => 0,
    ]);

    return redirect()->route('recycling-tips.index')->with('success', 'Tip submitted for approval');
  }

  public function generateTip(Request $request)
  {
    // Use the title from the request (e.g., "Plastic" or "Paper Recycling")

    $recyclingType = $request->input('title', 'milk');

    // Pass the recycling type into the prompt for Gemini
    $response = Gemini::geminiPro()->generateContent("Generate a useful in three points recycling tip for $recyclingType.");
    $responseCat = Gemini::geminiPro()->generateContent("What is category of $recyclingType from this list {Plastics,
Paper and Cardboard, Metals, Glass, Electronics (E-Waste), Textiles, Wood, Organic Waste (Compostable Materials), Hazardous Household Waste, Rubber and Tires, Construction and Demolition Waste, Batteries, Light Bulbs, Automotive Parts} the response must be one of those provided category.");

    return response()->json([
      'success' => true,
      'tip' => [
        'title' => ucfirst($recyclingType) . " Tip",
        'description' => $response->text(),
        'category' => $responseCat->text(),
      ],
    ]);
  }

  public function edit($id)
  {
    $tip = RecyclingTip::findOrFail($id);

    // Ensure the user can only edit their own tips
    if ($tip->posted_by !== auth()->id()) {
      return redirect()->back()->with('error', 'Unauthorized');
    }

    return view('recycling_tips.edit', compact('tip'));
  }

  public function update(Request $request, $id)
  {
    $tip = RecyclingTip::findOrFail($id);

    if ($tip->posted_by !== auth()->id()) {
      return redirect()->back()->with('error', 'Unauthorized');
    }

    $tip->update($request->all());
    return redirect()->route('recycling-tips.index')->with('success', 'Tip updated successfully');
  }

  public function destroy($id)
  {
    $tip = RecyclingTip::findOrFail($id);

    if ($tip->posted_by !== auth()->id()) {
      return redirect()->back()->with('error', 'Unauthorized');
    }

    $tip->delete();
    return redirect()->route('recycling-tips.index')->with('success', 'Tip deleted successfully');
  }

  public function like($id)
  {
    $tip = RecyclingTip::findOrFail($id);
    $user = auth()->user(); // Get the authenticated user

    // Check if the user has already liked this tip
    if ($tip->likedByUsers()->where('user_id', $user->id)->exists()) {
      return redirect()->route('recycling-tips.index')->with('error', 'You have already liked this tip.');
    }

    // If not liked before, add a record to the pivot table
    $tip->likedByUsers()->attach($user->id);

    // Increment the likes count
    $tip->increment('likes_count');

    return redirect()->route('recycling-tips.index')->with('success', 'You liked the tip.');
  }


  public function approveTip($id)
  {
    $tip = RecyclingTip::findOrFail($id);
    $tip->update(['approved' => true]);

    return redirect()->route('admin.recycling-tips.pending')->with('success', 'Tip approved successfully');
  }

  public function pendingTips()
  {
    // Fetch all tips that have not yet been approved
    $tips = RecyclingTip::where('approved', false)->get();

    return view('recycling_tips.pending', compact('tips'));
  }

  public function rejectTip($id)
  {
    $tip = RecyclingTip::findOrFail($id);
    $tip->delete();

    return redirect()->route('admin.recycling-tips.pending')->with('success', 'Tip rejected and deleted successfully');
  }

}
