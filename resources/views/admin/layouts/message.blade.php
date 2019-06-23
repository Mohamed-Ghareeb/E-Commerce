@if($errors->all())

  @foreach ($errors->all() as $error)

    <div class="alert alert-danger">
        <p>{{ $error }}</p>
    </div>

  @endforeach

@endif

@if (session()->has('success'))

  <div class="alert alert-success">
      <h2>{{ session('success') }}</h2>
  </div>

@endif

@if (session()->has('error'))

  <div class="alert alert-danger">
      <h2>{{ session('error') }}</h2>
  </div>

@endif
