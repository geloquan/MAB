<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Specialization extends Component {
  use WithPagination;
  use WithFileUploads;
  public $hasSearched = false;
  public $sortField = 'name';
  public $sortAscending = true;
  public $searchSpecializationName = '';
  public $searchSpecializationType = 'any';
  public $searchSpecializationActive = 'any';
  public $cacheSearchSpecializationName = '';
  public $cacheSearchSpecializationType = '';
  public $cacheSearchSpecializationActive = 'any';
  public $targetSpecializationId = '';
  public $targetSpecializationName = '';
  public $targetSpecializationType = '';
  public $targetSpecializationActive = false;
  public $newSpecializationName = '';
  public $newSpecializationType = 'master';
  public $newSpecializationActive = true;
  public $showModal = true;

  protected $listeners = [
    'proceedDelete' => 'proceedDelete',
    'proceedEdit' => 'proceedEdit'
  ];
  public function sortBy(string $by) {
    if ($by !== 'name' &&
      $by !== 'type' &&
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

  public function proceedCreate() {
    $this->validate(
      [
        'newSpecializationName' => 'required|min:6'
      ], [
        'newSpecializationName.required' => 'cannot be empty.',
        'newSpecializationName.min' => 'must be at least 6 characters long.'
      ]
    );
    
    DB::statement('SELECT admin_insert_specialization(?::varchar, ?::varchar, ?::smallint)', [
      $this->newSpecializationName,
      $this->newSpecializationType,
      $this->newSpecializationActive ? 1 : 0
    ]);
    $this->reset([
      'newSpecializationName',
      'newSpecializationType',
      'newSpecializationActive'
    ]);
  }
  public function proceedEdit() {
    $this->validate(
      [
        'targetSpecializationName' => 'required|min:6'
      ], [
        'targetSpecializationName.required' => 'cannot be empty.',
        'targetSpecializationName.min' => 'must be at least 6 characters long.'
      ]
    );

    DB::select('SELECT admin_update_specialization(?::integer, ?::varchar, ?::varchar, ?::smallint)', [
      $this->targetSpecializationId,
      $this->targetSpecializationName,
      $this->targetSpecializationType,
      $this->targetSpecializationActive ? 1 : 0
    ]);
  }
  public function proceedDelete() {
    DB::select('SELECT admin_delete_specialization(?::integer)', [
      $this->targetSpecializationId,
    ]);

    $this->targetSpecializationId = 0;
  }
  public function resetSetFilters() {
    $this->hasSearched = false;
    $this->searchSpecializationName = '';
    $this->searchSpecializationType = '';
    $this->searchSpecializationActive = 'any';
  }
  public function setFilters() {
    $this->hasSearched = true;
    $this->cacheSearchSpecializationName = $this->searchSpecializationName;
    $this->cacheSearchSpecializationType = $this->searchSpecializationType;
    $this->cacheSearchSpecializationActive = $this->searchSpecializationActive;
  }
  public function resetFilters() {
    $this->reset([
      'searchSpecializationName',
      'searchSpecializationType',
      'searchSpecializationActive'
    ]);

    $this->sortAscending = true;
    $this->sortField = 'name';

    $this->setFilters();

    $this->resetPage();
  }
  protected function resetTargetSpecializationProperties() {
    $this->targetSpecializationId = 0;
    $this->targetSpecializationName = '';
    $this->targetSpecializationType = '';
    $this->targetSpecializationActive = false;
  }
  public function setSelectedSpecialization(int $id, string $mode) {
    if ($mode === 'create') {
      $this->resetTargetSpecializationProperties();
      $this->emit('createModal');
      return;
    }

    $specialization = DB::table('admin_specialization')->where('id', '=', $id)->get()->first();
    $this->targetSpecializationId = $specialization->id ?? 0;
    $this->targetSpecializationName = $specialization->name ?? '';
    $this->targetSpecializationType = $specialization->type ?? '';
    $this->targetSpecializationActive = $specialization->is_active ?? false;

    if ($mode === 'delete') {
      $this->emit('deleteModal');
    } else if ($mode === 'edit') {
      $this->emit('editModal');
    }
  }
  public function render() {
    $query = DB::table('admin_specialization');

    if ($this->hasSearched) {
      $query->when($this->cacheSearchSpecializationName, function ($query) {
        return $query->where('name', 'like', '%' . Str::upper($this->cacheSearchSpecializationName) . '%');
      });

      if ($this->cacheSearchSpecializationType === 'master'  || $this->cacheSearchSpecializationType === 'sub') {
        $query->where('type', '=', $this->cacheSearchSpecializationType);
      }

      if ($this->cacheSearchSpecializationActive === 'yes'  || $this->cacheSearchSpecializationActive === 'no') {
        $query->where('is_active', '=', ($this->cacheSearchSpecializationActive === 'yes') ? 1 : 0);
      }
    }

    $query->orderBy($this->sortField, $this->sortAscending ? 'asc' : 'desc');

    $specializations = $query->paginate(10);

    return view('livewire.admin.specialization', ['specializations' => $specializations]);
  }
}
