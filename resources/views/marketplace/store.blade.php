@extends('layouts/contentNavbarLayout')

@section('title', 'Store')

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/ui-toasts.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Check if the session has a success message
            @if (session('success'))
                var toastElList = [].slice.call(document.querySelectorAll('.toast'));
                var toastList = toastElList.map(function(toastEl) {
                    return new bootstrap.Toast(toastEl);
                });
                // Show the toast
                toastList.forEach(toast => toast.show());
            @endif
        });

        function submitForm() {
            document.getElementById('filter-form').submit();
        }
    </script>
@endsection

@section('content')
    <!-- Toast for Success -->
    @if (session('success'))
        <div class="bs-toast toast align-items-center text-white bg-success border-0 position-fixed bottom-0 start-0 p-3 m-2"
            role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- The rest of your content -->

    <h4 class="fw-bold pt-3 mb-0"><span class="text-muted fw-light">Products</span></h4>

    <nav class="layout-navbar my-4 container-fluid navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
        id="layout-navbar">
        <div class="container-fluid">
            <form action="{{ route('products.index') }}" method="GET" id="filter-form" class="d-flex justify-content-between w-100">
                <div class="navbar-nav align-items-center">
                    <div class="nav-item d-flex align-items-center">
                        <i class="bx bx-search fs-4 lh-0"></i>
                        <input type="text" name="search" class="form-control border-0 shadow-none"
                            placeholder="Search..." aria-label="Search..." value="{{ request('search') }}">
                    </div>
                </div>

                <div class="ms-3 w-25   ">
                    <select class="form-select" name="sort" id="sort-select" aria-label="Sort by"
                        onchange="submitForm()">
                        <option value="" selected hidden>Sort by</option>
                        <option value="name,asc" {{ request('sort') == 'name,asc' ? 'selected' : '' }}>Name ASC</option>
                        <option value="name,desc" {{ request('sort') == 'name,desc' ? 'selected' : '' }}>Name DESC</option>
                        <option value="price,asc" {{ request('sort') == 'price,asc' ? 'selected' : '' }}>Price ASC</option>
                        <option value="price,desc" {{ request('sort') == 'price,desc' ? 'selected' : '' }}>Price DESC
                        </option>
                    </select>
                </div>
            </form>
        </div>
    </nav>

    <!-- Examples -->
    <div class="row mb-5" data-masonry='{"percentPosition": true }'>
        @foreach ($products as $product)
            <div class="col-sm-6 col-lg-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <h6 class="card-subtitle text-muted">{{ $product->description }}</h6>
                        <img class="img-fluid d-flex mx-auto my-4"
                            src="{{ asset('assets/img/products/' . $product->image_url) }}" alt="{{ $product->name }}" />
                        <p class="card-text mb-0">Quantity: {{ $product->quantity }}</p>
                        <h3 class="card-text">Price: {{ $product->price }} DT</h3>
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="d-flex">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                    <input class="form-control me-3 w-50" name="quantity[{{ $product->id }}]" type="number" value="1"
                                        {{ $product->quantity === 0 ? 'disabled' : '' }} />
                                    <button class="btn btn-primary w-100" type="submit"
                                        {{ $product->quantity === 0 ? 'disabled' : '' }}>Add to Cart</button>
                                </div>
                                @error('quantity.' . $product->id)
                                    <span class="mt-2 fs-6 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
