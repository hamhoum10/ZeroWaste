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
      'description' => 'required|max:500',
    ], [
      'name.required' => 'The category name is required.',
      'name.unique' => 'The category name must be unique.',
      'name.max' => 'The category name must not exceed 255 characters.',
      'description.max' => 'The description must not exceed 500 characters.',
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
  {
    $wasteCategory = WasteCategory::findOrFail($id); // Ensure the category is found

    // Debugging information
    error_log('WasteCategory ID: ' . $id);
    error_log('WasteCategory Name: ' . $wasteCategory->name);

    $request->validate([
      'name' => [
        'required',
        'max:255',
        Rule::unique('waste_categories')->ignore($wasteCategory->id),
      ],
      'description' => 'required|max:500',
    ], [
      'name.required' => 'The category name is required.',
      'name.unique' => 'The category name must be unique, except the one you are editing.',
      'name.max' => 'The category name must not exceed 255 characters.',
      'description.max' => 'The description must not exceed 500 characters.',
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
