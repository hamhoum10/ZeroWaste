@extends('layouts.front')

@section('content')
  <div class="container py-5">
    <h1 class="text-center mb-4">Create Recycling Tip</h1>
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow-sm">
          <div class="card-body">
            <form action="{{ route('recycling-tips.store') }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
              </div>
              <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" name="category" class="form-control" required>
              </div>
              <button type="button" class="btn btn-secondary mt-2" id="generate-tip">Generate Tip with AI</button>
              <button type="submit" class="btn btn-primary btn-block mt-2">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('generate-tip').addEventListener('click', function () {
      // Get the title value from the form
      const title = document.querySelector('input[name="title"]').value;

      fetch("{{ route('recycling-tips.generate') }}", {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Content-Type': 'application/json',
        },
        // Send the title as part of the request payload
        body: JSON.stringify({title: title})
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Populate the form fields with generated tip data
            document.querySelector('textarea[name="description"]').value = data.tip.description;
            document.querySelector('input[name="category"]').value = data.tip.category;
          } else {
            alert('Could not generate a tip. Please try again.');
          }
        });
    });

  </script>
@endsection
