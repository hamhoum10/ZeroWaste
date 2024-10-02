<?php

namespace App\Http\Controllers;

use App\Models\BestPractice;
use App\Models\Category;
use Illuminate\Http\Request;

class BestPracticeController extends Controller
{
  public function index()
  {
    $bestPractices = BestPractice::with('category', 'author')->paginate(10);
    return view('best_practices.index', compact('bestPractices'));
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
    ]);

    BestPractice::create([
      'title' => $request->title,
      'contents' => $request->contents,
      'category_id' => $request->category_id,
      // Remove 'author_id' line
      // 'author_id' => auth()->id(),
      'tags' => $request->tags,
    ]);

    return redirect()->route('best_practices.index')->with('success', 'Best Practice added successfully.');
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
    ]);

    $bestPractice->update([
      'title' => $request->title,
      'contents' => $request->contents,
      'category_id' => $request->category_id,
      'tags' => $request->tags,
    ]);

    return redirect()->route('best_practices.index')->with('success', 'Best Practice updated successfully.');
  }

  public function destroy(BestPractice $bestPractice)
  {
    $bestPractice->delete();
    return redirect()->route('best_practices.index')->with('success', 'Best Practice deleted successfully.');
  }
}
