<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Carbon\Carbon;


class AdsSetup extends Component
{
  use WithFileUploads;
  public $items;
  public $currentDate;
  public $zoomLevel = 24;

  public $sortField = 'start_datetime';
  public $sortAscending = true;
  public $newScheduleName = '';
  public $newScheduleActive = true;
  public $newScheduleDateSelect = 'today';
  public $newScheduleSpecifyDateStart = '';
  public $newScheduleSpecifyDateEnd = '';
  public $newScheduleTimeSelect = 'whole_day';
  public $newScheduleSpecifyTimeStart = '';
  public $newScheduleSpecifyTimeEnd = '';

  public $targetId = 0;
  public $targetScheduleName = '';
  public $targetScheduleActive = false;
  public $targetScheduleDateSelect = 'today';
  public $targetScheduleSpecifyDateStart = '';
  public $targetScheduleSpecifyDateEnd = '';
  public $targetScheduleTimeSelect = 'whole_day';
  public $targetScheduleSpecifyTimeStart = '';
  public $targetScheduleSpecifyTimeEnd = '';
  public $largeFilePath = '';
  public $mediumFilePath = '';
  public $largeFile = null;
  public $mediumFile = null;
  public $uploadedLargeFile = false;
  public $uploadedMediumFile = false;
  protected $listeners = [
    'proceedDelete'
  ];
  public function mount() {
    $this->currentDate = now()->setTimezone('Asia/Manila')->format('Y-m-d');
  }
  public function sortBy(string $by) {
    if ($by !== 'name' &&
      $by !== 'status' &&
      $by !== 'created_at' &&
      $by !== 'updated_at' &&
      $by !== 'start_datetime'
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
  public function updatedLargeFile() {
    $this->uploadedLargeFile = true;
  }
  public function updatedMediumFile() {
    $this->uploadedMediumFile = true;
  }
  private function saveImages() {

    $rules = [];

    if ($this->largeFile) {
      $rules['largeFile'] = 'image|max:5012';
    }

    if ($this->mediumFile) {
      $rules['mediumFile'] = 'image|max:5012';
    }

    $this->validate($rules);

    if ($this->uploadedLargeFile) {
      $Largefilename = $this->largeFile ? $this->largeFile->store('/', 'custom_avatar') : null;
      $this->largeFilePath = $Largefilename;
    }

    if ($this->uploadedMediumFile) {
      $Mediumfilename = $this->mediumFile ? $this->mediumFile->store('/', 'custom_avatar') : null;
      $this->mediumFilePath = $Mediumfilename;
    }
  }
  public function proceedCreate() {
    self::saveImages();
    $startDateTime = '';
    $endDateTime = '';

    if ($this->newScheduleDateSelect === 'today') {
      $date = now()->setTimezone('Asia/Manila')->utc('+8:00')->format('Y-m-d');
      $startDateTime = $date;
      $endDateTime = $date;
    } elseif ($this->newScheduleDateSelect === 'tomorrow') {
      $date = now()->setTimezone('Asia/Manila')->addDay()->utc('+8:00')->format('Y-m-d');
      $startDateTime = $date;
      $endDateTime = $date;
    } elseif ($this->newScheduleDateSelect === 'specifyRange') {
      $startDateTime = $this->newScheduleSpecifyDateStart;
      $endDateTime = $this->newScheduleSpecifyDateEnd;
    }

    if ($this->newScheduleTimeSelect === 'whole_day') {
      $startDateTime .= ' 00:00:00';
      $endDateTime .= ' 23:59:59';
    } else if ($this->newScheduleTimeSelect === 'specific') {
      $startTime = $this->newScheduleSpecifyTimeStart . ':00';
      $endTime = $this->newScheduleSpecifyTimeEnd . ':00';

      $startDateTime .= ' ' . $startTime;
      $endDateTime .= ' ' . $endTime;
    }

    DB::statement('SELECT admin_insert_advertisement_schedule(?::character varying, ?::smallint, ?::character varying, ?::character varying, ?::character varying, ?::character varying)', [
      $this->newScheduleName,
      $this->newScheduleActive ? 1 : 0,
      !empty($this->largeFilePath) ? $this->largeFilePath : null,
      $this->mediumFilePath,
      $startDateTime,
      $endDateTime
    ]);

    $this->newScheduleName = '';
    $this->newScheduleActive = true;
    $this->newScheduleDateSelect = 'today';
    $this->newScheduleSpecifyDateStart = '';
    $this->newScheduleSpecifyDateEnd = '';
    $this->newScheduleTimeSelect = 'whole_day';
    $this->newScheduleSpecifyTimeStart = '';
    $this->largeFilePath = '';
    $this->mediumFilePath = '';
    $this->uploadedLargeFile = false;
    $this->uploadedMediumFile = false;
    $this->largeFile = null;
    $this->mediumFile = null;
  }
  public function setSelected($id, $mode) {
    $this->largeFile = null;
    $this->mediumFile = null;
    $this->largeFilePath = '';
    $this->mediumFilePath = '';
    $this->uploadedLargeFile = false;
    $this->uploadedMediumFile = false;

    if ($mode === 'create') {
      $this->emit('createModal');
      return;
    }

    $return = DB::table('admin_advertisement_schedule')->where('id', '=', $id)->get()->first();
    $this->targetId = $return->id ?? 0;
    $this->targetScheduleName = $return->name ?? '';
    $this->targetScheduleActive = $return->is_active ?? 0;

    $startDate = $return->start_datetime ?? '';
    $endDate = $return->end_datetime ?? '';


    if (!empty($startDate) && !empty($endDate)) {
      $startDateObj = Carbon::parse($startDate);
      $endDateObj = Carbon::parse($endDate);
      if ($startDateObj->isToday()) {
        $this->targetScheduleDateSelect = 'today';
      } elseif ($startDateObj->isTomorrow()) {
        $this->targetScheduleDateSelect = 'tomorrow';
      } else {
        $this->targetScheduleDateSelect = 'specifyRange';
        $this->targetScheduleSpecifyDateStart = $startDateObj->format('Y-m-d');
        $this->targetScheduleSpecifyDateEnd = $endDateObj->format('Y-m-d');
      }

      if ($startDateObj->format('H:i:s') === '00:00:00' && $endDateObj->format('H:i:s') === '23:59:59') {
        $this->targetScheduleTimeSelect = 'whole_day';
      } else {
        $this->targetScheduleTimeSelect = 'specific';
        $this->targetScheduleSpecifyTimeStart = $startDateObj->format('H:i');
        $this->targetScheduleSpecifyTimeEnd = $endDateObj->format('H:i');
      }
    }

    $this->largeFilePath = $return->large_image_path ?? '';
    $this->mediumFilePath = $return->medium_image_path ?? '';
    $this->uploadedLargeFile = !empty($this->largeFilePath);
    $this->uploadedMediumFile = !empty($this->mediumFilePath);

    if ($mode === 'delete') {
      $this->emit('deleteModal');
    } else if ($mode === 'edit') {
      $this->emit('editModal');
    }
  }
  public function proceedDelete() {
    DB::select('SELECT admin_delete_advertisement_schedule(?::integer)', [
      $this->targetId,
    ]);

    $this->targetId = 0;
  }

  public function getTimelineWidth() {
    // Calculate width based on zoom level
    // Example: 100px per hour for better scrolling
    return $this->zoomLevel * 100;
  }

  public function proceedEdit() {

    $return_list = self::saveImages();
    $large_path = $return_list[0] ?? null;
    $medium_path = $return_list[1] ?? null;
    $startDateTime = '';
    $endDateTime = '';

    if ($this->targetScheduleDateSelect === 'today') {
      $date = now()->setTimezone('Asia/Manila')->format('Y-m-d');
      $startDateTime = $date;
      $endDateTime = $date;
    } elseif ($this->targetScheduleDateSelect === 'tomorrow') {
      $date = now()->setTimezone('Asia/Manila')->addDay()->format('Y-m-d');
      $startDateTime = $date;
      $endDateTime = $date;
    } elseif ($this->targetScheduleDateSelect === 'specifyRange') {
      $startDateTime = $this->targetScheduleSpecifyDateStart;
      $endDateTime = $this->targetScheduleSpecifyDateEnd;
    }

    if ($this->targetScheduleTimeSelect === 'whole_day') {
      $startDateTime .= ' 00:00:00';
      $endDateTime .= ' 23:59:59';
    } else if ($this->targetScheduleTimeSelect === 'specific') {
      $startTime = $this->targetScheduleSpecifyTimeStart . ':00';
      $endTime = $this->targetScheduleSpecifyTimeEnd . ':00';

      $startDateTime .= ' ' . $startTime;
      $endDateTime .= ' ' . $endTime;
    }

    DB::statement('SELECT admin_update_advertisement_schedule(?::integer, ?::character varying, ?::smallint, ?::character varying, ?::character varying, ?::character varying, ?::character varying)', [
      $this->targetId,
      $this->targetScheduleName,
      $this->targetScheduleActive,
      !empty($this->largeFilePath) ? $this->largeFilePath : null,
      !empty($this->mediumFilePath) ? $this->mediumFilePath : null,
      $startDateTime,
      $endDateTime
    ]);
  }

  protected $colors = [
    '#4e79a7', '#f28e2b', '#e15759', '#76b7b2',
    '#59a14f', '#edc948', '#b07aa1', '#ff9da7',
    '#9c755f', '#bab0ac', '#8cd17d', '#499894'
  ];

  public function shouldShowNowLine() {
    $now = now()->setTimezone('Asia/Manila');
    $centerPoint = Carbon::parse($this->currentDate);
    $start = $centerPoint->copy()->subHours($this->zoomLevel);
    $end = $centerPoint->copy()->addHours($this->zoomLevel);

    return $now->between($start, $end);
  }

  public function getNowPosition() {
    return $this->timeToPosition(now()->addHours(8)); //timezone
  }

  public function formatTime($datetime) {
    return Carbon::parse($datetime)->format('H:i');
  }

  protected function timeToPosition($time) {
    $time = Carbon::parse($time);
    $centerPoint = Carbon::parse($this->currentDate);
    $start = $centerPoint->copy()->subHours($this->zoomLevel);
    $end = $centerPoint->copy()->addHours($this->zoomLevel);

    if ($time <= $start) return 0;
    if ($time >= $end) return 100;

    return ($time->diffInSeconds($start) / $end->diffInSeconds($start)) * 100;
  }

  public function getItemPositionData($item) {
    if (!$item->is_active) {
      return;
    }

    $startTime = Carbon::parse($item->start_datetime);
    $endTime = Carbon::parse($item->end_datetime);

    $centerPoint = Carbon::parse($this->currentDate);

    $startPos = max(0, $this->timeToPosition($startTime));
    $endPos = min(100, $this->timeToPosition($endTime));
    $width = $endPos - $startPos;

    return [
      'start' => $startPos,
      'end' => $endPos,
      'width' => $width > 0 ? $width : 0
    ];
  }

  public function getTimelineMarkers() {
    $markers = [];
    $markerInterval = $this->zoomLevel <= 12 ? 1 : 2; // hours

    $centerPoint = Carbon::parse($this->currentDate);
    $start = $centerPoint->copy()->subHours($this->zoomLevel);
    $end = $centerPoint->copy()->addHours($this->zoomLevel);

    $firstMarkerHour = floor($start->hour / $markerInterval) * $markerInterval;
    $markerTime = $start->copy()->setTime($firstMarkerHour, 0);

    $lastDayShown = null;

    while ($markerTime <= $end) {
      $position = $this->timeToPosition($markerTime);

      $showDayLabel = $markerTime->hour == 12 && $markerTime->day != $lastDayShown;

      if ($showDayLabel) {
        $markers[] = [
          'position' => $position,
          'label' => $markerTime->format('H:i'),
          'day_label' => $markerTime->format('D, M j'), // e.g. "May 10"
          'is_day_marker' => true
        ];
        $lastDayShown = $markerTime->day;
      } else {
        $markers[] = [
          'position' => $position,
          'label' => $markerTime->format('H:i'),
          'is_day_marker' => false
        ];
      }

      $markerTime->addHours($markerInterval);
    }

    return $markers;
  }

  public function getItemColor($index) {
    return $this->colors[$index % count($this->colors)];
  }

  public function render() {
    $query = DB::table('admin_advertisement_schedule');

    $query->orderBy($this->sortField, $this->sortAscending ? 'asc' : 'desc');

    $advertistment_schedules = $query->paginate(10);
    return view('livewire.admin.ads-setup', ['advertistment_schedules' => $advertistment_schedules]);
  }
}
