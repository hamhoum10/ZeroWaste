@extends('layouts/contentNavbarLayout')

@section('title', 'Cart')

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

            const quantityInputs = document.querySelectorAll('.quantity-input');

            quantityInputs.forEach(input => {
                input.addEventListener('input', function() {
                    // Update the corresponding hidden input
                    const hiddenInputId = 'hidden-quantity-' + this.dataset.cartItemId;
                    document.getElementById(hiddenInputId).value = this.value;
                });
            });
        });
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
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Cart</span>
    </h4>

    <!-- Hoverable Table rows -->
    <div class="card">
        <h5 class="card-header">Items</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @if ($cart && $cart->cartItems && $cart->cartItems->count() >= 1)
                        @foreach ($cart->cartItems as $cart_item)
                            <tr>
                                <td>
                                    <i class="fab fa-angular fa-lg text-danger me-3"></i>
                                    <strong>{{ $cart_item->product->name }}</strong>
                                </td>
                                <td>
                                    <form action="{{ route('cart.update', $cart_item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" class="form-control quantity-input" name="quantity"
                                            value="{{ $cart_item->quantity }}" min="1"
                                            max={{ $cart_item->product->quantity }} style="width: 100px;"
                                            data-cart-item-id="{{ $cart_item->id }}" onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td>{{ $cart_item->product->price }} DT</td>
                                <td class="d-flex gap-1 justify-content-end">
                                    <form action="{{ route('cart.destroy', $cart_item->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-md btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center">No items in cart</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mt-5 justify-content-md-end">
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Final Price</h5>
                    <h3 class="card-text">{{ $cart->total_price ?? 0 }} DT</h3>
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <button class="btn btn-md btn-primary">Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
