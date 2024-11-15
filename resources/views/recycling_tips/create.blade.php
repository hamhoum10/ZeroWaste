@extends('layouts.front')

@section('content')
  <div class="container py-5">
    <h1 class="text-center mb-4">Create Recycling Tip</h1>
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow-sm">
          <div class="card-body">
            <!-- Show Validation Errors -->
            @if($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ route('recycling-tips.store') }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" >
              </div>
              <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" class="form-control" rows="10" >{{ old('description') }}</textarea>
              </div>
              <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" name="category" class="form-control" value="{{ old('category') }}" >
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <button type="submit" class="btn btn-primary btn-block mt-2">Submit</button>
                <button type="button" class="btn btn-secondary mt-2" id="generate-tip">Generate Tips with AI</button>
                <a href="{{ url('/my-recycling-tips') }}" class="btn btn-secondary btn-block mt-2">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('generate-tip').addEventListener('click', function () {
      const title = document.querySelector('input[name="title"]').value;

      if (!title) {
        alert("Please enter a title to generate a tip.");
        return;
      }

      fetch("{{ route('recycling-tips.generate') }}", {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({title: title})
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            document.querySelector('textarea[name="description"]').value = data.tip.description;
            document.querySelector('input[name="category"]').value = data.tip.category;
          } else {
            alert('Could not generate a tip. Please try again.');
          }
        });
    });
  </script>
@endsection
