<div id="admin" class="d-flex">
  <div class="modal fade" id="logoutCollapse" wire:ignore.self >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-light">
          <h5 class="modal-title"><b>Logout...</b></h5>
          <button type="button" class="close" data-dismiss="modal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="logout">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="z-index: 1080;">
          Are you sure to logout?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" class="close-logout" data-dismiss="modal" aria-label="Close">Close</button>
          <button type="button" class="btn btn-primary" id="logout-confirm">Confirm</button>
        </div>
      </div>
    </div>
  </div>
  <div id="sidebar-wrapper" class="">
    <div class="pt-3 mx-auto position-sticky">
      <div class="p-0 mx-auto mb-3 col justify-content-start">
        <a class="p-1 h4 d-flex justify-content-center align-items-center text-light" href="{{ route('home') }}">MAB Directories</a>
        <div class="mx-1 list-group list-group-flush">
          @auth
            @if(auth()->user()->role_type === 'master')
              <a class="text-left btn list-group-item" data-toggle="collapse" href="#resource-tabs" role="button" aria-expanded="false" aria-controls="resource-tabs">
                RESOURCE
              </a>
              <div class="border shadow-lg list-group list-group-flush border-light collapse" class="" id="resource-tabs" wire:ignore.self>
                <button
                  class="list-group-item list-group-item-action text-left pl-5 {{ $selected_tab === 'doctor' ? 'active' : '' }}"
                  href="{{ route('admin.dashboard') }}?tab=doctor"
                  wire:click="new_tab('doctor')">
                  DOCTOR
                </button>
                <button
                  class="list-group-item list-group-item-action text-left pl-5 {{ $selected_tab === 'hmo' ? 'active' : '' }}"
                  href="{{ route('admin.dashboard') }}?tab=hmo"
                  wire:click="new_tab('hmo')">
                  HMO
                </button>
                <button
                  class="list-group-item list-group-item-action text-left pl-5 {{ $selected_tab === 'specialization' ? 'active' : '' }}"
                  href="{{ route('admin.dashboard') }}?tab=specialization"
                  wire:click="new_tab('specialization')">
                  SPECIALIZATION
                </button>
              </div>
              <a class="text-left btn list-group-item" data-toggle="collapse" href="#advertisement-tabs" role="button" aria-expanded="false" aria-controls="advertisement-tabs">
                ADVERTISEMENT
              </a>
              <div class="border shadow-lg list-group list-group-flush border-light collapse" class="" id="advertisement-tabs" wire:ignore.self>
                <button
                  class="list-group-item list-group-item-action text-left pl-5 {{ $selected_tab === 'ads-setup' ? 'active' : '' }}"
                  href="{{ route('admin.dashboard') }}?tab=ads-setup"
                  wire:click="new_tab('ads-setup')">
                  ADS SETUP
                </button>
              </div>
            @elseif(auth()->user()->role_type === 'secretary')

            @elseif(auth()->user()->role_type === 'kiosk')

            @endif
          @endauth
        </div>
      </div>
    </div>
  </div>

  <div class="" id="page-content-wrapper">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary" style="">
      <a class="mr-4" id="menu-toggle">
        <i class="fas fa-bars"></i>
        <img id="title-tab" src="{{ asset('assets/icon/arrow-left.svg') }}" width="30" alt="">
      </a>
      <div class="navbar-brand">
        @if ($selected_tab === "doctor" ||
        $selected_tab === "hmo" ||
        $selected_tab === "specialization"||
        $selected_tab === "ads-setup")
          <h1 class="text-light">
            <b>
              {{ Str::upper($selected_tab) }}
            </b>
          </h1>
        @else
          <h1 class="h2 text-light">Select a tab</h1>
        @endif
      </div>

      <div class="mb-2 btn-toolbar mb-md-0">
        <a id="logout" class="btn btn-sm btn-outline-secondary">
          Logout
        </a>
      </div>
    </nav>

    <div class="container-fluid">

      @auth
        @if(auth()->user()->role_type === 'master')

          @if ($selected_tab === "doctor")
            @livewire('admin.doctor')
          @elseif ($selected_tab === "hmo")
            @livewire('admin.hmo')
          @elseif ($selected_tab === "specialization")
            @livewire('admin.specialization')
          @elseif ($selected_tab === "ads-setup")
              @livewire('admin.ads-setup')
          @else
            <div class="alert alert-info">Please select a tab</div>
          @endif
        @endif
      @endauth
    </div>
  </div>
</div>

