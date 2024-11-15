@extends('layouts/front')

@section('title', 'Cart')

@section('page-script')
    <script>
        let countdown = 5;
        const countdownElement = document.querySelector('.countdown');
        
        const interval = setInterval(function() {
            countdownElement.textContent = countdown;
            countdown--;
            if (countdown < 0) {
                clearInterval(interval);
                window.location.href = "{{ route('orders.myOrders') }}";
            }
        }, 1000);
    </script>
@endsection

@section('content')

<div class="container" style="display: flex; justify-content: center; align-items: center; height: 80vh;">
    <div class="card shadow text-center py-5" style="width: 30rem;">
        <div class="card-body d-flex flex-column justify-content-center align-items-center">
            <i class='bx bxs-check-circle' style="color: rgb(50, 186, 50); font-size: 5rem;"></i>
            <p class="card-text mt-3">Your payment has been processed successfully.</p>
            <p class="display-6 text-success">Redirecting in <span class="countdown">5</span> seconds...</p>
        </div>
    </div>
</div>



@endsection
