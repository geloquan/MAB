<?php

namespace App\Http\Livewire;

use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class ClientHome extends Component {
  use WithPagination;
  public $searchCollapsed = true;
  public $formState = '';
  public $searchLastName = '';
  public $searchHmoNameSelect = '';
  public $searchSpecializationNameSelect = '';
  public $searchSubSpecializationNameSelect = '';
  public $searchDayOfWeekSelect = '';
  public $searchTimeSelect = 'anytime';
  public $searchActiveOnly = false;

  public $cacheSearchLastName = '';
  public $cacheSearchHmoNameSelect = '';
  public $cacheSearchSpecializationNameSelect = '';
  public $cacheSearchSubSpecializationNameSelect = '';
  public $cacheSearchDayOfWeekSelect = '';
  public $cacheSearchTimeSelect = '';
public $cacheSearchActiveOnly = false;

  public $hmos = [];
  public $sub_specializations = [];
  public $master_specializations = [];

  public $selectedDoctor = null;

  public $selectedDoctorId = null;
  public $filtered_doctors = [];
  public $busy_day_of_week = [];
  protected $listeners = [
    'searchCollapseToggle',
    'closeSearch'
  ];

  public function closeSearch() {
    $this->searchCollapsed = true;
  }

  public function searchCollapseToggle() {
    $this->searchCollapsed = !$this->searchCollapsed;
  }

  public function setSelectedId(int $id): void{
    $this->selectedDoctor = null;
    $this->selectedDoctorId = $id;

    $this->emit('previewModal');
  }

  protected $queryString = [
    'page' // Add page to query string
  ];

  public function mount() {
    $this->fill(request()->only(
      'page'
    ));
  }

  public function updateUrl() {
    $queryParams = array_filter([
      'page' => $this->page
    ]);

    $newUrl = route('client') . '?' . http_build_query($queryParams);
    $this->emit('urlUpdated', ['newUrl' => $newUrl]);
  }

  /**
   * Filter doctor resources based on time selection and day of week
   *
   * @param string $searchTimeSelect ENUM("anytime", "am", "pm")
   * @param string $dayOfWeek ENUM(monday to sunday)
   * @param array $doctor_resources Array of doctor resource objects
   *
   * @return array
   */
  public function filterSchedule(string $searchTimeSelect, string $dayOfWeek, array $doctor_resources) {
    $schedule = array_filter($doctor_resources, function($doctor) use ($searchTimeSelect) {
      if ($searchTimeSelect === 'anytime' || $searchTimeSelect === '') {
        return true;
      }
      $schedules = json_decode($doctor->schedule);
      foreach ($schedules as $schedule) {
          $start_time = new DateTime($schedule->start_time);
          $end_time = new DateTime($schedule->end_time);

          $start_hour = (int) $start_time->format('H');
          $end_hour = (int) $end_time->format('H');

          if (($searchTimeSelect === 'am') && $start_hour < 12) {
              return true;
          } elseif ($searchTimeSelect === 'pm' && $end_hour >= 12) {
              return true;
          }
      }
      return false;
    });
    return $schedule;
  }

  public function formatSubSpecialization($specialization): string {
    $trimmed = trim($specialization, '{}');
    $array = [];
    $current = '';
    $inQuotes = false;

    for ($i = 0; $i < strlen($trimmed); $i++) {
      $char = $trimmed[$i];

      if ($char === '"') {
        $inQuotes = !$inQuotes;
      } elseif ($char === ',' && !$inQuotes) {
        $array[] = trim($current);
        $current = '';
      } else {
        $current .= $char;
      }
    }

    if (!empty($current)) {
      $array[] = trim($current);
    }

    $array = array_map(function($item) {
      return trim($item, '"');
    }, $array);

    return implode(', ', $array);
  }
  public function formatDaysOfWeek($day_of_week): string {
    $day_aliases = [
        'monday'    => 'Mo',
        'tuesday'   => 'Tu',
        'wednesday' => 'We',
        'thursday'  => 'Th',
        'friday'    => 'Fr',
        'saturday'  => 'Sa',
        'sunday'    => 'Su',
    ];

    $days_array = explode(',', trim($day_of_week, '{}'));

    $days_with_aliases = array_map(function($day) use ($day_aliases) {
        $alias = isset($day_aliases[$day]) ? $day_aliases[$day] : $day;
        if ($alias == 'Sa' || $alias == 'Su') {
            return '<span style="color: rgb(255, 101, 84);">' . $alias . '</span>';
        }
        return $alias;
    }, $days_array);

    $days = implode(', ', $days_with_aliases);

    return $days;
  }


  public $hasSearched = false;

  public function search() {
    $this->hasSearched = true;
    $this->cacheSearchLastName = $this->searchLastName;
    $this->cacheSearchSubSpecializationNameSelect = $this->searchSubSpecializationNameSelect;
    $this->cacheSearchSpecializationNameSelect = $this->searchSpecializationNameSelect;
    $this->cacheSearchHmoNameSelect = $this->searchHmoNameSelect;
    $this->cacheSearchDayOfWeekSelect = $this->searchDayOfWeekSelect;
    $this->cacheSearchTimeSelect = $this->searchTimeSelect;
    $this->cacheSearchActiveOnly = $this->searchActiveOnly;
    $this->resetPage();
  }

  public function resetSearch() {
    $this->hasSearched = false;
    $this->searchLastName = null;
    $this->searchSubSpecializationNameSelect = null;
    $this->searchSpecializationNameSelect = null;
    $this->searchHmoNameSelect = null;
    $this->searchDayOfWeekSelect = null;
    $this->searchTimeSelect = '';
    $this->searchActiveOnly = false;
    $this->filtered_doctors = [];
  }

  public function render() {
    $query = DB::table('doctor_resource');

    if ($this->hasSearched) {
      $query = $query->when($this->cacheSearchLastName, function ($query) {
        return $query->where('last_name', 'like', '%' . $this->cacheSearchLastName . '%');
      })
      ->when($this->cacheSearchSubSpecializationNameSelect, function($query) {
        return $query->where('sub_specialization', 'LIKE', '%' . Str::upper($this->cacheSearchSubSpecializationNameSelect) . '%');
      })
      ->when($this->cacheSearchSpecializationNameSelect, function($query) {
        return $query->where('master_specialization', 'LIKE', '%' . Str::upper($this->cacheSearchSpecializationNameSelect) . '%');
      })
      ->when($this->cacheSearchHmoNameSelect, function($query) {
        return $query->where('doctor_hmo', 'LIKE', '%' . Str::upper($this->cacheSearchHmoNameSelect) . '%');
      })
      ->when($this->cacheSearchDayOfWeekSelect, function($query) {
        return $query->where('day_of_week', 'LIKE', '%' . Str::lower($this->cacheSearchDayOfWeekSelect) . '%');
      });

      if ($this->searchTimeSelect) {
        $potentialDoctors = $query->get();
        $filtered_doctors = $this->filterSchedule($this->searchTimeSelect, $this->searchDayOfWeekSelect, $potentialDoctors->toArray());
        $this->filtered_doctors = $filtered_doctors;
        $filteredDoctorIds = collect($filtered_doctors)->pluck('doctor_id')->toArray();

        if (!empty($filteredDoctorIds)) {
          $query->whereIn('doctor_id', $filteredDoctorIds);
        } else {
          $query->where('doctor_id', '=', -1);
        }
      }
    }

    $query->orderBy('last_name');

    if (!$this->hasSearched) {
      $this->filtered_doctors = $query->get()->toArray();
    }

    $doctor_resources = $query->paginate(10);

    $this->hmos = DB::table('hmo_view')->orderBy('name', 'asc')->get()->toArray();
    $this->sub_specializations = DB::table('sub_specialization_view')->orderBy('name', 'asc')->get()->toArray();
    $this->master_specializations = DB::table('master_specialization_view')->orderBy('name', 'asc')->get()->toArray();
    $this->busy_day_of_week = DB::table('doctor_busy_next_7days_dow')->get()->toArray();

    if ($this->hasSearched) {
      self::updateUrl();
    }

    if (!empty($this->filtered_doctors)) {
      foreach ($this->filtered_doctors as $doctor) {
        $doctorId = is_object($doctor) ? $doctor->doctor_id ?? null : $doctor['doctor_id'] ?? null;

        if ($doctorId == $this->selectedDoctorId) {
          $this->selectedDoctor = is_object($doctor) ? (array)$doctor : $doctor;
          break;
        }
      }
    }

    return view('livewire.client-home', [ 'doctor_resources' => $doctor_resources ]);
  }
}
