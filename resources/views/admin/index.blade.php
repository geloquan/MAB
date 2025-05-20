<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

  @livewireStyles
</head>
<body class="">

  @livewire('admin-home')

  <script>
    (function() {
      let initialized = false;
      let modalInProcess = false;
      let previewModalTimeout = null;
      let mutationObservers = [];

      function initializeScript() {
        $(document).on('click', '#logout', function() {
          clearTimeout(previewModalTimeout);
          previewModalTimeout = setTimeout(() => {
            $('#admin #logoutCollapse').modal('show');
            disableOnUploadCreatemodal();
          }, 0);
        });

        $("#menu-toggle").click(function(e) {
          $("#admin").toggleClass("toggled");
        });

        $(document).on('click', '#logout-confirm', function() {
          $('#admin #logoutCollapse').modal('hide');
          window.livewire.emit('logout');
        });

        window.livewire.on('update-url', (data) => {
          console.log(data);
          history.pushState({}, '', data.url);
        })
      }

      function cleanupObservers() {
        mutationObservers.forEach(observer => {
          observer.disconnect();
        });
        mutationObservers = [];
      }

      function handleLivewireLoad() {
        if (window.Livewire) {
          initializeScript();
        }

        document.addEventListener('livewire:load', function() {
          initializeScript();
        });

        document.addEventListener('livewire:update', function() {
          if (!initialized && window.Livewire) {
            initializeScript();
          }
        });

        document.addEventListener('turbo:before-cache', cleanupObservers);
        document.addEventListener('livewire:navigating', cleanupObservers);
      }

      if (document.readyState === 'complete') {
        handleLivewireLoad();
      } else {
        document.addEventListener('DOMContentLoaded', handleLivewireLoad);
        window.addEventListener('load', handleLivewireLoad);
      }
    })();
  </script>

  <script src="{{ asset('js/app.js') }}" defer></script>

  @livewireScripts
</body>
</html>
