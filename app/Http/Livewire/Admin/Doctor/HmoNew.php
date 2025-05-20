<?php

namespace App\Http\Livewire\Admin\Doctor;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HmoNew extends Component {
  use WithPagination;
  public $newSelectedHMOArray = [];
  public $newSearchHMOName;
  public function mount(
    $newSearchHMOName,
    $newSelectedHMOArray
  ) {
    $this->newSearchHMOName = $newSearchHMOName;
    $this->newSelectedHMOArray = $newSelectedHMOArray;
  }
  public function render() {
    $query = DB::table('hmo_view')->orderBy('name', 'asc');

    if ($this->newSearchHMOName) {
      $query->where('name', 'like', '%' . Str::upper($this->newSearchHMOName) . '%');
    }

    $hmosTable = $query->paginate(5);

    return view('livewire.admin.doctor.hmo-new', ['hmos' => $hmosTable]);
  }
}
