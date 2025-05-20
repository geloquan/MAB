<?php

namespace App\Http\Livewire\Admin\Doctor;

use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class HmoEdit extends Component {
  use WithPagination;
  public $targetSelectedHMOArray = [];
  public $targetSearchHMOName;
  public function mount(
    $targetSearchHMOName,
    $targetSelectedHMOArray
  ) {
    $this->targetSearchHMOName = $targetSearchHMOName;
    $this->targetSelectedHMOArray = $targetSelectedHMOArray;
  }
  public function render() {
    $query = DB::table('hmo_view')->orderBy('name', 'asc');

    if ($this->targetSearchHMOName) {
      $query->where('name', 'like', '%' . Str::upper($this->targetSearchHMOName) . '%');
    }

    $hmosTable = $query->paginate(5);

    return view('livewire.admin.doctor.hmo-edit', ['hmos' => $hmosTable]);
  }
}
