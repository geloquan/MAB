<?php

namespace App\Http\Livewire\Admin\Doctor;

use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class SubSpecializationEdit extends Component {
  use WithPagination;
  public $targetSelectedSubSpecializationArray = [];
  public $targetSearchSubSpecializationName;
  public function mount(
    $targetSelectedSubSpecializationArray,
    $targetSearchSubSpecializationName
  ) {
    $this->targetSelectedSubSpecializationArray = $targetSelectedSubSpecializationArray;
    $this->targetSearchSubSpecializationName = $targetSearchSubSpecializationName;
  }
  public function render() {
    $sub_specializations = DB::table('sub_specialization_view')->orderBy('name', 'asc');
    if ($this->targetSearchSubSpecializationName) {
      $sub_specializations->where('name', 'like', '%' . Str::upper($this->targetSearchSubSpecializationName) . '%');
    }

    $subSpecializations = $sub_specializations->paginate(5);

    return view('livewire.admin.doctor.sub-specialization-edit', ['subSpecializations' => $subSpecializations]);
  }

}
