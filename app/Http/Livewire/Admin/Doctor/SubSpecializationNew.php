<?php

namespace App\Http\Livewire\Admin\Doctor;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubSpecializationNew extends Component {
  use WithPagination;
  public $newSelectedSubSpecializationArray = [];
  public $newSearchSubSpecializationName = '';
  public function mount(
    $newSelectedSubSpecializationArray,
    $newSearchSubSpecializationName
  ) {
    $this->newSelectedSubSpecializationArray = $newSelectedSubSpecializationArray;
    $this->newSearchSubSpecializationName = $newSearchSubSpecializationName;
  }
  public function render() {
    $sub_specializations = DB::table('sub_specialization_view')->orderBy('name', 'asc');
    if ($this->newSearchSubSpecializationName) {
      $sub_specializations->where('name', 'like', '%' . Str::upper($this->newSearchSubSpecializationName) . '%');
    }

    $subSpecializations = $sub_specializations->paginate(5);

    return view('livewire.admin.doctor.sub-specialization-new', ['subSpecializations' => $subSpecializations]);
  }

}
