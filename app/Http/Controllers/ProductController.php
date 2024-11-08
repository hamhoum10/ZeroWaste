<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\LogService;
use App\Services\StatisticService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function __construct(StatisticService $statisticService, LogService $logService)
    {
        $this->middleware('role:admin')->only(['admin', 'create', 'store', 'edit', 'update', 'destroy']);
        $this->middleware('role:user')->only(['index']);
        $this->statisticService = $statisticService;
        $this->logService = $logService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Product::query();
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->has('sort') && !empty($request->sort)) {
            $sort = explode(',', $request->sort); // ['name', 'asc']
            $query->orderBy($sort[0], $sort[1]);
        }

        $products = $query->get();
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'description' => 'required|nullable|string',
            'quantity' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:0',
            'image_url' => 'required|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image_url')) {
            $imageName = time() . '.' . $request->image_url->extension();
            $request->image_url->move(public_path('assets/img/products'), $imageName);
        } else {
            $imageName = null;
        }
    
        $product = Product::create(array_merge($request->all(), ['image_url' => $imageName]));

        session()->flash('success', 'Successfully Added!');

        // Update the total users statistic
        $this->statisticService->updateAllStatistics();

        // Log the "make_order" action
        $this->logService->logAction('make_product', 'Product created with ID: ' . $product->id);

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
        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'name')->ignore($id)
            ],
            'description' => 'required|nullable|string',
            'quantity' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $imageName = $product->image_url;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension(); 
            $request->image->move(public_path('assets/img/products'), $imageName);
        }
    
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
                unlink($imagePath);
            }
        }
        $product->delete();

        return redirect()->route('products.admin')->with('success', 'Successfully Deleted!');
    }
}