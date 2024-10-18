@extends('marketplace/products')

@section('form')
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Product</h5> <small class="text-muted float-end">Update {{ $product->name }}</small>
        </div>
        <div class="card-body">
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{ $product->name }}" name="name" class="form-control"
                            id="basic-default-name" placeholder="Product Name" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-company">Price</label>
                    <div class="col-sm-10">
                        <input type="number" value="{{ $product->price }}" name="price" class="form-control"
                            id="basic-default-company" placeholder="Product Price" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-email">Quantity</label>
                    <div class="col-sm-10">
                        <input type="number" value="{{ $product->quantity }}" name="quantity" class="form-control"
                            id="basic-default-company" placeholder="Product Quantity" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-message">Description</label>
                    <div class="col-sm-10">
                        <textarea name="description" id="basic-default-message" class="form-control" placeholder="Product Description"
                            aria-label="Product Description" aria-describedby="basic-icon-default-message2">{{ $product->description }}</textarea>
                    </div>
                </div>
                <img class="img-fluid d-flex mx-auto my-4" src="{{ asset('assets/img/products/' . $product->image_url) }}"
                    alt="{{ $product->name }}" />
                <div class="row mb-3">
                    <label for="formFile" class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-10">
                        <input name="image" class="form-control" type="file" id="formFile">
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
