<div class="mb-3" id="hmo">
  <div id="deleteHMOModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteHMOModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><b>Deleting HMO Record</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>
            Are you sure to delete <b><u>{{ $targetHMOName }}</u></b>?
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          <button id="delete-confirmed" type="button" class="btn btn-primary">Yes</button>
        </div>
      </div>
    </div>
  </div>
  <div id="editHMOModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editHMOModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><b>Editing HMO Record</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit.prevent="proceedEdit">
          <div class="modal-body">
              <div class="container">
                <div class="mb-3 row">
                  <div class="col">
                    <label for="">Name</label>
                    <input id="edit-name" type="text" class="form-control" wire:model.defer="targetHMOName">
                    @error('targetHMOName') <div class="alert alert-warning">{{ $message }}</div> @enderror
                  </div>
                </div>
                <div class="mb-3 row">
                  <div class="col-2">
                    <div class="form-check">
                      <br>
                      <input id="edit-active" type="checkbox" class="form-check-input" wire:model.defer="targetActive">
                      <label for="">Active</label>
                    </div>
                  </div>
                </div>
                <div class="mb-3 row">
                  <div class="col">
                    <label for="">Description</label>
                    <textarea id="edit-description" class="form-control" rows="5" wire:model.defer="targetDescription"></textarea>
                    @error('targetDescription') <div class="alert alert-warning">{{ $message }}</div> @enderror
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button id="" type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div id="createHMOModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createHMOModalTitle" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><b>Adding HMO Record</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit.prevent="proceedCreate">
          <div class="modal-body">
              <div class="container">
                <div class="mb-3 row">
                  <div class="col">
                    <label for="">Name</label>
                    <input id="create-name" type="text" class="form-control" wire:model.defer="newHMOName" value="{{ $newHMOName }}">
                    @error('newHMOName') <div class="alert alert-warning">{{ $message }}</div> @enderror
                  </div>
                  <div class="col-2">
                    <div class="form-check">
                      <br>
                      <input id="create-active" type="checkbox" class="form-check-input" wire:model.defer="newActive" value="{{ $newActive }}" @if($newActive) checked @endif>
                      <label for="">Active</label>
                    </div>
                  </div>
                </div>
                <div class="mb-3 row">
                  <div class="col">
                    <label for="">Description</label>
                    <textarea id="create-description" class="form-control" rows="5" wire:model.defer="newHMODescription" value="{{ $newHMODescription }}"></textarea>
                    @error('newHMODescription') <div class="alert alert-warning">{{ $message }}</div> @enderror
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
            <button type="submit" class="btn btn-primary" id="">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!--

  NOT MODAL START

  -->
  <div class="my-1 btn-group btn-group-toggle" role="group">
    <div class="btn-group" role="group" aria-label="">
      <button
        type="button"
        class="btn btn-primary rounded-0 text-light"
        wire:click="setSelectedHmo('0', 'create')"
      >
        <img src="{{ asset('assets/icon/hmo.svg') }}" width="20" alt="">
        ADD HMO
      </button>
    </div>
  </div>
  <div class="mb-3 input-group">
    <input type="text" class="form-control" placeholder="Search HMO of...  " aria-label="Search" wire:model="searchName">
    <button class="btn btn-primary" type="button" wire:click="setFilters">
      <i class="bi bi-search"></i> Search
    </button>
    <button class="btn btn-outline-secondary text-dark" type="button" id="toggle-filter-options">
      <img src="{{ asset('assets/icon/funnel.svg') }}" width="30" alt="">
      Filters
    </button>
  </div>

  <div class="m-1 my-3 mt-0 border rounded shadow-sm collapse search-options" id="filter-options" wire:ignore.self>
    <form id="doctor-search-form" action="" class="" wire:submit.prevent="setFilters">
      <div class="p-3 option-section border-bottom">
        <div class="form-group">
          <label class="mb-1 form-check-label d-block fw-bold">Active Only</label>
          <div class="form-check">
            <div class="form-check form-check-inline">
              <input id="activeAny" class="form-check-input" type="radio" name="searchActiveOnly" wire:model="searchActiveOnly" value="any">
              <label class="form-check-label" for="activeAny">Any</label>
            </div>
            <div class="form-check form-check-inline">
              <input id="activeYes" class="form-check-input" type="radio" name="searchActiveOnly" wire:model="searchActiveOnly" value="yes">
              <label class="form-check-label" for="activeYes">Yes</label>
            </div>
            <div class="form-check form-check-inline">
              <input id="activeNo" class="form-check-input" type="radio" name="searchActiveOnly" wire:model="searchActiveOnly" value="no">
              <label class="form-check-label" for="activeNo">No</label>
            </div>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="p-3 d-flex justify-content-end border-top">
        <button type="button" class="btn btn-sm btn-outline-secondary me-2 text-dark" wire:click="resetFilters">
          <i class="bi bi-arrow-counterclockwise"></i> CLEAR
        </button>
        <button type="submit" class="btn btn-sm btn-primary" wire:click="setFilters">
          <i class="bi bi-search"></i> APPLY FILTERS
        </button>
      </div>
    </form>
  </div>

  <div class="m-1 shadow-lg card">
    <div class="text-white card-header bg-dark">
      SEARCH RESULTS
    </div>
    <div class="card-body table-responsive-lg" style="">
      <div class="p-0 m-0 d-flex justify-content-center" wire:model="">
        {{ $HMOs->links() }}
      </div>
      <table class="table border shadow-sm table-bordered">
        <thead class="bg-white sticky-top">
          <tr>
            <th class="font-weight-bold sortable" wire:click="sortBy('name')">Name <img src="{{ asset('assets/icon/arrow-updown.svg') }}" width="15" alt="sort"></th>
            <th class="font-weight-bold">Description Name</th>
            <th class="font-weight-bold">Active</th>
            <th class="font-weight-bold sortable" wire:click="sortBy('created_at')">Created At <img src="{{ asset('assets/icon/arrow-updown.svg') }}" width="15" alt="sort"></th>
            <th class="font-weight-bold sortable" wire:click="sortBy('updated_at')">Last Update <img src="{{ asset('assets/icon/arrow-updown.svg') }}" width="15" alt="sort"></th>
            <th class="font-weight-bold">Manage</th>
          </tr>
        </thead>
        <tbody>
          @forelse($HMOs as $HMO)
          <tr>
            <td>{{ $HMO->name }}</td>
            <td>{{ $HMO->description }}</td>
            <td>
              <span class="badge badge-pill {{ $HMO->is_active ? 'badge-success' : 'badge-danger' }}">
                {{ $HMO->is_active ? 'Active' : 'Inactive' }}
              </span>
            </td>
            <td>{{ \Carbon\Carbon::parse($HMO->created_at, 'Asia/Singapore')->setTimezone('Asia/Shanghai')->diffForHumans() }}</td>
            <td>{{ \Carbon\Carbon::parse($HMO->updated_at, 'Asia/Singapore')->setTimezone('Asia/Shanghai')->diffForHumans() }}</td>
            <td>
              <button
              class="btn btn-primary"
              wire:click="setSelectedHmo('{{ $HMO->id }}', 'edit')"
              >
                <img src="{{ asset('assets/icon/pencil.svg') }}" width="20" >
              </button>
              <button
              class="btn btn-primary"
              wire:click="setSelectedHmo('{{ $HMO->id }}', 'delete')"
              >
                <img src="{{ asset('assets/icon/bin.svg') }}" width="20" >
              </button>
            </td>
          @empty
          <tr>
            <td colspan="6" class="text-center">No records found.</td>
          </tr>
          @if  ($HMOs->currentPage() === $HMOs->lastPage())
            <tr>
              <td colspan="6" class="text-center"><b><u>end of results</u></b></td>
            </tr>
          @endif
          @endforelse
        </tbody>
      </table>
      <div class="p-0 m-0 d-flex justify-content-center" wire:model="">
        {{ $HMOs->links() }}
      </div>
    </div>
  </div>
