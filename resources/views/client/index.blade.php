<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Public</title>

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

  <style>
    #loading-screen {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.9);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      transition: opacity 0.3s ease;
    }

    .spinner {
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
  @livewireStyles
</head>
<body id="body" class="">

  @livewire('client-master')

  <script src="{{ asset('js/app.js') }}" defer></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      window.livewire.on('urlUpdated', (data) => {
        window.history.pushState({}, '', data.newUrl);
      });
      let modalInProcess = false;
      let previewModalTimeout = null;

      window.livewire.on('previewModal', () => {
          clearTimeout(previewModalTimeout);
          previewModalTimeout = setTimeout(() => {
            $('#doctorPreviewModal').modal('show');
          }, 300); // 300ms delay
        });
      });
  </script>
  @livewireScripts
</body>
</html>
