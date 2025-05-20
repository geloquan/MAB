<div class="mb-3" id="ads-setup">

  <div id="createModal" class="modal fade" wire:ignore.self>
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-light">
          <h5 class="modal-title"><b>Adding Advertisement Record</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit.prevent="proceedCreate">
          <div class="modal-body">
            <div class="mb-1 form-group row">
              <div class="col">
                <label class="mt-3 form-label fw-bold">Name</label>
                <input type="text" wire:model.defer="newScheduleName" >
              </div>
              <div class="col">
                <label class="mt-3 form-label fw-bold">Active</label>
                <input type="checkbox" wire:model.defer="newScheduleActive">
              </div>
            </div>
            <div class="mb-1 form-group">
              <label class="mt-3 form-label fw-bold">Large Banner Size</label>
              <div class="pb-0 input-group">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="create-modal-profile" wire:model.defer="largeFile">
                  <label class="custom-file-label" for="">Choose file</label>
                </div>
              </div>
              <img src="{{ asset('assets/avatar/' . $largeFilePath) }}" width="60" alt="">
            </div>

            <div class="mb-1 form-group">
              <label class="mt-3 form-label fw-bold">Medium Banner Size</label>
              <div class="pb-0 input-group">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="create-modal-profile" wire:model.defer="mediumFile" wire:loading.attr="disabled">
                  <label class="custom-file-label" for="">Choose file</label>
                </div>
              </div>
              <img src="{{ asset('assets/avatar/' . $mediumFilePath) }}" width="60" alt="">
            </div>

            <div class="mb-1 form-group">
              <label class="mt-3 form-label fw-bold">Day</label>
              <div class="flex-row btn-group btn-group-toggle d-flex" data-toggle="buttons">
                <label class="btn btn-outline-primary {{ $newScheduleDateSelect === 'today' ? 'active' : '' }}">
                  <input
                    class="form-check-input"
                    type="radio"
                    name="hmo"
                    id="self-pay"
                    value="today"
                    wire:model="newScheduleDateSelect"
                    autocomplete="off"
                  />
                  Today
                </label>
                <label class="btn btn-outline-primary {{ $newScheduleDateSelect === 'tomorrow' ? 'active' : '' }}">
                  <input
                    class="form-check-input"
                    type="radio"
                    name="hmo"
                    id="self-pay"
                    value="tomorrow"
                    wire:model="newScheduleDateSelect"
                    autocomplete="off"
                  />
                  Tomorrow
                </label>
                <label class="btn btn-outline-primary {{ $newScheduleDateSelect === 'specifyRange' ? 'active' : '' }}"
                  href="#specific-date-range"
                  data-toggle="collapse"
                aria-expanded="{{ $newScheduleDateSelect === 'specifyRange' ? 'true' : 'false' }}"
                aria-controls="specific-date-range"
                >
                  <input
                    class="form-check-input"
                    type="radio"
                    name="hmo"
                    id="self-pay"
                    value="specifyRange"
                    wire:model="newScheduleDateSelect"
                    autocomplete="off"
                  />
                  Specific Range
                </label>
              </div>
            </div>

            <div id="specific-date-range" class="collapse {{ $newScheduleDateSelect === 'specifyRange' ? 'show' : '' }}">
              <div class="mx-2 row">
                <div class="p-0 input-group col">
                  <div class="input-group-append">
                    <span class="input-group-text" id="">Start</span>
                  </div>
                  <input class="form-control" type="date" class="form-control" wire:model="newScheduleSpecifyDateStart" name="" placeholder="" min="{{ now()->addHours(8)->format('Y-m-d') }}">
                </div>

                <div class="p-0 input-group col">
                  <div class="input-group-append">
                    <span class="input-group-text" id="">End</span>
                  </div>
                  <input class="form-control" type="date" class="form-control" wire:model="newScheduleSpecifyDateEnd" name="" placeholder="" min="{{ now()->addHours(8)->format('Y-m-d') }}">
                </div>
              </div>
            </div>

            <div class="mb-1 form-group">
              <label class="mt-3 form-label fw-bold">Time</label>
              <div class="flex-row btn-group btn-group-toggle d-flex" data-toggle="buttons">
                <label class="btn btn-outline-primary {{ $newScheduleTimeSelect === 'whole_day' ? 'active' : '' }}">
                  <input
                    class="form-check-input"
                    type="radio"
                    name="hmo"
                    id="self-pay"
                    value="whole_day"
                    wire:model="newScheduleTimeSelect"
                    autocomplete="off"
                  />
                  Whole Day
                </label>
                <label class="btn btn-outline-primary {{ $newScheduleTimeSelect === 'specific' ? 'active' : '' }}"
                  href="#specific-time-range"
                  data-toggle="collapse"
                aria-expanded="{{ $newScheduleTimeSelect === 'specific' ? 'true' : 'false' }}"
                aria-controls="specific-time-range"
                >
                  <input
                    class="form-check-input"
                    type="radio"
                    name="hmo"
                    id="self-pay"
                    value="specific"
                    wire:model="newScheduleTimeSelect"
                    autocomplete="off"
                  />
                  Specific Range
                </label>
              </div>
              <div id="specific-time-range" class="collapse {{ $newScheduleTimeSelect === 'specific' ? 'show' : '' }}">
                <div class="mx-2 row">
                  <div class="p-0 m-1 input-group col">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Start</span>
                    </div>
                    <input type="time" step="900" class="form-control" wire:model="newScheduleSpecifyTimeStart" placeholder="">
                  </div>

                  <div class="p-0 m-1 input-group col">
                    <div class="input-group-prepend">
                      <span class="input-group-text">End</span>
                    </div>
                    <input type="time" step="900" class="form-control" wire:model="newScheduleSpecifyTimeEnd" placeholder="">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="create-cancel" data-dismiss="modal" aria-label="Close">Close</button>
            <button type="submit" class="btn btn-primary" id="">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <div class="modal fade" id="editModal" wire:ignore.self>
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-light">
          <h5 class="modal-title"><b>Editing Advertisement Record</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit.prevent="proceedEdit">
          <div class="modal-body">
            <div class="mb-1 form-group row">
              <div class="col">
                <label class="mt-3 form-label fw-bold">Name</label>
                <input type="text" wire:model.defer="targetScheduleName">
              </div>
              <div class="col">
                <label class="mt-3 form-label fw-bold">Active</label>
                <input type="checkbox" wire:model.defer="targetScheduleActive">
              </div>
            </div>
            <div class="mb-1 form-group">
              <label class="mt-3 form-label fw-bold">Large Banner Size</label>
              <div class="pb-0 input-group">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="edit-modal-profile" wire:model.defer="largeFile" wire:loading.attr="disabled">
                  <label class="custom-file-label" for="">Choose file</label>
                </div>
              </div>
              <img src="{{ asset('assets/avatar/' . $largeFilePath) }}" width="60" alt="">
            </div>

            <div class="mb-1 form-group">
              <label class="mt-3 form-label fw-bold">Medium Banner Size</label>
              <div class="pb-0 input-group">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="edit-modal-profile" wire:model.defer="mediumFile" wire:loading.attr="disabled">
                  <label class="custom-file-label" for="">Choose file</label>
                </div>
              </div>
              <img src="{{ asset('assets/avatar/' . $mediumFilePath) }}" width="60" alt="">
            </div>

            <div class="mb-1 form-group">
              <label class="mt-3 form-label fw-bold">Day</label>
              <div class="flex-row btn-group btn-group-toggle d-flex" data-toggle="buttons">
                <label class="btn btn-outline-primary {{ $targetScheduleDateSelect === 'today' ? 'active' : '' }}">
                  <input
                    class="form-check-input"
                    type="radio"
                    name="hmo"
                    id="self-pay"
                    value="today"
                    wire:model="targetScheduleDateSelect"
                    autocomplete="off"
                  />
                  Today
                </label>
                <label class="btn btn-outline-primary {{ $targetScheduleDateSelect === 'tomorrow' ? 'active' : '' }}">
                  <input
                    class="form-check-input"
                    type="radio"
                    name="hmo"
                    id="self-pay"
                    value="tomorrow"
                    wire:model="targetScheduleDateSelect"
                    autocomplete="off"
                  />
                  Tomorrow
                </label>
                <label class="btn btn-outline-primary {{ $targetScheduleDateSelect === 'specifyRange' ? 'active' : '' }}"
                  href="#specific-date-range"
                  data-toggle="collapse"
                aria-expanded="{{ $targetScheduleDateSelect === 'specifyRange' ? 'true' : 'false' }}"
                aria-controls="specific-date-range"
                >
                  <input
                    class="form-check-input"
                    type="radio"
                    name="hmo"
                    id="self-pay"
                    value="specifyRange"
                    wire:model="targetScheduleDateSelect"
                    autocomplete="off"
                  />
                  Specific Range
                </label>
              </div>
            </div>

            <div id="specific-date-range" class="collapse {{ $targetScheduleDateSelect === 'specifyRange' ? 'show' : '' }}">
              <div class="mx-2 row">
                <div class="p-0 input-group col">
                  <div class="input-group-append">
                    <span class="input-group-text" id="">Start</span>
                  </div>
                  <input class="form-control" type="date" class="form-control" wire:model="targetScheduleSpecifyDateStart" name="" placeholder="" min="{{ now()->addHours(8)->format('Y-m-d') }}">
                </div>

                <div class="p-0 input-group col">
                  <div class="input-group-append">
                    <span class="input-group-text" id="">End</span>
                  </div>
                  <input class="form-control" type="date" class="form-control" wire:model="targetScheduleSpecifyDateEnd" name="" placeholder="" min="{{ now()->addHours(8)->format('Y-m-d') }}">
                </div>
              </div>
            </div>

            <div class="mb-1 form-group">
              <label class="mt-3 form-label fw-bold">Time</label>
              <div class="flex-row btn-group btn-group-toggle d-flex" data-toggle="buttons">
                <label class="btn btn-outline-primary {{ $targetScheduleTimeSelect === 'whole_day' ? 'active' : '' }}">
                  <input
                    class="form-check-input"
                    type="radio"
                    name="hmo"
                    id="self-pay"
                    value="whole_day"
                    wire:model="targetScheduleTimeSelect"
                    autocomplete="off"
                  />
                  Whole Day
                </label>
                <label class="btn btn-outline-primary {{ $targetScheduleTimeSelect === 'specific' ? 'active' : '' }}"
                  href="#specific-time-range"
                  data-toggle="collapse"
                aria-expanded="{{ $targetScheduleTimeSelect === 'specific' ? 'true' : 'false' }}"
                aria-controls="specific-time-range"
                >
                  <input
                    class="form-check-input"
                    type="radio"
                    name="hmo"
                    id="self-pay"
                    value="specific"
                    wire:model="targetScheduleTimeSelect"
                    autocomplete="off"
                  />
                  Specific Range
                </label>
              </div>
              <div id="specific-time-range" class="collapse {{ $targetScheduleTimeSelect === 'specific' ? 'show' : '' }}">
                <div class="mx-2 row">
                  <div class="p-0 m-1 input-group col">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Start</span>
                    </div>
                    <input type="time" step="900" class="form-control" wire:model="targetScheduleSpecifyTimeStart" placeholder="">
                  </div>

                  <div class="p-0 m-1 input-group col">
                    <div class="input-group-prepend">
                      <span class="input-group-text">End</span>
                    </div>
                    <input type="time" step="900" class="form-control" wire:model="targetScheduleSpecifyTimeEnd" placeholder="">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="edit-cancel" data-dismiss="modal" aria-label="Close">Close</button>
            <button type="submit" class="btn btn-primary" id="">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <div id="deleteModal" class="modal fade">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-light">
          <h5 class="modal-title"><b>Deleting Advertisement Record</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>
            Are you sure to delete?
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          <button id="delete-confirmed" type="button" class="btn btn-primary">Yes</button>
        </div>
      </div>
    </div>

  </div>

  <div class="my-1 btn-group btn-group-toggle" data-toggle="buttons">
    <div class="btn-group" role="group" aria-label="Basic example">
      <button type="button" class="btn btn-primary text-light" wire:click="setSelected('0', 'create')">
        <img src="{{ asset("assets/icon/ads.svg") }}" width="20" alt="">
          ADD TO SCHEDULE
      </button>
    </div>
  </div>

  <div class="mb-3 card ">
    <div class="card-header font-weight-bold" data-toggle="collapse" href="#timeline-body" role="button" aria-expanded="false" aria-controls="timeline-body">
      TIMELINE
    </div>
    <div class="collapse show" id="timeline-body">

      <div class="card-body bg-none">
        <label for="date-selector" class="form-label font-weight-bold">Date</label>
        <input
            type="date"
            class="form-control"
            id="date-selector"
            wire:model="currentDate"
        >
      </div>
      <div class="p-0 card-body bg-none">

        <div class="p-5 timeline-container d-relative">
          <div class="timeline-inner" id="timeline-{{ $this->id }}">
            @foreach($this->getTimelineMarkers() as $marker)
              <div class="time-marker" style="left: {{ $marker['position'] }}%">
                @if($marker['is_day_marker'] ?? false)
                <div class="time-marker-label" style="top: -45px !important; display: flex; flex-direction: column; align-items: center;">
                  <div class="font-weight-bold" style="min-width: 150px;">{{ $marker['day_label'] }}</div>
                  <div>{{ $marker['label'] }}</div>
                </div>

                @else
                  <div class="time-marker-label">{{ $marker['label'] }}</div>
                @endif
              </div>
            @endforeach

            @if($this->shouldShowNowLine())
              <div class="now-line" style="left: {{ $this->getNowPosition() }}%">
                <div class="now-label badge badge-danger">Now</div>
              </div>
            @endif
            @foreach($advertistment_schedules as $index => $item)
              @php
                $positionData = $this->getItemPositionData($item);
              @endphp
              @if($positionData['width'] > 0)
                <div
                  class="timeline-item"
                  style="
                    left: {{ $positionData['start'] }}%;
                    width: {{ $positionData['width'] }}%;
                    background-color: {{ $this->getItemColor($index) }};
                    top: {{ ($index % 5) * 40 + 10 }}px;
                  "
                  title="{{ $item->name }} ({{ $this->formatTime($item->start_datetime) }} - {{ $this->formatTime($item->end_datetime) }})"
                >
                  <div class="timeline-item-label">{{ $item->name }}</div>
                </div>
              @endif
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header font-weight-bold">
      CONTROL
    </div>
    <div class="p-0 card-body">
      <table class="table border shadow-sm table-bordered">
        <thead class="bg-white sticky-top">
          <tr>
            <th class="font-weight-bold">
              Status
            </th>
            <th class="font-weight-bold sortable" wire:click="sortBy('name')">
              Name
              <img src="{{ asset('assets/icon/arrow-updown.svg') }}" width="15" alt="sort">
            </th>
            <th class="font-weight-bold" colspan="2">Banners</th>
            <th class="font-weight-bold sortable" wire:click="sortBy('start_datetime')">Duration <img src="{{ asset('assets/icon/arrow-updown.svg') }}" width="15" alt="sort"></th>
            <th class="font-weight-bold">Active</th>
            <th class="font-weight-bold sortable" wire:click="sortBy('created_at')">Created At <img src="{{ asset('assets/icon/arrow-updown.svg') }}" width="15" alt="sort"></th>
            <th class="font-weight-bold sortable" wire:click="sortBy('updated_at')">Last Update <img src="{{ asset('assets/icon/arrow-updown.svg') }}" width="15" alt="sort"></th>
            <th class="font-weight-bold">Manage</th>
          </tr>
        </thead>
        <tbody>
          @forelse($advertistment_schedules as $schedule)
            <!-- First row for large image -->
            <tr>
              <td rowspan="2">
                @php
                  $badges = [
                    'Offline' => 'danger',
                    'Live' => 'success',
                    'default' => 'warning'
                  ];
                  $status = $schedule->status;
                  $badge = $badges[$status] ?? $badges['default'];
                @endphp
                <small class="badge badge-{{ $badge }}">{{ $status == 'Offline' || $status == 'Live' ? $status : 'In-queue' }}</small>
              </td>
              <td rowspan="2">
                {{ $schedule->name }}
              </td>
              <td>Large Size</td>
              <td>
                @if($schedule->large_image_path)
                  <img src="{{ asset('assets/avatar/' . (string) $schedule->large_image_path) }}" alt="Large banner" class="img-thumbnail" style="max-height: 60px;">
                @else
                  <span class="text-muted">No image</span>
                @endif
              </td>
              <td rowspan="2">
                {{ \Carbon\Carbon::parse($schedule->start_datetime)->format('l, M j, Y g:ia') }}<br>
                to<br>
                {{ \Carbon\Carbon::parse($schedule->end_datetime)->format('l, M j, Y g:ia') }}
              </td>
            <td rowspan="2">
              <span class="badge badge-pill {{ $schedule->is_active ? 'badge-success' : 'badge-danger' }}">
                {{ $schedule->is_active ? 'Active' : 'Inactive' }}
              </span>
            </td>
              <td rowspan="2">
                {{ \Carbon\Carbon::parse($schedule->created_at)->format('M j, Y g:ia') }}
              </td>
              <td rowspan="2">
                {{ \Carbon\Carbon::parse($schedule->updated_at)->format('M j, Y g:ia') }}
              </td>
              <td rowspan="2" class="text-center">
                <button
                  class="m-1 btn btn-primary"
                  wire:click="setSelected('{{ $schedule->id }}', 'edit')"
                >
                  <img src="{{ asset('assets/icon/pencil.svg') }}" width="20" >
                </button>
                <button
                  class="m-1 btn btn-danger"
                  wire:click="setSelected('{{ $schedule->id }}', 'delete')"
                >
                  <img src="{{ asset('assets/icon/bin.svg') }}" width="20" >
                </button>
              </td>
            </tr>

            <!-- Second row for medium image -->
            <tr>
              <td>Medium Size</td>
              <td>
                @if($schedule->medium_image_path)
                  <img src="{{ asset('assets/avatar/' . (string) $schedule->medium_image_path) }}" alt="Medium banner" class="img-thumbnail" style="max-height: 60px;">
                @else
                  <span class="text-muted">No image</span>
                @endif
              </td>
            </tr>


          @empty
            <tr>
              <td colspan="7" class="py-4 text-center">No advertisement schedules found</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>



