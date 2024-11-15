<?php

namespace App\Http\Controllers;

use App\Models\WasteCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class WasteCategoryController extends Controller
{
  public function index()
  {
    $wastecategories = WasteCategory::paginate(5);
    return view('wastecategories.index', compact('wastecategories'));
  }

  public function create()
  {
    return view('wastecategories.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|unique:waste_categories|max:255',
      'description' => 'nullable|max:500', // Add validation for description
    ]);

    WasteCategory::create($request->all());

    return redirect()->route('wastecategories.index')
      ->with('success', 'Waste Category created successfully.');
  }

  public function show($id)
  {
    $wasteCategory = WasteCategory::findOrFail($id); // This works if you use the 'id' directly
    return view('wastecategories.show', compact('wasteCategory'));
  }

  public function edit($id)
  {
    $wasteCategory = WasteCategory::findOrFail($id); // This will also work
    return view('wastecategories.edit', compact('wasteCategory'));
  }

  public function update(Request $request, $id)
  {    $wasteCategory = WasteCategory::findOrFail($id); // This will also work

    // Debug to ensure the category is found
    error_log('WasteCategory ID: ' . $id);
    error_log('WasteCategory Name: ' .$wasteCategory->name);

    $request->validate([
      'name' => [
        'required',
        'max:255',
      ],
      'description' => 'nullable|max:500',
    ]);

    // Update the record
    $wasteCategory->update($request->only(['name', 'description']));

    return redirect()->route('wastecategories.index')
      ->with('success', 'Waste Category updated successfully.');
  }



  public function destroy($id)
  {      $wasteCategory = WasteCategory::findOrFail($id); // This will also work

    $wasteCategory->delete();

    return redirect()->route('wastecategories.index')
      ->with('success', 'Waste Category deleted successfully.'); // This should work
  }
}
