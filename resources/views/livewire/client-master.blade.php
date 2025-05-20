<div class="" id="client">
  <div wire:loading>
    <div class="progress position-relative" style="
    position: fixed !important;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-color: rgba(255,255,255,0.8); /* Optional: semi-transparent background */
    z-index: 9999;
    transition: opacity 0.3s ease;
    margin: 0;
    border-radius: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    ">
      <div class="progress-bar progress-bar-striped progress-bar-animated bg-info"
           role="progressbar"
           aria-valuenow="100"
           aria-valuemin="0"
           aria-valuemax="100"
           style="
              width: 80%;
              height: 20px;
              border-radius: 2px;
           ">
      </div>
    </div>
  </div>

  @if (!empty($ads))
    <div id="ads-carousel" class="carousel slide sticky-top" data-ride="carousel" wire:model.defer="ads">
      <div class="carousel-inner">
        @php
          $shuffled_ads = collect($ads)->shuffle();
        @endphp

        @foreach ($shuffled_ads as $index => $ad)
          @if (!empty($ad->large_image_path) && !empty($ad->medium_image_path))
          <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
            <picture>
              <source media="(max-width: 1468px)" srcset="{{ asset('assets/avatar/' . $ad->medium_image_path) }}">
              <source media="(min-width: 1469px)" srcset="{{ asset('assets/avatar/' . $ad->large_image_path) }}">
              <img class="d-block w-100"
                style="max-height: 80vh; object-fit: cover;"
                src="{{ $ad->large_image_path }}"
                alt="{{ $ad->alt_text ?? 'Advertisement' }}">
            </picture>
          </div>
          @endif
        @endforeach
      </div>
      <a class="carousel-control-prev" href="#ads-carousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#ads-carousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  @endif

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark {{ $this->navbar() }}">
    <a class="navbar-brand" href="{{ route('home') }}">
      <img src="{{ asset('assets/logo.svg') }}" width="30"class="align-top d-inline-block" alt="">
      MAB Directories
    </a>
    <ul class="mr-auto navbar-nav">
      <li class="nav-item {{ $selected_tab === 'directory' ? 'disabled' : '' }}">
        <a class="nav-link {{ $selected_tab === 'directory' ? 'disabled text-muted' : 'font-weight-bold' }}"
           href="{{ route('client') }}?tab=directory"
           wire:click="new_tab('directory')">
          Directory <span class="sr-only">(current)</span>
        </a>
      </li>
    </ul>
  </nav>


  @if ($selected_tab === "directory")
    @livewire('client-home')
  @else
    <div class="alert alert-info">Please select a tab</div>
  @endif
</div>
