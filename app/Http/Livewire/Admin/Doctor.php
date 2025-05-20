<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class Doctor extends Component
{
  use WithPagination;
  use WithFileUploads;

  public $currentDate = '';
  public $availableSlots = [];
  public $sortField = 'last_name';
  public $sortAscending = true;
  public $searchFirstName = '';
  public $searchLastName = '';
  public $searchActiveOnly = 'any';
  public $cacheSearchFirstName = '';
  public $cacheSearchLastName = '';
  public $cacheSearchActiveOnly = 'any';
  public $targetDoctorId = 0;
  public $targetDoctorFirstName = '';
  public $targetDoctorLastName = '';
  public $targetDoctorBirthdate = '';
  public $targetDoctorImagePath = '';
  public $targetDoctorSuffix = '';
  public $targetDoctorMiddleName = '';
  public $targetActive = false;
  public $targetContactNumber = '';
  public $targetClinicId = 0;
  public $targetClinicCodeName = '';
  public $targetSearchHMOName = '';
  public $targetSearchSubSpecializationName = '';
  public $targetMasterSpecializationId = 0;
  public $targetSelectedHMOArray = [];
  public $targetSelectedSubSpecializationArray = [];
  public $targetSelectedSchedule = [];
  public $targetSelectedBusySchedule = [];
  public $targetScheduleId = 0;
  public $targetScheduleStart = '';
  public $targetScheduleStartHr = '00';
  public $targetScheduleStartMin = '00';
  public $targetScheduleStartAmpm = 'AM';
  public $targetScheduleEnd = '';
  public $targetScheduleEndHr = '00';
  public $targetScheduleEndMin = '00';
  public $targetScheduleEndAmpm = 'AM';
  public $targetScheduleBusyId = 0;
  public $targetNewScheduleBusyDateSelect = 'today';
  public $targetNewScheduleBusySpecifyDateStart = '';
  public $targetNewScheduleBusySpecifyDateEnd = '';
  public $targetNewScheduleBusyTimeSelect = 'whole_day';
  public $targetNewScheduleBusySpecifyTimeStart = '';
  public $targetNewScheduleBusySpecifyTimeEnd = '';
  public $targetNewScheduleStartHr = '00';
  public $targetNewScheduleStartMin = '00';
  public $targetNewScheduleStartAmpm = 'AM';
  public $targetNewScheduleEndHr = '00';
  public $targetNewScheduleEndMin = '00';
  public $targetNewScheduleEndAmpm = 'AM';
  public $targetNewScheduleDOW = 'monday';
  public $targetNewScheduleType = 'walk-in';
  public $targetScheduleType = 'walk-in';
  public $targetScheduleDOW = 'monday';
  public $newDoctorFirstName = '';
  public $newDoctorLastName = '';
  public $newDoctorBirthdate = '';
  public $newDoctorImagePath = '';
  public $newDoctorSuffix = '';
  public $newDoctorMiddleName = '';
  public $newActive = true;
  public $newContactNumber = '';
  public $newClinicCodeName = '';
  public $newMasterSpecializationId = 0;
  public $newSelectedHMOArray = [];
  public $newSelectedSubSpecializationArray = [];
  public $newSearchHMOName = '';
  public $newSearchSubSpecializationName = '';
  public $hasSearched = false;
  public $filtered_doctors = [];
  public $doctorsArray = [];
  public $file;

  public $showModal = true;
  public $uploadedFile = false;

  public $showAlert = false;
  public $alertTitle = '';
  public $alertMessage = '';
  public $duration = 5;
  public $hmos = [];
  public $sub_specializations = [];
  public $master_specializations = [];
  public $searchSubSpecializationNameSelect = '';
  public $searchSpecializationNameSelect = '';
  public $cacheSearchSubSpecializationNameSelect = '';
  public $cacheSearchSpecializationNameSelect = '';

  public function mount() {
    $this->currentDate = Carbon::now()->toDateString();
  }


  protected $listeners = [
    'proceedDelete' => 'proceedDelete',
    'proceedEdit' => 'proceedEdit',
    'proceedCreate' => 'proceedCreate',
    'proceed' => 'proceed',
    'setSelectedSchedule',
    'proceedDeleteSchedule',
    'proceedEditSchedule',
    'proceedCreateSchedule',
    'proceedCreateScheduleBusy',
    'setCreateSchedule',
    'setCreateScheduleBusy',
    'proceedDeleteAllSchedule',
    'proceedDeleteAllScheduleBusy',
    'refreshRecords' => '$refresh',
    'newSelectedHMOArrayUpdated',
    'newSelectedSubSpecializationArrayUpdated',
    'targetSelectedHMOArrayUpdated',
    'targetSelectedSubSpecializationArrayUpdated'
  ];
  public function proceedCreateScheduleBusy() {
    $startDateTime = '';
    $endDateTime = '';

    if ($this->targetNewScheduleBusyDateSelect === 'today') {
      $date = now()->format('Y-m-d');
      $startDateTime = $date;
      $endDateTime = $date;
    } elseif ($this->targetNewScheduleBusyDateSelect === 'tomorrow') {
      $date = now()->addDay()->format('Y-m-d');
      $startDateTime = $date;
      $endDateTime = $date;
    } elseif ($this->targetNewScheduleBusyDateSelect === 'specifyRange') {
      $startDateTime = $this->targetNewScheduleBusySpecifyDateStart;
      $endDateTime = $this->targetNewScheduleBusySpecifyDateEnd;
    }

    if ($this->targetNewScheduleBusyTimeSelect === 'whole_day') {
      $startDateTime .= ' 00:00:00';
      $endDateTime .= ' 23:59:59';
    } else if ($this->targetNewScheduleBusyTimeSelect === 'specific') {
      $startTime = $this->targetNewScheduleBusySpecifyTimeStart . ':00';
      $endTime = $this->targetNewScheduleBusySpecifyTimeEnd . ':00';

      $startDateTime .= ' ' . $startTime;
      $endDateTime .= ' ' . $endTime;
    }

    DB::select('SELECT admin_insert_doctor_schedule_busy(?::integer, ?::varchar, ?::varchar)', [
      $this->targetDoctorId,
      $startDateTime,
      $endDateTime
    ]);
  }
  public function proceedDeleteAllScheduleBusy() {
    DB::select('SELECT admin_delete_doctor_all_schedule_busy(?::integer)', [
      $this->targetDoctorId
    ]);

    $this->targetSelectedBusySchedule = [];

    $this->targetScheduleId = 0;
  }
  public function proceedDeleteAllSchedule() {
    DB::select('SELECT admin_delete_doctor_all_schedule(?::integer)', [
      $this->targetDoctorId
    ]);

    $this->targetSelectedSchedule = [];

    $this->targetScheduleId = 0;
  }
  public function setCreateScheduleBusy() {
    $this->targetScheduleBusyId = 0;
    $this->targetNewScheduleBusyDateSelect = 'today';
    $this->targetNewScheduleBusyTimeSelect = 'whole_day';
    $this->targetNewScheduleBusySpecifyDateStart = '';
    $this->targetNewScheduleBusySpecifyDateEnd = '';
    $this->targetNewScheduleBusySpecifyTimeStart = '';
    $this->targetNewScheduleBusySpecifyTimeEnd = '';

    $this->emit('createScheduleBusy');
  }
  public function setCreateSchedule() {
    $this->targetScheduleId = 0;
    $this->targetNewScheduleStartHr = '00';
    $this->targetNewScheduleStartMin = '00';
    $this->targetNewScheduleStartAmpm = 'AM';
    $this->targetNewScheduleEndHr = '00';
    $this->targetNewScheduleEndMin = '00';
    $this->targetNewScheduleEndAmpm = 'AM';
    $this->targetNewScheduleDOW = 'monday';
    $this->targetNewScheduleType = 'walk-in';

    $this->emit('createSchedule');
  }
  public function proceedCreateSchedule() {
    $start_time = self::timeImplode($this->targetNewScheduleStartHr, $this->targetNewScheduleStartMin, $this->targetNewScheduleStartAmpm);
    $end_time = self::timeImplode($this->targetNewScheduleEndHr, $this->targetNewScheduleEndMin, $this->targetNewScheduleEndAmpm);

    DB::select('SELECT admin_insert_doctor_schedule(?::integer, ?::varchar, ?::varchar, ?::varchar, ?::varchar)', [
      $this->targetDoctorId,
      $start_time,
      $end_time,
      $this->targetNewScheduleType,
      $this->targetNewScheduleDOW
    ]);

    $this->targetNewScheduleStartHr = '00';
    $this->targetNewScheduleStartMin = '00';
    $this->targetNewScheduleStartAmpm = 'AM';
    $this->targetNewScheduleEndHr = '00';
    $this->targetNewScheduleEndMin = '00';
    $this->targetNewScheduleEndAmpm = 'AM';
    $this->targetNewScheduleDOW = 'monday';
    $this->targetNewScheduleType = 'walk-in';
  }
  public function proceedEditSchedule() {
    $start_time = self::timeImplode($this->targetNewScheduleStartHr, $this->targetNewScheduleStartMin, $this->targetNewScheduleStartAmpm);
    $end_time = self::timeImplode($this->targetNewScheduleEndHr, $this->targetNewScheduleEndMin, $this->targetNewScheduleEndAmpm);

    DB::select('SELECT admin_update_doctor_schedule(?::interger, ?::interger, ?::varchar, ?::varchar, ?::varchar, ?::varchar)', [
      $this->targetScheduleId,
      $this->targetDoctorId,
      $start_time,
      $end_time,
      $this->targetNewScheduleDOW,
      $this->targetNewScheduleType
    ]);

    $this->targetScheduleId = 0;
    $this->targetScheduleStartHr = '00';
    $this->targetScheduleStartMin = '00';
    $this->targetScheduleStartAmpm = 'AM';
    $this->targetScheduleEndHr = '00';
    $this->targetScheduleEndMin = '00';
    $this->targetScheduleEndAmpm = 'AM';
    $this->targetScheduleDOW = 'monday';
    $this->targetScheduleType = 'walk-in';
  }

  public function proceedDeleteSchedule() {
    DB::select('SELECT admin_delete_doctor_schedule(?::integer, ?::integer)', [
      $this->targetScheduleId,
      $this->targetDoctorId
    ]);

    $this->targetSelectedSchedule = array_filter($this->targetSelectedSchedule, function ($schedule) {
      return $schedule['id'] != $this->targetScheduleId;
    });

    $this->targetSelectedSchedule = array_values($this->targetSelectedSchedule);

    $this->targetScheduleId = 0;
  }
  public function newSelectedHMOArrayUpdated($hmoId) {
    if (($key = array_search($hmoId, $this->newSelectedHMOArray)) !== false) {
      unset($this->newSelectedHMOArray[$key]);
    } else {
      $this->newSelectedHMOArray[] = $hmoId;
    }
  }
  public function newSelectedSubSpecializationArrayUpdated($subSpecializationId) {
    if (($key = array_search($subSpecializationId, $this->newSelectedSubSpecializationArray)) !== false) {
      unset($this->newSelectedSubSpecializationArray[$key]);
    } else {
      $this->newSelectedSubSpecializationArray[] = $subSpecializationId;
    }
  }
  public function targetSelectedHMOArrayUpdated($hmoId) {
    if (($key = array_search($hmoId, $this->targetSelectedHMOArray)) !== false) {
      unset($this->targetSelectedHMOArray[$key]);
    } else {
      $this->targetSelectedHMOArray[] = $hmoId;
    }
  }
  public function targetSelectedSubSpecializationArrayUpdated($subSpecializationId) {
    if (($key = array_search($subSpecializationId, $this->targetSelectedSubSpecializationArray)) !== false) {
      unset($this->targetSelectedSubSpecializationArray[$key]);
    } else {
      $this->targetSelectedSubSpecializationArray[] = $subSpecializationId;
    }
  }
  public function removeSelectedHMOId($recordId) {
    if (($key = array_search($recordId, $this->newSelectedHMOArray)) !== false) {
      unset($this->newSelectedHMOArray[$key]);
    }
  }
  public function removeSelectedSubSpecializationId($recordId) {
    if (($key = array_search($recordId, $this->newSelectedSubSpecializationArray)) !== false) {
      unset($this->newSelectedSubSpecializationArray[$key]);
    }
  }
  public function removeTargetSelectedHMOId($recordId) {
    if (($key = array_search($recordId, $this->targetSelectedHMOArray)) !== false) {
      unset($this->targetSelectedHMOArray[$key]);
    }
  }
  public function removeTargetSelectedSubSpecializationId($recordId) {
    if (($key = array_search($recordId, $this->targetSelectedSubSpecializationArray)) !== false) {
      unset($this->targetSelectedSubSpecializationArray[$key]);
    }
  }
  public function updatedFile() {
    $this->uploadedFile = true;
  }
  public function proceedCreate() {
    $this->validate(
      [
        'newDoctorFirstName' => 'required|min:6',
        'newDoctorLastName' => 'required|min:6'
      ],
      [
        'newDoctorFirstName.required' => 'cannot be empty.',
        'newDoctorFirstName.min' => 'cannot be empty.',
        'newDoctorLastName.required' => 'cannot be empty.',
        'newDoctorLastName.min' => 'must be at least 6 characters long.'
      ]
    );

    $filename = self::saveImage();

    $pg_hmo_array = '{' . implode(',', $this->newSelectedHMOArray) . '}';
    $pg_sub_specialization_array = '{' . implode(',', $this->newSelectedSubSpecializationArray) . '}';

    DB::statement('SELECT admin_insert_doctor(?::varchar, ?::varchar, ?::varchar, ?::character, ?::varchar, ?::varchar, ?::varchar, ?::smallint, ?::varchar, ?::integer[], ?::integer, ?::integer[])', [
      $this->newDoctorFirstName,
      $this->newDoctorLastName,
      $this->newDoctorBirthdate,
      $this->newDoctorSuffix,
      $this->newDoctorMiddleName,
      $this->newContactNumber,
      $this->newClinicCodeName,
      $this->newActive ? 1 : 0,
      empty($filename) ? null : $filename,
      $pg_hmo_array,
      $this->newMasterSpecializationId,
      $pg_sub_specialization_array
    ]);

    $this->newDoctorFirstName = '';
    $this->newDoctorLastName = '';
    $this->newDoctorBirthdate = '';
    $this->newDoctorImagePath = '';
    $this->newDoctorSuffix = '';
    $this->newDoctorMiddleName = '';
    $this->newActive = true;
    $this->newClinicCodeName = '';
    $this->newMasterSpecializationId = 0;
    $this->newSelectedHMOArray = [];
    $this->newSelectedSubSpecializationArray = [];
    $this->newContactNumber = '';
    $this->uploadedFile = false;
  }
  public function proceedEdit() {
    $filename = self::saveImage();

    $pg_hmo_array = '{' . implode(',', $this->targetSelectedHMOArray) . '}';
    $pg_sub_specialization_array = '{' . implode(',', $this->targetSelectedSubSpecializationArray) . '}';

    DB::select('SELECT admin_update_doctor(
      ?::integer,
      ?::varchar,
      ?::varchar,
      ?::varchar,
      ?::char,
      ?::varchar,
      ?::smallint,
      ?::integer,
      ?::varchar,
      ?::varchar,
      ?::varchar,
      ?::integer[],
      ?::integer,
      ?::integer[])', [
      $this->targetDoctorId,
      $this->targetDoctorFirstName,
      $this->targetDoctorLastName,
      $this->targetDoctorBirthdate,
      $this->targetDoctorSuffix,
      $this->targetDoctorMiddleName,
      $this->targetActive ? 1 : 0,
      $this->targetClinicId,
      $this->targetContactNumber,
      $this->targetClinicCodeName,
      empty($filename) ? null : $filename,
      $pg_hmo_array,
      $this->targetMasterSpecializationId,
      $pg_sub_specialization_array
    ]);

    $this->uploadedFile = false;
  }
  private function saveImage(): string
  {
    if ($this->uploadedFile === false) {
      return '';
    }
    try {
      $this->validate([
        'file' => 'image|max:1024',
      ]);

      $filename = $this->file->store('/', 'custom_avatar');
      $this->targetDoctorImagePath = $filename;

      return $filename;
    } catch (\Illuminate\Validation\ValidationException $e) {
      return '';
    }
  }

  public function resetSetFilters() {
    $this->hasSearched = false;
    $this->searchLastName = '';
    $this->searchFirstName = '';
    $this->searchActiveOnly = 'any';
    $this->searchSubSpecializationNameSelect = '';
    $this->searchSpecializationNameSelect = '';
  }
  public function setFilters() {
    $this->hasSearched = true;
    $this->cacheSearchLastName = $this->searchLastName;
    $this->cacheSearchFirstName = $this->searchFirstName;
    $this->cacheSearchActiveOnly = $this->searchActiveOnly;
    $this->cacheSearchSubSpecializationNameSelect = $this->searchSubSpecializationNameSelect;
    $this->cacheSearchSpecializationNameSelect = $this->searchSpecializationNameSelect;
  }
  public function resetFilters() {
    $this->reset([
      'searchFirstName',
      'searchLastName',
      'searchActiveOnly',
      'searchSubSpecializationNameSelect',
      'searchSpecializationNameSelect',

    ]);

    $this->sortField = 'last_name';
    $this->sortAscending = true;

    $this->setFilters();

    $this->resetPage();
  }

  public function proceedDelete() {
    DB::select('SELECT admin_delete_doctor(?::integer)', [
      $this->targetDoctorId,
    ]);

    $this->targetDoctorId = 0;
  }
  protected function resetTargetDoctorProperties() {
    $this->targetDoctorId = 0;
    $this->targetDoctorFirstName = '';
    $this->targetDoctorLastName = '';
    $this->targetDoctorBirthdate = '';
    $this->targetDoctorImagePath = '';
    $this->targetDoctorSuffix = '';
    $this->targetDoctorMiddleName = '';
    $this->targetClinicId = 0;
    $this->targetContactNumber = '';
    $this->targetClinicCodeName = '';
    $this->targetActive = false;
    $this->targetSearchHMOName = '';
    $this->targetSearchSubSpecializationName = '';
    $this->targetMasterSpecializationId = 0;
    $this->targetSelectedHMOArray = [];
    $this->targetSelectedSubSpecializationArray = [];
  }
  public function timeImplode($hour_12, $minute, $ampm): string
  {
    $hour_24 = ($ampm === 'PM' || $ampm === 'pm') ? ($hour_12 % 12) + 12 : ($hour_12 % 12);

    if (($ampm === 'AM' || $ampm === 'am') && $hour_12 == 12) {
      $hour_24 = 0;
    }

    return sprintf("%02d:%02d:00", $hour_24, $minute);
  }
  public function timeExtract($timeString) {
    $schedule_start = date('h:i A', strtotime($timeString));
    $time_parts = date_parse_from_format('h:i A', $schedule_start);
    $hour = $time_parts['hour'];
    $minute = str_pad($time_parts['minute'], 2, '0', STR_PAD_LEFT);
    $ampm = $hour >= 12 ? 'PM' : 'AM';
    $hour_12 = $hour % 12;
    $hour_12 = $hour_12 ? $hour_12 : 12;
    $hour_12 = str_pad($hour_12, 2, '0', STR_PAD_LEFT);

    return ([
      "hour_12" => $hour_12,
      "minute" => $minute,
      "ampm" => $ampm
    ]);
  }

  public function setSelectedSchedule($data) {
    $schedule = DB::table('doctor_schedule')->where('id', '=', $data['id'])->get()->first();
    $this->targetScheduleId =  $schedule->id;
    $this->targetScheduleStart =  $schedule->start_time;

    $start_time_object = self::timeExtract($schedule->start_time);
    $end_time_object = self::timeExtract($schedule->end_time);

    $this->targetScheduleStartHr = $start_time_object['hour_12'];
    $this->targetScheduleStartMin = $start_time_object['minute'];
    $this->targetScheduleStartAmpm = $start_time_object['ampm'];

    $this->targetScheduleEndHr = $end_time_object['hour_12'];
    $this->targetScheduleEndMin = $end_time_object['minute'];
    $this->targetScheduleEndAmpm = $end_time_object['ampm'];

    $this->targetScheduleEnd = $schedule->end_time;
    $this->targetScheduleType = $schedule->visit_type;
    $this->targetScheduleDOW = $schedule->day_of_week;

    $this->targetNewScheduleStartHr = $this->targetScheduleStartHr;
    $this->targetNewScheduleStartMin = $this->targetScheduleStartMin;
    $this->targetNewScheduleStartAmpm = $this->targetScheduleStartAmpm;
    $this->targetNewScheduleEndHr = $this->targetScheduleEndHr;
    $this->targetNewScheduleEndMin = $this->targetScheduleEndMin;
    $this->targetNewScheduleEndAmpm = $this->targetScheduleEndAmpm;
    $this->targetNewScheduleDOW = $this->targetScheduleDOW;
    $this->targetNewScheduleType = $this->targetScheduleType;
  }
  public function setSelectedDoctor(int $id, string $mode) {
    $this->file = '';
    $this->targetDoctorImagePath = '';
    $this->uploadedFile = false;
    if ($mode === 'create') {
      $this->resetTargetDoctorProperties();
      $this->emit('createModal');
      return;
    }

    $doctor = DB::table('admin_doctor')->where('id', '=', $id)->get()->first();
    $this->targetDoctorId = $doctor->id ?? 0;
    $this->targetDoctorFirstName = $doctor->first_name ?? '';
    $this->targetDoctorLastName = $doctor->last_name ?? '';
    $this->targetDoctorBirthdate = $doctor->date_of_birth ?? '';
    $this->targetDoctorImagePath = $doctor->image_path ?? '';
    $this->targetDoctorSuffix = $doctor->suffix ?? '';
    $this->targetDoctorMiddleName = $doctor->middle_name ?? '';
    $this->targetContactNumber = $doctor->contact_number ?? '';
    $this->targetClinicId = $doctor->dc_id ?? 0;
    $this->targetClinicCodeName = $doctor->dc_code_name ?? '';
    $this->targetActive = $doctor->is_active ?? false;

    $specialization_object = json_decode($doctor->specializations, false);
    $hmo_object = json_decode($doctor->hmos, false);

    if ($mode === 'calendar') {
      $this->emit('calendarModal');
      return;
    }
    if ($mode === 'schedule') {
      $this->emit('scheduleModal');
      return;
    }

    $this->targetMasterSpecializationId = null;
    foreach ($specialization_object as $spec) {
      if (isset($spec->type) && $spec->type === 'master') {
        $this->targetMasterSpecializationId = $spec->id;
        break;
      }
    }


    $this->targetSelectedHMOArray = array_map(function ($hmo) {
      return $hmo->id;
    }, $hmo_object);

    $this->targetSelectedSubSpecializationArray = array_filter(
      array_map(function ($spec) {
        return $spec->type === "sub" ? $spec->id : null;
      }, $specialization_object),
      function ($value) {
        return $value !== null;
      }
    );

    $this->targetSearchHMOName = '';
    $this->targetSearchSubSpecializationName = '';

    if ($mode === 'delete') {
      $this->emit('deleteModal');
    } else if ($mode === 'edit') {
      $this->emit('editModal');
    }
  }
  public function deleteDoctor(Request $request) {
    $request->validate([
      'doctor_id' => 'required|integer',
    ]);

    $return = DB::select('SELECT admin_delete_doctor(?::integer)', [
      $request->id
    ]);

    if ($return) {
      return response()->json(['message' => 'Doctor deleted successfully']);
    } else {
      return response()->json(['message' => 'Doctor not found or already deleted'], 404);
    }
  }
  public function sortBy(string $by) {
    if (
      $by !== 'last_name' &&
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
  public function updatingSearchLastName() {
    $this->resetPage();
  }
  public function updatingSearchFirstName() {
    $this->resetPage();
  }
  public function updatingSearchActiveOnly() {
    $this->resetPage();
  }

  public function subtractRanges(array $sources, array $subtractors): array
  {
    $result = [];

    foreach ($sources as $sourceRanges) {
      foreach ($sourceRanges as $source) {
        // Validate and set default times
        $startA = empty($source['start_time']) || $source['start_time'] === '00:00:00' ? '00:00:00' : $source['start_time'];
        $endA = empty($source['end_time']) || $source['end_time'] === '00:00:00' ? '23:59:59' : $source['end_time'];

        // Validate day of week
        if (empty($source['day_of_week'])) {
          continue;
        }

        try {
          // Create dates for the next occurrence of this day
          $startDate = Carbon::now()->next($source['day_of_week'])->setTimeFromTimeString($startA);
          $endDate = Carbon::now()->next($source['day_of_week'])->setTimeFromTimeString($endA);

          // Handle overnight ranges
          if ($endDate <= $startDate) {
            $endDate->addDay();
          }

          $adjustedStart = $startDate;
          $adjustedEnd = $endDate;

          foreach ($subtractors as $subtractorRanges) {
            foreach ($subtractorRanges as $subtractor) {
              if (empty($subtractor['start_datetime']) || empty($subtractor['end_datetime'])) {
                continue;
              }

              try {
                $startB = Carbon::parse($subtractor['start_datetime'])->setTimezone('Asia/Shanghai');
                $endB = Carbon::parse($subtractor['end_datetime'])->setTimezone('Asia/Shanghai');

                // Check if subtractor overlaps with source
                if (!($endB <= $adjustedStart || $startB >= $adjustedEnd)) {
                  // If subtractor starts during source, adjust source start
                  if ($startB > $adjustedStart && $startB < $adjustedEnd) {
                    $adjustedStart = $startB;
                  }

                  // If subtractor ends during source, adjust source end
                  if ($endB > $adjustedStart && $endB < $adjustedEnd) {
                    $adjustedEnd = $endB;
                  }
                }
              } catch (\Exception $e) {
                continue;
              }
            }
          }

          // Only add if there's still time remaining
          if ($adjustedStart < $adjustedEnd) {
            $result[] = [
              'id' => $source['id'] ?? null,
              'start_time' => $adjustedStart->format('H:i:s'),
              'end_time' => $adjustedEnd->format('H:i:s'),
              'day_of_week' => $source['day_of_week'],
              'visit_type' => $source['visit_type'] ?? null
            ];
          }
        } catch (\Exception $e) {
          continue;
        }
      }
    }

    return $result;
  }

  public function prevMonth() {
    $this->currentDate = Carbon::parse($this->currentDate)->setTimezone('Asia/Shanghai')->subMonth()->toDateString();
  }

  public function nextMonth() {
    $this->currentDate = Carbon::parse($this->currentDate)->setTimezone('Asia/Shanghai')->addMonth()->toDateString();
  }
  private function formatBusySchedules($busy_schedule_object) {
    return array_map(function ($schedule) {
      $start = Carbon::parse($schedule['start_datetime'])->setTimezone('Asia/Shanghai');
      $end = Carbon::parse($schedule['end_datetime'])->setTimezone('Asia/Shanghai');

      if ($start->format('H:i:s') === '00:00:00' && $end->format('H:i:s') === '23:59:59') {
        if ($start->isToday()) {
          $formatted = 'Today';
        } elseif ($start->isTomorrow()) {
          $formatted = 'Tomorrow';
        } elseif ($start->isYesterday()) {
          $formatted = 'Yesterday';
        } else {
          $formatted = $start->format('M j, Y');
        }
      } else {
        $formatted = $start->format('M j, Y g:i a') . ' - ' . $end->format('M j, Y g:i a');
      }

      return [
        'id' => $schedule['id'],
        'formatted_schedule' => $formatted,
        'start_datetime' => $schedule['start_datetime'],
        'end_datetime' => $schedule['end_datetime'],
      ];
    }, $busy_schedule_object);
  }
  public function render() {
    $query = DB::table('admin_doctor');

    if ($this->hasSearched) {
      $query->when($this->cacheSearchFirstName, function ($query) {
        return $query->where('first_name', 'like', '%' . $this->cacheSearchFirstName . '%');
      })
        ->when($this->cacheSearchLastName, function ($query) {
          return $query->where('last_name', 'like', '%' . $this->cacheSearchLastName . '%');
        });

      if (!empty($this->cacheSearchSpecializationNameSelect)) {
        $query->where('master_specialization_name', 'LIKE', '%' . Str::upper($this->cacheSearchSpecializationNameSelect) . '%');
      }
      if (!empty($this->cacheSearchSubSpecializationNameSelect)) {
        $query->where('sub_specialization_name', 'LIKE', '%' . Str::upper($this->cacheSearchSubSpecializationNameSelect) . '%');
      }

      if ($this->cacheSearchActiveOnly === 'yes'  || $this->cacheSearchActiveOnly === 'no') {
        $query->where('is_active', '=', ($this->cacheSearchActiveOnly === 'yes') ? 1 : 0);
      }
    }

    if ($this->targetDoctorId !== 0) {
      $doctor = DB::table('admin_doctor')->where('id', '=', $this->targetDoctorId)->get()->first();
      $schedule_object = json_decode($doctor->schedule, true);
      $busy_schedule_object = json_decode($doctor->schedule_busy, true);
      $this->targetSelectedSchedule = $schedule_object;
      $this->targetSelectedBusySchedule = self::formatBusySchedules($busy_schedule_object);

      $this->availableSlots = self::subtractRanges($this->targetSelectedSchedule, $this->targetSelectedBusySchedule);
    }

    $query->orderBy($this->sortField, $this->sortAscending ? 'asc' : 'desc');

    $doctors = $query->paginate(10);

    $this->hmos = DB::table('hmo_view')->orderBy('name', 'asc')->get()->toArray();
    $this->sub_specializations = DB::table('sub_specialization_view')->orderBy('name', 'asc')->get()->toArray();
    $this->master_specializations = DB::table('master_specialization_view')->orderBy('name', 'asc')->get()->toArray();

    return view('livewire.admin.doctor', ['doctors' => $doctors]);
  }
}
