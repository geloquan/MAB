<?php

namespace App\Http\Livewire;

use App\Doctor;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DoctorOverlayPanel extends Component {

  public $isVisible = false;
  public $selectedDoctor = null;

  public $specializations = [];
  public $usedSpecializations = [];
  public $unusedSpecialization = [];

  public $doctorFirstName = '';
  public $doctorLastName = '';
  protected $listeners = ['openOverlay' => 'openPanel'];

  public function toUsed($id) {
    $toAdd = null;

    foreach ($this->unusedSpecialization as $item) {
      if ($item['id'] == $id) {
        $toAdd = $item;
        break;
      }
    }

    if ($toAdd !== null) {
      $this->unusedSpecialization = array_filter($this->unusedSpecialization, function ($item) use ($id) {
        return $item['id'] != $id;
      });

      $this->usedSpecializations[] = $toAdd;
    }
  }

  public function toUnused($id) {

  }
  public function openPanel($item){
    $specialization = DB::table('specialization')
    ->select('name', 'id')
    ->orderBy('name', 'asc')
    ->get()
    ->toArray();

    $doctor = DB::table('doctor_view')
    ->where('doctor_id', '=', $item)
    ->first();

    $doctor_specialization = json_decode($doctor->specializations, true);
    $this->usedSpecializations = $doctor_specialization;

    $this->specializations = $specialization;

    $specializations = collect($this->specializations);
    $usedSpecializations = collect($this->usedSpecializations);

    $this->unusedSpecialization = $specializations->whereNotIn('id', $usedSpecializations->pluck('id')->toArray())->values()->toArray();
    $this->doctorFirstName = $doctor->first_name ?: 'N/A';
    $this->doctorLastName = $doctor->last_name ?: 'N/A';
    $this->selectedDoctor = $item;
    $this->isVisible = true;

  }

  public function closePanel() {
    $this->isVisible = false;
    $this->selectedDoctor = null;
  }

  public function render() {
    return view('livewire.doctor-overlay-panel');
  }
}
