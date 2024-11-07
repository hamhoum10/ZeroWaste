@extends('layouts/front')

@section('content')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  <div class="container-fluid p-0 mt-4">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Waste Category: {{ ucwords($wasteCategory->name) }}</h3>
          </div>
          <div class="card-body">
            <small class="text-light fw-semibold">Waste Category Details</small>
            <dl class="row mt-2">
              <dt class="col-sm-3"><i class="fas fa-recycle"></i> Name</dt>
              <dd class="col-sm-9">{{ $wasteCategory->name }}</dd>

              <dt class="col-sm-3"><i class="fas fa-info-circle"></i> Description</dt>
              <dd class="col-sm-9">{{ $wasteCategory->description }}</dd>

              <dt class="col-sm-3"><i class="fas fa-calendar-alt"></i> Created At</dt>
              <dd class="col-sm-9">{{ $wasteCategory->created_at->format('Y-m-d \a\t H:i') }}</dd>

              <dt class="col-sm-3"><i class="fas fa-calendar-check"></i> Updated At</dt>
              <dd class="col-sm-9">{{ $wasteCategory->updated_at->format('Y-m-d \a\t H:i') }}</dd>
            </dl>
          </div>
          {{-- <div class="card-footer text-end">
            <a href="{{ route('wastecategories.index') }}" class="btn btn-secondary">Back to Categories</a>
          </div> --}}
        </div>
      </div>
    </div>
  </div>
@endsection
