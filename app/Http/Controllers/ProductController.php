<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('marketplace.store', compact('products'));
    }

    public function admin()
    {
        $products = Product::all();
        return view('marketplace.products', compact('products'));
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        $product = new Product();
        return view('marketplace.createProduct', compact('products', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('image_url')) {
            $imageName = time() . '.' . $request->image_url->extension(); // Create a unique name for the image
            $request->image_url->move(public_path('assets/img/products'), $imageName); // Move the image to the assets folder
        } else {
            $imageName = null; // Handle the case where no image is uploaded
        }
    
        // Create the product with the image name
        $product = Product::create(array_merge($request->all(), ['image_url' => $imageName]));

        session()->flash('success', 'Successfully Added!');

        return redirect()->back(); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = Product::all();
        $product = Product::findOrFail($id);
        return view('marketplace.updateProduct', compact('products', 'product'));
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
        $product = Product::findOrFail($id);
        $imageName = $product->image_url; // Use the existing image URL as default

        // Check if a new image has been uploaded
        if ($request->hasFile('image')) {
            // Create a unique name for the new image
            $imageName = time() . '.' . $request->image->extension(); 
            // Move the new image to the assets folder
            $request->image->move(public_path('assets/img/products'), $imageName);
        }
    
        // Update the product with the request data, including the image URL
        $product->update(array_merge($request->all(), ['image_url' => $imageName]));

        session()->flash('success', 'Successfully Updated!');

        return redirect()->back(); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image_url) {
            $imagePath = public_path('assets/img/products/' . $product->image_url);
            if (file_exists($imagePath)) {
                unlink($imagePath); // Delete the image file
            }
        }
        $product->delete();

        return redirect()->route('products.admin')->with('success', 'Successfully Deleted!');
    }
}
