
<div class="mx-5 vh-100 d-flex flex-column" wire:model.defer="selectedDoctor">
  @if(is_array($selectedDoctor) && !empty($selectedDoctor))
    <div class="modal fade" id="doctorPreviewModal" tabindex="-1" role="dialog" aria-labelledby="doctorPreviewModalTitle" aria-hidden="true">
      <div class="px-5 py-2 modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="card" style="">
            <div class="row no-gutters">
              <div class="col-xl-4 border-right">
                <img class="card-img-top" src="{{ asset('assets/avatar/' . ($selectedDoctor['image_path'] ?? 'default.svg')) }}" alt="doctor's profile">
              </div>
              <div class="col-xl-8">
                <div class="card-body">
                  <h2 class="mb-0 card-title row-cols-sm-1">{{ $selectedDoctor['last_name'] . ', ' . $selectedDoctor['first_name'] . ' ' . $selectedDoctor['middle_name'] . ' ' . $selectedDoctor['doctor_suffix'] }}</h2>
                  <div class="row">
                    <p class="mb-0 card-text text-dark-main-blue col">
                      <strong>
                        {{ $selectedDoctor['master_specialization'] ?? '-'}}
                      </strong>
                    </p>
                    <div class="row col">
                      <p class="mb-0 text-right col">
                        <img src="{{ asset('assets/icon/building.svg') }}" width="10px" alt="">
                        {{ $selectedDoctor['clinic_code_name'] ?? '-'}}
                      </p>
                    </div>
                  </div>
                  <div class="mx-1 row mx-sm-1">
                    @php
                      $sub_specialization_array = [];

                      $sub_specialization_object = json_decode($selectedDoctor['sub_specialization'] ?? '-', true);
                      if (is_array($sub_specialization_object)) {
                        foreach ($sub_specialization_object as $item) {
                          if (isset($item['name'])) {
                            $sub_specialization_array[] = $item['name'];
                          }
                        }
                      }
                    @endphp

                    <p class="p-0 card-text col">
                      <small class="">Sub-specialization in: </small>
                      <b>
                        @if(!empty($sub_specialization_array))
                          @foreach ($sub_specialization_array as $item)
                            <span>{{ $item }}</span>@if(!$loop->last) &bull; @endif
                          @endforeach
                        @else
                          -
                        @endif
                      </b>
                    </p>
                    <div class="row col">
                      <p class="text-right col">
                        <img src="{{ asset('assets/icon/phone.svg') }}" width="15px" alt="">
                        <small>
                          {{ $selectedDoctor['doctor_contact_number'] ?? '-'}}
                        </small>
                      </p>
                    </div>
                  </div>
                  <div class="overflow-auto table-responsive">
                    <table class="table d-xl-block d-xxl-block d-lg-block d-md-none d-sm-none">
                      <thead>
                        <tr>
                          <th scope="col">Monday</th>
                          <th scope="col">Tuesday</th>
                          <th scope="col">Wednesday</th>
                          <th scope="col">Thursday</th>
                          <th scope="col">Friday</th>
                          <th scope="col">Saturday</th>
                          <th scope="col">Sunday</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                          $schedules = json_decode($selectedDoctor['schedule']);
                          $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                          $groupedSchedules = [];

                          foreach ($schedules as $schedule) {
                            $groupedSchedules[$schedule->day_of_week][] = $schedule;
                          }

                          function formatTime($time) {
                            return date('h:i A', strtotime($time));
                          }
                        @endphp
                        @if (!empty($groupedSchedules))
                        @for ($i = 0; $i < max(array_map('count', $groupedSchedules)); $i++)
                          <tr>
                            @foreach ($days as $day)
                              <td class="flex flex-column">
                                @if (isset($groupedSchedules[$day]) && !empty($groupedSchedules[$day][$i]))
                                  @php
                                    $schedule = $groupedSchedules[$day][$i];
                                    $colorClass = $schedule->visit_type === 'walk-in' ? 'badge badge-success' : 'badge badge-primary text-light';
                                  @endphp
                                  <div class="flex-row">
                                    <small>
                                      {{ formatTime($schedule->start_time) }} - <br> {{ formatTime($schedule->end_time) }}<br>
                                    </small>
                                  </div>
                                  <div class="flex-row {{ $colorClass }} ">
                                    <small>
                                      {{ ucfirst($schedule->visit_type) }}
                                    </small>
                                  </div>
                                @endif
                              </td>
                            @endforeach
                          </tr>
                        @endfor
                      @else
                        <tr>
                          <td colspan="{{ count($days) }}" class="text-center">
                            <small class="text-muted">No Schedules available</small>
                          </td>
                        </tr>
                      @endif
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="">
            <div class="px-3 py-3 px-lg-5 py-lg-4 border-left card-footer-bg text-light">
              <label class="h5" for="hom">Accredited HMOs</label>
              @php
                $hmo_object = json_decode($selectedDoctor['doctor_hmo'], false);
              @endphp
              <div class="pl-sm-2">
                @foreach ($hmo_object as $item)
                  <span>{{ $item->name }}</span>@if(!$loop->last) &bull; @endif
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif
  <div class="bg-dark rounded-bottom border-bottom sticky-top" >
    <div class="collapse" id="view-assist" wire:ignore.self >
      <form class="p-3 m-2 row row-cols-lg-3 px-lg-1 row-cols-md-2 row-cols-2 align-content-start text-light " wire:submit.prevent='search'>
        <div class="py-1 col">
          <label for="" class="form-label fw-bold">Last Name of Doctor</label>
          <input type="text" name="" wire:model="searchLastName" class="form-control form-select" placeholder="Any">
        </div>
        <div class="py-1 col">
          <label for="" class="form-label fw-bold">Specialization</label>
          <select name="" wire:model="searchSpecializationNameSelect" class="form-control orm-select">
            <option value="" selected>Any</option>
            @foreach($master_specializations as $master_specialization)
              <option value="{{ $master_specialization->name }}">{{ $master_specialization->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="py-1 col">
          <label for="" class="form-label fw-bold">Sub Specialization</label>
          <select name="" wire:model="searchSubSpecializationNameSelect" class="form-control form-select">
            <option value="" selected>Any</option>
            @foreach($sub_specializations as $sub_specialization)
              <option value="{{ $sub_specialization->name }}">{{ $sub_specialization->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="py-1 col">
          <label for="" class="form-label fw-bold">HMO</label>
          <select name="" wire:model="searchHmoNameSelect" class="form-control form-select">
            <option value="" selected>Any</option>
            @foreach($hmos as $hmo)
              <option value="{{ $hmo->name }}">{{ $hmo->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="py-1 col">
          <label for="" class="form-label fw-bold">Day of Week</label>
          <select name="day" wire:model="searchDayOfWeekSelect" class="form-control form-select">
            <option value="" selected>Any</option>
            <option value="monday">Monday</option>
            <option value="tuesday">Tuesday</option>
            <option value="wednesday">Wednesday</option>
            <option value="thursday">Thursday</option>
            <option value="friday">Friday</option>
            <option value="saturday">Saturday</option>
            <option value="sunday">Sunday</option>
          </select>
        </div>

        <div class="py-1 col" >
          <div class="row row-cols-2">
            <div class="col">
              <label for="searchTimeSelection" class="form-label fw-bold">Time</label>
              <div class="ml-2 row">
                <div class="mr-1 form-check">
                  <input
                    class="form-check-input"
                    type="radio"
                    name="time"
                    id="anytime"
                    value="anytime"
                    wire:model="searchTimeSelect"
                    checked
                  />
                  <label class="form-check-label" for="anytime">
                    Anytime
                  </label>
                </div>
                <div class="mr-1 form-check">
                  <input
                    class="form-check-input"
                    type="radio"
                    name="time"
                    id="am"
                    value="am"
                    wire:model="searchTimeSelect"
                  />
                  <label class="form-check-label" for="am">
                    AM
                  </label>
                </div>
                <div class="mr-1 form-check">
                  <input
                    class="form-check-input"
                    type="radio"
                    name="time"
                    id="pm"
                    value="pm"
                    wire:model="searchTimeSelect"
                  />
                  <label class="form-check-label" for="pm">
                    PM
                  </label>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="ml-2 row">
                <button type="submit" class="mx-1 col btn btn-success text-light" wire:click="search">
                  <img src="{{ asset('assets/icon/search.svg') }}" width="15" alt="">
                  <b>SEARCH</b>
                </button>
                <button class="mx-1 col btn btn-warning" wire:click="resetSearch">
                  <img src="{{ asset('assets/icon/reset.svg') }}" width="15" alt="">
                  <b>RESET</b>
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div
      class="d-flex justify-content-center"
      style="cursor: pointer;"
      data-toggle="collapse" data-target="#view-assist" aria-expanded="true" aria-controls="view-assist"
    >
      <a class="bg-transparent btn">
        <img src="{{ asset('assets/icon/arrow.svg') }}"
        style="" width="30" class="arrow-icon collapse-arrow" alt="">
      </a>
    </div>
  </div>

  @if(empty($doctor_resources))
    <div class="alert alert-warning">
      Unfortunately, we do not have what you are searching for.
      <a href="{{ route('client') }}" class="">Restart?</a>
    </div>
  @else
    <div class="p-0 m-0 mx-5 mt-2 shadow-sm row text-light-bg">
      <div class="p-3 m-0 col-10 h6 font-weight-bold">
        SEARCH RESULTS
      </div>
    </div>
    <div class="px-4 mx-5 mb-5 flex-grow-1"
    wire:scroll.debounce.50ms="$emit('closeSearch')"
    >
      <div class="pb-5 row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach ($doctor_resources as $doctor)
        <div class="my-1 rounded col px-sm-5 px-md-2 px-lg-2" type="button">
          <div class="border-0 shadow-sm card h-100" wire:click="setSelectedId('{{ $doctor->doctor_id }}')">
            <img src="{{ asset('assets/avatar/' . ($doctor->image_path ?? 'default.svg')) }}" class="card-img-top border-bottom" alt="...">
            <div class="card-body d-flex flex-column justify-content-end" >
              <h1 class="mb-0 card-title border-bottom h4">{{ $doctor->last_name . ', ' . $doctor->first_name . ' ' . $doctor->middle_name . ' ' . $doctor->doctor_suffix }}</h1>
              <div class="mb-0 card-title">{{ $doctor->master_specialization ?? '-' }}</div>
            </div>
            @php
              $days_array = [];
              $decoded = json_decode($doctor->day_of_week, true);
              foreach ($decoded as $item) {
                if (isset($item['day_of_week'])) {
                  $days_array[] = $item['day_of_week'];
                }
              }
            @endphp
            <div class="p-0 px-5 py-2 card-footer card-footer-bg">
              @if(empty($days_array))
              <div class="p-0 m-0 text-center align-items-center justify-content-center text-light font-italic font-weight-bold" style="height: 35px; font-size: 15px; line-height: 1; text-decoration: underline;">
                no schedule yet
              </div>
              @else
              <div class="p-0 row d-flex justify-content-between align-items-center" style="height: 35px;">
                <div class="col-auto p-0 m-0">
                  <img src="/assets/icon/day_of_week/monday.svg" height="35" alt="" class="d-block mx-auto @if(!in_array('monday', $days_array)) day-opacity @endif">
                </div>
                <div class="col-auto p-0 m-0">
                  <img src="/assets/icon/day_of_week/tuesday.svg" height="35" alt="" class="d-block mx-auto @if(!in_array('tuesday', $days_array)) day-opacity @endif">
                </div>
                <div class="col-auto p-0 m-0">
                  <img src="/assets/icon/day_of_week/wednesday.svg" height="35" alt="" class="d-block mx-auto @if(!in_array('wednesday', $days_array)) day-opacity @endif">
                </div>
                <div class="col-auto p-0 m-0">
                  <img src="/assets/icon/day_of_week/thursday.svg" height="35" alt="" class="d-block mx-auto @if(!in_array('thursday', $days_array)) day-opacity @endif">
                </div>
                <div class="col-auto p-0 m-0">
                  <img src="/assets/icon/day_of_week/friday.svg" height="35" alt="" class="d-block mx-auto @if(!in_array('friday', $days_array)) day-opacity @endif">
                </div>
                <div class="col-auto p-0 m-0">
                  <img src="/assets/icon/day_of_week/saturday.svg" height="35" alt="" class="d-block mx-auto @if(!in_array('saturday', $days_array)) day-opacity @endif">
                </div>
                <div class="col-auto p-0 m-0">
                  <img src="/assets/icon/day_of_week/sunday.svg" height="35" alt="" class="d-block mx-auto @if(!in_array('sunday', $days_array)) day-opacity @endif">
                </div>
              </div>
              @endif
            </div>
          </div>
        </div>
        @endforeach
      </div>

      @if($doctor_resources->hasPages())
        <div class="mt-4 d-flex justify-content-center" wire:model="selectedId">
          {{ $doctor_resources->links() }}
        </div>
      @endif
    </div>
  @endif
</div>

<script>
  (function() {
    let initialized = false;
    let modalInProcess = false;
    let previewModalTimeout = null;

    function initializeHMOscript() {
      if (initialized) return;
      initialized = true;

    }
    function handleLivewireLoad() {
      if (window.Livewire) {
        initializeHMOscript();
      }

      document.addEventListener('livewire:load', function() {
        initializeHMOscript();
      });

      document.addEventListener('livewire:update', function() {
        if (!initialized && window.Livewire) {
          initializeHMOscript();
        }
      });
    }

    if (document.readyState === 'complete') {
      handleLivewireLoad();
    } else {
      document.addEventListener('DOMContentLoaded', handleLivewireLoad);
      window.addEventListener('load', handleLivewireLoad);
    }
    })();

</script>
