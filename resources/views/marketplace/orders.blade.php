@extends('layouts/contentNavbarLayout')

@section('title', 'Orders')

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


    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Orders</span>
    </h4>

    <!-- Hoverable Table rows -->
    <div class="card">
        <h5 class="card-header">Orders</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Price</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @if ($orders && $orders->count() >= 1)
                        @foreach ($orders as $order)
                            <tr>
                                <td>
                                    <i class="fab fa-angular fa-lg text-danger me-3"></i>
                                    <strong>{{ $order->user->name }}</strong>
                                </td>
                                <td>
                                    {{ $order->total_price }} DT
                                </td>
                                <td>{{ $order->created_at->format('j F Y, H:i') }}</td>
                                <td>
                                    @if ($order->status == 'pending')
                                        <span class="badge bg-label-warning me-1">{{ $order->status }}</span>
                                    @elseif ($order->status == 'completed')
                                        <span class="badge bg-label-success me-1">{{ $order->status }}</span>
                                    @elseif ($order->status == 'canceled')
                                        <span class="badge bg-label-danger me-1">{{ $order->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1 justify-content-end">
                                        <a href={{ route('orders.show', $order->id) }} class="btn btn-md btn-primary">
                                            Show
                                        </a>
                                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
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
                            <td colspan="5" class="text-center">No orders</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    @yield('order')

@endsection