</div>

<script>
  (function() {
    let initialized = false;
    let modalInProcess = false;
    let previewModalTimeout = null;

    function initializeHMOscript() {
      if (initialized) return;
      initialized = true;

      window.livewire.on('deleteModal', () => {
        clearTimeout(previewModalTimeout);
        previewModalTimeout = setTimeout(() => {
          $('#hmo #deleteHMOModal').modal('show');
        }, 150);
      });

      window.livewire.on('editModal', () => {
        clearTimeout(previewModalTimeout);
        previewModalTimeout = setTimeout(() => {
          $('#hmo #editHMOModal').modal('show');
        }, 150);
      });

      window.livewire.on('createModal', () => {
        clearTimeout(previewModalTimeout);
        previewModalTimeout = setTimeout(() => {
          $('#hmo #createHMOModal').modal('show');
        }, 150);
      });

      $(document).on('click', '#hmo #delete-confirmed', function() {
        window.livewire.emit('proceedDelete');
        $('#hmo #deleteHMOModal').modal('hide');
      });
      $(document).on('click', '#toggle-filter-options', function() {
        $('#filter-options').collapse('toggle');
      });


      $(document).on('click', '#hmo #edit-confirmed', function() {
        window.livewire.emit('proceedEdit', {
          name: $('#hmo #edit-name').val(),
          description: $('#hmo #edit-description').val(),
          active: $('#hmo #edit-active').prop('checked')
        });
        $('#hmo #editHMOModal').modal('hide');
      });

      $(document).on('click', '#hmo #create-confirmed', function() {
        window.livewire.emit('proceedCreate', {
          name: $('#hmo #create-name').val(),
          description: $('#hmo #create-description').val(),
          active: $('#hmo #create-active').prop('checked')
        });
        $('#hmo #createHMOModal').modal('hide');
      });
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
