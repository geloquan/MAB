<div class="col">
  <div class="row m-0 p-0 mb-3 text-light-bg">
    <div class="col-10 h6 p-3 font-weight-bold m-0">
      SEARCH RESULTS
    </div>
  </div>
  <div class="table-responsive-sm ">
    <table class="table table-hover">
      <thead class="">
        <tr>
          <th width="40">
          </th>
          <th>Name</th>
        </tr>
      </thead>
      <tbody>
        @foreach($subSpecializations as $subSpecialization)
          <tr class="record-item p-3"
          wire:click="$emit('targetSelectedSubSpecializationArrayUpdated', {{ $subSpecialization->id }})">
            <td>
              <div class="form-check m-0">
                <input
                  type="checkbox"
                  {{ in_array($subSpecialization->id, $targetSelectedSubSpecializationArray) ? 'checked' : '' }}
                  value="{{ $subSpecialization->id }}"
                  id="{{ $subSpecialization->id }}"
                >
              </div>
            </td>
            <td>
              <label for="subSpecialization-{{ $subSpecialization->id }}">{{ $subSpecialization->name }}</label>
            </td>
          </tr>
        @endforeach
        @if($subSpecializations->currentPage() === $subSpecializations->lastPage())
          <tr>
            <td colspan="2" class="text-center"><b><u>end of results</u></b></td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>
</div>
