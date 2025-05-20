<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
class AdminHome extends Component {
  public $selected_tab = '';

  public $collapseState = 'show';

  protected $listeners = [
    'logout'
  ];
  public function mount() {
    $this->selected_tab = request()->query('tab', '');
  }
  public function toggle_state() {
    if ($this->collapseState == '') {
      $this->collapseState = 'show';
    } else {
      $this->collapseState = '';
    }
  }
  public function new_tab($selected) {
    if ($this->selected_tab === $selected) {
      $this->selected_tab = '';
    } else {
      $this->selected_tab = $selected;
    }
    $this->emit('update-url', [
      'url' => route('admin.dashboard', ['tab' => $this->selected_tab ?: null])
    ]);
  }
  public function logout() {
    Auth::logout();
    return redirect()->to('/login');
  }
  public function render() {
    return view('livewire.admin-home', ['selected_tab ' => $this->selected_tab]);
  }
}
