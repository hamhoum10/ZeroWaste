@extends('layouts/contentNavbarLayout')

@section('title', 'Cards Basic - UI Elements')

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
    </script>
@endsection

@section('content')
    <!-- Toast for Success -->
    @if (session('success'))
        <div class="bs-toast toast align-items-center text-white bg-success border-0 position-fixed bottom-0 start-0 p-3 m-2" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
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

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Products</span></h4>

    <!-- Examples -->
    <div class="row mb-5">
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
                                    <input class="form-control me-3 w-50" name="quantity" type="number" value="1" />
                                    <button class="btn btn-primary w-100" type="submit">Add to Cart</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
