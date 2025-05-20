<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Hmo extends Component {
  use WithPagination;
  use WithFileUploads;
  public $sortAscending = true;
  public $sortField = 'name';
  public $hasSearched = false;
  public $searchName = '';
  public $searchActiveOnly = 'any';
  public $cacheSearchName = '';
  public $cacheSearchActiveOnly = 'any';
  public $targetHMOId = 0;
  public $targetHMOName = '';
  public $targetDescription = '';
  public $newHMOName = '';
  public $newHMODescription = '';
  public $newActive = true;
  public $targetActive = false;
  public $file;
  public $uploadedFile = false;
  protected $listeners = [
    'proceedDelete' => 'proceedDelete',
    'proceedEdit' => 'proceedEdit',
    'proceedCreate' => 'proceedCreate',
  ];
  public function proceedCreate() {
    $this->validate(
      [
        'newHMOName' => 'required|min:6',
        'newHMODescription' => 'required|min:6'
      ], [
        'newHMOName.required' => 'cannot be empty.',
        'newHMOName.min' => 'must be at least 6 characters long.',
        'newHMODescription.required' => 'cannot be empty.',
        'newHMODescription.min' => 'must be at least 6 characters long.'
      ]
    );
    DB::statement('SELECT admin_insert_hmo(?::varchar, ?::varchar, ?::smallint)', [
      $this->newHMOName,
      $this->newHMODescription,
      $this->newActive ? 1 : 0
    ]);

    $this->newHMOName = '';
    $this->newHMODescription = '';
    $this->newActive = true;
  }
  public function proceedEdit() {
    $this->validate(
      [
        'targetHMOName' => 'required|min:6',
        'targetDescription' => 'required|min:6'
      ], [
        'targetHMOName.required' => 'cannot be empty.',
        'targetHMOName.min' => 'must be at least 6 characters long.',
        'targetDescription.required' => 'cannot be empty.',
        'targetDescription.min' => 'must be at least 6 characters long.'
      ]
    );

    DB::select('SELECT admin_update_hmo(?::integer, ?::varchar, ?::varchar, ?::smallint)', [
      $this->targetHMOId,
      $this->targetHMOName,
      $this->targetDescription,
      $this->targetActive
    ]);
  }
  public function proceedDelete() {
    DB::select('SELECT admin_delete_hmo(?::integer)', [
      $this->targetHMOId,
    ]);

    $this->targetHMOId = 0;
  }

  public function updatedFile() {
    $this->uploadedFile = true;
  }
  public function resetSetFilters() {
    $this->hasSearched = false;
    $this->searchName = '';
    $this->searchActiveOnly = 'any';
  }
  public function setFilters() {
    $this->hasSearched = true;
    $this->cacheSearchName = $this->searchName;
    $this->cacheSearchActiveOnly = $this->searchActiveOnly;
  }
  public function resetFilters() {
    $this->reset([
      'searchName',
      'searchActiveOnly'
    ]);

    $this->setFilters();

    $this->resetPage();
  }
  public function sortBy(string $by) {
    if ($by !== 'name' &&
      $by !== 'created_at' &&
      $by !== 'updated_at'
    ) {
      return;
    }

    if ($by === $this->sortField) {
      $this->sortAscending = !$this->sortAscending;
    } else {
      $this->sortField = $by;
      $this->sortAscending = true;
    }
  }
  public function setSelectedHmo(int $id, string $mode) {
    if ($mode === 'create') {
      $this->emit('createModal');
      return;
    }

    $HMO = DB::table('admin_hmo')->where('id', '=', $id)->get()->first();
    $this->targetHMOId = $HMO->id ?? 0;
    $this->targetHMOName = $HMO->name ?? '';
    $this->targetDescription = $HMO->description ?? '';
    $this->targetActive = $HMO->is_active ?? false;

    if ($mode === 'delete') {
      $this->emit('deleteModal');
    } else if ($mode === 'edit') {
      $this->emit('editModal');
    }
  }
  public function render() {
    $query = DB::table('admin_hmo');

    if ($this->hasSearched) {
      $query->when($this->cacheSearchName, function ($query) {
        return $query->where('name', 'like', '%' . Str::upper($this->cacheSearchName) . '%');
      });

      if ($this->cacheSearchActiveOnly === 'yes'  || $this->cacheSearchActiveOnly === 'no') {
        $query->where('is_active', '=', ($this->cacheSearchActiveOnly === 'yes') ? 1 : 0);
      }
    }

    $query->orderBy($this->sortField, $this->sortAscending ? 'asc' : 'desc');

    $HMOs = $query->paginate(10);

    return view('livewire.admin.hmo', ['HMOs' => $HMOs]);
  }
}
