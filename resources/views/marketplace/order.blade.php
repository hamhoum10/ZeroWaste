@extends('marketplace/orders')

@section('title', 'Order')

@section('order')

    <!-- Define the New Offcanvas -->
    <div class="offcanvas offcanvas-end show" tabindex="-1" id="offcanvasEndPage" aria-labelledby="offcanvasEndPageLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasEndPageLabel" class="offcanvas-title">Order Number {{ $order->id }}</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="m-2">
                <p>Total Price: {{ $order->total_price }} DT</p>
                @if ($order->status == 'pending')
                    <div class="btn-group">
                        <button type="button" class="btn btn-warning dropdown-toggle hide-arrow text-uppercase"
                            data-bs-toggle="dropdown" aria-expanded="false">{{ $order->status }} </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-success text-uppercase" href="javascript:void(0);"
                                    data-status="completed" data-endpoint="{{ route('order.update', $order->id) }}">
                                    completed
                                </a></li>
                            <li><a class="dropdown-item text-danger text-uppercase" href="javascript:void(0);"
                                    data-status="canceled" data-endpoint="{{ route('order.update', $order->id) }}">
                                    canceled
                                </a></li>
                        </ul>
                    </div>
                @elseif ($order->status == 'completed')
                    <span class="badge bg-label-success me-1">{{ $order->status }}</span>
                @elseif ($order->status == 'canceled')
                    <span class="badge bg-label-danger me-1">{{ $order->status }}</span>
                @endif
            </div>
            <hr>
            <h5 id="offcanvasEndPageLabel" class="offcanvas-title">User</h5>
            <div class="m-2">
                <p>Name: {{ $order->user->name }}</p>
                <p>Email: {{ $order->user->email }}</p>
                <p>Date: {{ $order->created_at->format('j F Y, H:i') }}</p>
            </div>
            <hr>
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $orderItem)
                        <tr>
                            <td>{{ $orderItem->product->name }}</td>
                            <td>{{ $orderItem->product->price }} DT</td>
                            <td>{{ $orderItem->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function() {
                const status = this.getAttribute('data-status');
                const endpoint = this.getAttribute('data-endpoint');

                // Make the AJAX request to update the order status
                fetch(endpoint, {
                        method: 'PUT', // Change to PUT
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
                        },
                        body: JSON.stringify({
                            status: status
                        })
                    })
                    .then(response => {
                        if (response.ok) {
                            // Handle success, e.g., update UI or show a message
                            console.log('Order status updated successfully.');
                            // Optionally refresh or update the UI to reflect the change
                            location.reload(); // Reload page to see changes
                        } else {
                            // Handle error
                            console.error('Error updating order status.');
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                    });
            });
        });
    </script>

@endsection
