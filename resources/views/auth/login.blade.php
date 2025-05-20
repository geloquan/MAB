<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>

    .card {
      position: relative; /* Required for absolute positioning of children */
      background-color: transparent; /* Remove default background */
      border-radius: 10px;
      overflow: hidden; /* Ensures rounded corners for pseudo-element */
    }

    .card::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.7); /* White with 70% opacity */
      z-index: -1; /* Places it behind content */
    }

    /* Your existing styles */
    body {
      background-image: url("{{ asset('assets/img/MAB_blg.png') }}");
      background-size: cover;
    }
    .container {
      padding-top: 100px;
    }
  </style>

  <meta name="csrf-token" content="{{ csrf_token() }}">


  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="mt-5 row justify-content-center">
      <div class="col-md-6 col-lg-4">
        <div class="shadow card">
          <div class="card-body">
            <div class="mb-3 text-center">
              <img src="{{ asset('assets/logo.svg') }}" width="140" alt="">
            </div>
            <h3 class="mb-4 text-center card-title">Admin Login</h3>
              @if($errors->any())
                <div class="alert alert-danger">
                  {{ $errors->first() }}
                </div>
              @endif

              <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required autofocus>
                </div>

                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="d-grid">
                  <button type="submit" class="btn btn-secondary">Login</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
