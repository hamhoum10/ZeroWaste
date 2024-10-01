@extends('layouts/contentNavbarLayout')

@section('title', 'Products')

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

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin</span></h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <h5 class="card-header">Products</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>
                                    <div class="d-none d-sm-block">Quantity</div>
                                </th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @php
                                // $prod = new Product();
                                // $prod = new stdClass();
                            @endphp
                            @if ($products && $products->count() >= 1)
                                @foreach ($products as $product)
                                    <tr>
                                        <td><strong>{{ $product->name }}</strong>
                                        </td>
                                        <td>{{ $product->price }} DT</td>
                                        <td>
                                            <div class="d-none d-sm-block">{{ $product->quantity }}</div>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-sm-none d-block dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown"><i
                                                        class="bx bx-dots-vertical-rounded"></i></button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('products.edit', $product->id) }}"><i
                                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    <form action="{{ route('products.destroy', $product->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="dropdown-item"><i class="bx bx-trash me-1"></i>
                                                            Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="d-none d-sm-block d-flex gap-2 justify-content-end">
                                                <a href="{{ route('products.edit', $product->id) }}"
                                                    class="text-white btn btn-md btn-primary">Update</a>
                                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-md btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">No Products</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="row justify-content-sm-end justify-content-center">
                    <a href="{{ route('products.create') }}" class="m-3 mx-5 col-10 col-sm-4 btn btn-success">Create
                        a new
                        Product</a>
                </div>
            </div>
        </div>
        <div class="col-xxl">
            @yield('form')
        </div>
    </div>
@endsection
