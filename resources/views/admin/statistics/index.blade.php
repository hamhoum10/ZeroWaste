@extends('layouts.blankLayout')

@section('content')
  <div class="container">
    <h1>Statistics Dashboard</h1>
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5>Total Users</h5>
            <p>{{ $totalUsers }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5>Total Orders</h5>
            <p>{{ $totalOrders }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5>Total Revenue</h5>
            <p>${{ number_format($totalRevenue, 2) }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
