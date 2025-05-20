<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MAB Directory</title>
  <style>
    .gradient-text {
      background: linear-gradient(to right, #ff6b35, #ff3366);
      -webkit-background-clip: text;
      color: transparent;
    }

    .full-height {
      min-height: 100vh;
    }
  </style>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body>
  <div class="container d-flex align-items-center justify-content-center full-height">
    <div class="text-center">
      <div class="mb-4">
        <img src="/assets/logo.svg" alt="logo" class="img-fluid" style="max-width: 200px;">
      </div>

      <h1 class="display-4 fw-bold mb-5 gradient-text">MAB Directory</h1>

      <div class="d-grid gap-2 col-6 mx-auto btn-group-lg">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg">ADMIN</a>
        <a href="{{ route('client') }}" class="btn btn-secondary btn-lg">PUBLIC</a>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS (optional, but recommended) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
