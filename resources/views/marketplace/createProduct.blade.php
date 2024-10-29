@extends('marketplace/products')

@section('form')
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Product</h5> <small class="text-muted float-end">Create a new Product</small>
        </div>
        <div class="card-body">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" id="basic-default-name"
                            placeholder="Product Name" value="{{ old('name') }}" />
                            @error('name')
                                <span class="fs-6 text-danger">{{ $message }}</span>
                            @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-company">Price</label>
                    <div class="col-sm-10">
                        <input type="number" name="price" class="form-control" id="basic-default-company"
                            placeholder="Product Price" value="{{ old('price') }}" />
                            @error('price')
                                <span class="fs-6 text-danger">{{ $message }}</span>
                            @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-email">Quantity</label>
                    <div class="col-sm-10">
                        <input type="number" name="quantity" class="form-control" id="basic-default-company"
                            placeholder="Product Quantity" value="{{ old('quantity') }}" />
                            @error('quantity')
                                <span class="fs-6 text-danger">{{ $message }}</span>
                            @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-message">Description</label>
                    <div class="col-sm-10">
                        <textarea id="basic-default-message" name="description" class="form-control" placeholder="Product Description"
                            aria-label="Product Description" value="{{ old('description') }}" aria-describedby="basic-icon-default-message2"></textarea>
                            @error('description')
                                <span class="fs-6 text-danger">{{ $message }}</span>
                            @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="formFile" class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-10">
                        <input name="image_url" class="form-control" type="file" id="formFile">
                        @error('image_url')
                                <span class="fs-6 text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
