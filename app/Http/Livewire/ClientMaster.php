<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ClientMaster extends Component {
  public $selected_tab = '';
  public $ads = [];
  public function mount() {
    $this->selected_tab = request()->query('tab', '');
  }
  public function navbar() {
    if ($this->selected_tab == 'directory') {
      return;
    } else {

    }

  }
  public function new_tab($selected) {
    if ($this->selected_tab === $selected) {
      $this->selected_tab = '';
    } else {
      $this->selected_tab = $selected;
    }
  }
  public function render() {
    $this->ads = DB::table('public_advertisement_schedule')->get()->toArray();
    return view('livewire.client-master', ['selected_tab ' => $this->selected_tab]);
  }
}
