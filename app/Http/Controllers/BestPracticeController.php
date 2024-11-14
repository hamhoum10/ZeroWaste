<?php

namespace App\Http\Controllers;

use App\Models\BestPractice;
use App\Models\Category;
use Illuminate\Http\Request;

class BestPracticeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search'); // Get the search input
        $query = BestPractice::with('category', 'author');

        // If there's a search term, filter the best practices
        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('tags', 'like', "%{$search}%")
                ->orWhereHas('category', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        $bestPractices = $query->paginate(10);
        return view('best_practices.index', compact('bestPractices', 'search')); // Pass search term to the view
    }



  public function create()
  {
    $categories = Category::all();
    return view('best_practices.create', compact('categories'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'title' => 'required|string|max:255',
      'contents' => 'required',
      'category_id' => 'required|exists:categories,id',
      'tags' => 'nullable|string',
      'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
      'g-recaptcha-response'=>'recaptcha',
    ]);

    // Handle the image upload if provided
    $imagePath = null;
    if ($request->hasFile('image')) {
      $imagePath = $request->file('image')->store('best_practices', 'public');
    }

    BestPractice::create([
      'title' => $request->title,
      'contents' => $request->contents,
      'category_id' => $request->category_id,
      'tags' => $request->tags,
      'image' => $imagePath, // Save the image path in the database
      'user_id' => auth()->id(), // Add user_id (authenticated user)
    ]);

    return redirect()->route('back_office.best_practices.index')->with('success', 'Best Practice added successfully.');
  }


  public function show(BestPractice $bestPractice)
  {
    return view('best_practices.show', compact('bestPractice'));
  }

  public function edit(BestPractice $bestPractice)
  {
    $categories = Category::all();
    return view('best_practices.edit', compact('bestPractice', 'categories'));
  }

  public function update(Request $request, BestPractice $bestPractice)
  {
    $request->validate([
      'title' => 'required|string|max:255',
      'contents' => 'required',
      'category_id' => 'required|exists:categories,id',
      'tags' => 'nullable|string',
      'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
    ]);

    // Handle the image upload if provided
    $imagePath = $bestPractice->image; // Keep existing image path by default
    if ($request->hasFile('image')) {
      // Delete the old image if it exists
      if ($bestPractice->image) {
        \Storage::disk('public')->delete($bestPractice->image);
      }
      $imagePath = $request->file('image')->store('best_practices', 'public');
    }

    $bestPractice->update([
      'title' => $request->title,
      'contents' => $request->contents,
      'category_id' => $request->category_id,
      'tags' => $request->tags,
      'image' => $imagePath, // Update the image path
    ]);

    // Update the redirect route
    return redirect()->route('back_office.best_practices.index')->with('success', 'Best Practice updated successfully.');
  }

  public function destroy(BestPractice $bestPractice)
  {
    $bestPractice->delete();
    return redirect()->route('back_office.best_practices.index')->with('success', 'Best Practice deleted successfully.');
  }
  public function frontOfficeIndex()
  {
    $bestPractices = BestPractice::with('category')->paginate(10);
    return view('best_practices.front_office', compact('bestPractices')); // Update the view path
  }
  public function frontOfficeShow(BestPractice $bestPractice)
  {
    return view('best_practices.front_office_view', compact('bestPractice'));
  }


}
