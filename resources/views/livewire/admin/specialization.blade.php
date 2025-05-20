<div class="mb-3" id="specialization">
  <div id="deleteSpecializationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteSpecializationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-light">
          <h5 class="modal-title"><b>Deleting Specialization Record</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>
            Are you sure to delete <b><u>{{ $targetSpecializationName }}</u></b>?
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          <button id="delete-confirmed" type="button" class="btn btn-primary">Yes</button>
        </div>
      </div>
    </div>
  </div>

  <div id="editSpecializationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editSpecializationModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-light">
          <h5 class="modal-title"><b>Editing Specialization Record</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit.prevent="proceedEdit">
          <div class="modal-body">
              <div class="container">
                <div class="mb-3 row">
                  <div class="col">
                    <label for="edit-name">Name</label>
                    <input id="edit-name" type="text" class="form-control" wire:model.defer="targetSpecializationName">

                    @error('targetSpecializationName')
                      <div
                        class="alert alert-warning"
                      >
                        {{ $message }}
                      </div>
                    @enderror
                  </div>

                  <div class="form-row">
                    <div class="col form-group">
                      <label class="mb-1 form-check-label d-block">Type</label>
                      <div class="ml-2 form-check">
                        <div class="form-check form-check-inline">
                          <input id="specialization-type-master" class="form-check-input" type="radio" name="edit-type" wire:model="targetSpecializationType" value="master">
                          <label class="form-check-label" for="specializationMaster">Master</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input id="specialization-type-sub" class="form-check-input" type="radio" name="edit-type" wire:model="targetSpecializationType" value="sub">
                          <label class="form-check-label" for="specializationSub">Sub</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-2">
                    <div class="form-check">
                      <br>
                      <input id="edit-active" type="checkbox" class="form-check-input" wire:model.defer="targetSpecializationActive">
                      <label for="edit-active">Active</label>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button id="" type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div id="createSpecializationModal" class="z-0 modal fade" tabindex="-1" role="dialog" aria-labelledby="createSpecializationModalTitle" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-light">
          <h5 class="modal-title"><b x-data="{ text: 'Adding Specialization Record' }" x-text="text"></b></h5>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="notification" class="notification" style="display: none;"></div>
        <form wire:submit.prevent="proceedCreate">
          <div class="modal-body">
              <div class="container">
                <div class="mb-3 row">
                  <div class="col">
                    <label for="create-name">Name</label>
                    <input id="create-name" type="text" class="form-control" wire:model.defer="newSpecializationName">
                    @error('newSpecializationName')
                      <div class="alert alert-warning">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="form-row">
                    <div class="col form-group">
                      <label class="mb-1 form-check-label d-block">Type</label>
                      <div class="ml-2 form-check">
                        <div class="form-check form-check-inline">
                          <input id="specialization-type-master" class="form-check-input" type="radio" name="newSpecializationType" wire:model="newSpecializationType" value="master">
                          <label class="form-check-label" for="specializationMaster">Master</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input id="specialization-type-sub" class="form-check-input" type="radio" name="newSpecializationType" wire:model="newSpecializationType" value="sub">
                          <label class="form-check-label" for="specializationSub">Sub</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-2">
                    <div class="form-check">
                      <br>
                      <input id="create-active" type="checkbox" class="form-check-input" wire:model.defer="newSpecializationActive">
                      <label for="create-active">Active</label>
                    </div>
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
  <div class="my-1 btn-group btn-group-toggle" data-toggle="buttons">
    <div class="btn-group" role="group" aria-label="Basic example">
      <button
        type="button"
        class="btn btn-primary text-light"
        wire:click="setSelectedSpecialization('0', 'create')"
      >
        <img src="{{ asset('assets/icon/specialization.svg') }}" width="20" alt="">
        ADD SPECIALIZATION
      </button>
    </div>
  </div>

  <div class="mb-3 input-group">
    <input type="text" class="form-control" placeholder="Search HMO Name of...  " aria-label="Search" wire:model="searchSpecializationName">
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

        <div class="mt-2 row">
          <div class="mb-2 col-4">
            <div class="form-group">
              <label class="mb-1 form-check-label d-block">Type</label>
              <div class="ml-2 form-check">
                <div class="form-check form-check-inline">
                  <input id="typeAny" class="form-check-input" type="radio" name="searchSpecializationType" wire:model="searchSpecializationType" value="any">
                  <label class="form-check-label" for="typeAny">Any</label>
                </div>
                <div class="form-check form-check-inline">
                  <input id="typeMaster" class="form-check-input" type="radio" name="searchSpecializationType" wire:model="searchSpecializationType" value="master">
                  <label class="form-check-label" for="typeMaster">Master</label>
                </div>
                <div class="form-check form-check-inline">
                  <input id="typeSub" class="form-check-input" type="radio" name="searchSpecializationType" wire:model="searchSpecializationType" value="sub">
                  <label class="form-check-label" for="typeSub">Sub</label>
                </div>
              </div>
            </div>
          </div>
          <div class="mb-2 col-4">
            <div class="form-group">
              <label class="mb-1 form-check-label d-block">Active Only</label>
              <div class="ml-2 form-check">
                <div class="form-check form-check-inline">
                  <input id="activeAny" class="form-check-input" type="radio" name="searchSpecializationActive" wire:model="searchSpecializationActive" value="any">
                  <label class="form-check-label" for="activeAny">Any</label>
                </div>
                <div class="form-check form-check-inline">
                  <input id="activeYes" class="form-check-input" type="radio" name="searchSpecializationActive" wire:model="searchSpecializationActive" value="yes">
                  <label class="form-check-label" for="activeYes">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                  <input id="activeNo" class="form-check-input" type="radio" name="searchSpecializationActive" wire:model="searchSpecializationActive" value="no">
                  <label class="form-check-label" for="activeNo">No</label>
                </div>
              </div>
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
        {{ $specializations->links() }}
      </div>
      <table class="table border shadow-sm table-bordered">
        <thead class="bg-white sticky-top">
          <tr>
            <th class="font-weight-bold sortable" wire:click="sortBy('name')">Name <img src="{{ asset('assets/icon/arrow-updown.svg') }}" width="15" alt="sort"></th>
            <th class="font-weight-bold sortable" wire:click="sortBy('type')">Type <img src="{{ asset('assets/icon/arrow-updown.svg') }}" width="15" alt="sort"></th>
            <th class="font-weight-bold">Status</th>
            <th class="font-weight-bold sortable" wire:click="sortBy('created_at')">Created At <img src="{{ asset('assets/icon/arrow-updown.svg') }}" width="15" alt="sort"></th>
            <th class="font-weight-bold sortable" wire:click="sortBy('updated_at')">Last Update <img src="{{ asset('assets/icon/arrow-updown.svg') }}" width="15" alt="sort"></th>
            <th class="font-weight-bold">Manage</th>
          </tr>
        </thead>
        <tbody>
          @forelse($specializations as $specialization)
            <tr>
              <td class="{{ $specialization->type === "sub" ? 'pl-4' : 'font-weight-bold' }}">{{ ucfirst($specialization->name) }}</td>
              <td>
                <span class="badge badge-pill {{ $specialization->type === 'master' ? 'badge-warning' : 'badge-secondary text-dark' }}">
                  {{ ucfirst($specialization->type) }}
                </span>
              </td>
              <td>
                <span class="badge badge-pill {{ $specialization->is_active ? 'badge-success' : 'badge-danger' }}">
                  {{ $specialization->is_active ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td>{{ \Carbon\Carbon::parse($specialization->created_at, 'Asia/Singapore')->diffForHumans() }}</td>
              <td>{{ \Carbon\Carbon::parse($specialization->updated_at, 'Asia/Singapore')->diffForHumans() }}</td>
              <td>
                <button
                class="btn btn-primary"
                wire:click="setSelectedSpecialization('{{ $specialization->id }}', 'edit')"
                >
                  <img src="{{ asset('assets/icon/pencil.svg') }}" width="20" >
                </button>
                <button
                class="btn btn-primary"
                wire:click="setSelectedSpecialization('{{ $specialization->id }}', 'delete')"
                >
                  <img src="{{ asset('assets/icon/bin.svg') }}" width="20" >
                </button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="13" class="text-center">No records found.</td>
            </tr>
          @endforelse
          @if  ($specializations->currentPage() === $specializations->lastPage())
            <tr>
              <td colspan="13" class="text-center"><b><u>end of results</u></b></td>
            </tr>
          @endif
        </tbody>
      </table>
      <div class="p-0 m-0 d-flex justify-content-center" wire:model="">
        {{ $specializations->links() }}
      </div>
    </div>
  </div>
</div>


<script>
  (function() {
    let initialized = false;
    let modalInProcess = false;
    let previewModalTimeout = null;

    function initializeSpecializationscript() {
      if (initialized) return;
      initialized = true;



      window.livewire.on('deleteModal', () => {
        clearTimeout(previewModalTimeout);
        previewModalTimeout = setTimeout(() => {
          $('#specialization #deleteSpecializationModal').modal('show');
        }, 150);
      });

      window.livewire.on('editModal', () => {
        clearTimeout(previewModalTimeout);
        previewModalTimeout = setTimeout(() => {
          $('#specialization #editSpecializationModal').modal('show');
        }, 150);
      });

      window.livewire.on('createModal', () => {
        clearTimeout(previewModalTimeout);
        previewModalTimeout = setTimeout(() => {
          $('#specialization #createSpecializationModal').modal('show');
        }, 150);
      });

      $(document).on('click', '#specialization #edit-cancel', function() {
        window.livewire.emit('cancelEdit');
      });

      $(document).on('click', '#toggle-filter-options', function() {
        $('#filter-options').collapse('toggle');
      });

      $(document).on('click', '#specialization #delete-confirmed', function() {
        window.livewire.emit('proceedDelete');
        $('#specialization #deleteSpecializationModal').modal('hide');
      });

      $(document).on('click', '#specialization #edit-confirmed', function() {
        const data = {
          name: $('#specialization #edit-name').val(),
          type: $('input[name="edit-type"]:checked').val(),
          active: $('#specialization #edit-active').prop('checked')
        };
        console.log(data);
        window.livewire.emit('proceedEdit', data);
        $('#specialization #editSpecializationModal').modal('hide');
      });

      $(document).on('click', '#specialization #create-confirmed', function() {
        const data = {
          name: $('#specialization #create-name').val(),
          type: $('input[name="newSpecializationType"]:checked').val(),
          active: $('#specialization #create-active').prop('checked')
        };
        console.log(data);
        window.livewire.emit('proceedCreate', data);
        $('#specialization #createSpecializationModal').modal('hide');
      });

    }

    function handleLivewireLoad() {
      if (window.livewire) {
        initializeSpecializationscript();
      }

      document.addEventListener('livewire:load', function() {
        window.livewire.on('showSuccessAlert', (message) => {
          alert(message); // Basic alert
          Toastr.success(message);
        });
        initializeSpecializationscript();
      });

      document.addEventListener('livewire:update', function() {
        if (!initialized && window.Livewire) {
          initializeSpecializationscript();
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