</div>

<script>
  (function() {
    let initialized = false;
    let modalInProcess = false;
    let previewModalTimeout = null;
    let mutationObservers = [];

    function initializeScript() {
      if (initialized) return;
      initialized = true;

      window.livewire.on('deleteModal', () => {
        clearTimeout(previewModalTimeout);
        previewModalTimeout = setTimeout(() => {
          $('#ads-setup #deleteModal').modal('show');
        }, 150);
      });
      window.livewire.on('createModal', () => {
        clearTimeout(previewModalTimeout);
        previewModalTimeout = setTimeout(() => {
          $('#ads-setup #createModal').modal('show');
        }, 150);
      });
      window.livewire.on('editModal', () => {
        clearTimeout(previewModalTimeout);
        previewModalTimeout = setTimeout(() => {
          $('#ads-setup #editModal').modal('show');
        }, 150);
      });

      $(document).on('click', '#ads-setup #delete-confirmed', function() {
        window.livewire.emit('proceedDelete');
        $('#ads-setup #deleteModal').modal('hide');
      });

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
    }

    if (document.readyState === 'complete') {
      handleLivewireLoad();
    } else {
      document.addEventListener('DOMContentLoaded', handleLivewireLoad);
      window.addEventListener('load', handleLivewireLoad);
    }
    })();
</script>
