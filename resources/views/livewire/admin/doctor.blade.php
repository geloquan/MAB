<div class="mb-3" id="doctor">
  @php
    use Carbon\Carbon;
    use Carbon\CarbonPeriod;
    function in_range($range, $time) {
      $start = Carbon::parse($range[0])->setTimezone('Asia/Shanghai');
      $end = Carbon::parse($range[1])->setTimezone('Asia/Shanghai');
      $check = Carbon::parse($time)->setTimezone('Asia/Shanghai');

      return $check->between($start, $end);
    }
  @endphp
  <!-- EDIT DOCTOR -->
  <div class="modal fade" id="edidtScheduleCollapse" wire:ignore.self >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-light">
          <h5 class="modal-title" id="editScheduleCollapseLabel"><b>Editing Record Schedule...</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="close-edit-schedule">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="col">
            <div class="row">
              <div class="py-1 col field-container">
                <label for="schedule-day-of-week" class="form-label fw-bold">Day of Week</label>
                <select id="" name="" wire:model="targetScheduleDOW" class="form-control form-select" disabled>
                  <option value="monday">Monday</option>
                  <option value="tuesday">Tuesday</option>
                  <option value="wednesday">Wednesday</option>
                  <option value="thursday">Thursday</option>
                  <option value="friday">Friday</option>
                  <option value="saturday">Saturday</option>
                  <option value="sunday">Sunday</option>
                </select>
              </div>
              <div class="py-1 col field-container">
                <label for="schedule-day-of-week" class="form-label fw-bold">Day of Week</label>
                <select id="edit-schedule-day-of-week" wire:model="targetNewScheduleDOW" name="" class="form-control form-select">
                  <option value="monday" selected>Monday</option>
                  <option value="tuesday">Tuesday</option>
                  <option value="wednesday">Wednesday</option>
                  <option value="thursday">Thursday</option>
                  <option value="friday">Friday</option>
                  <option value="saturday">Saturday</option>
                  <option value="sunday">Sunday</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="py-1 col field-container">
                <div class="time-section row">
                  <div class="col">
                    <label for="hourSelect" class="form-label">Start Time</label>
                    <select id="" class="form-control form-select" disabled>
                      <option value="" selected >{{ $targetScheduleStartHr }}</option >
                    </select>
                  </div>
                  <div class="col">
                    <label for="minuteSelect" class="form-label">&nbsp;</label>
                    <select id="" class="form-control form-select" disabled>
                      <option value="" selected >{{ $targetScheduleStartMin }}</option >
                    </select>
                  </div>
                  <div class="col">
                    <label for="ampmSelect" class="form-label">&nbsp;</label>
                    <select id="" class="form-control form-select" disabled>
                      <option value="" selected >{{ strtoupper($targetScheduleStartAmpm) }}</option >
                    </select>
                  </div>
                </div>
              </div>
              <div class="py-1 col field-container">
                <div class="time-section row">
                  <div class="col">
                    <label for="hourSelect" class="form-label">Start Time</label>
                    <select id="edit-schedule-start-time-hr" wire:model="targetNewScheduleStartHr" class="form-control form-select">
                      <option value="00">00</option>
                      <option value="01">01</option>
                      <option value="02">02</option>
                      <option value="03">03</option>
                      <option value="04">04</option>
                      <option value="05">05</option>
                      <option value="06">06</option>
                      <option value="07">07</option>
                      <option value="08">08</option>
                      <option value="09">09</option>
                      <option value="10">10</option>
                      <option value="11">11</option>
                      <option value="12">12</option>
                    </select>
                  </div>
                  <div class="col">
                    <label for="minuteSelect" class="form-label">&nbsp;</label>
                    <select id="edit-schedule-start-time-mn" wire:model="targetNewScheduleStartMin" class="form-control form-select">
                      <option value="00">00</option>
                      <option value="15">15</option>
                      <option value="30">30</option>
                      <option value="45">45</option>
                    </select>
                  </div>
                  <div class="col">
                    <label for="ampmSelect" class="form-label">&nbsp;</label>
                    <select id="edit-schedule-start-time-ampm" wire:model="targetNewScheduleStartAmpm" class="form-control form-select">
                      <option value="AM">AM</option>
                      <option value="PM">PM</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="py-1 col field-container">
                <div class="time-section row">
                  <div class="col">
                    <label for="hourSelect" class="form-label">End Time</label>
                    <select id="" class="form-control form-select" disabled>
                      <option value="" selected >{{ $targetScheduleEndHr }}</option >
                    </select>
                  </div>
                  <div class="col">
                    <label for="minuteSelect" class="form-label">&nbsp;</label>
                    <select id="" class="form-control form-select" disabled>
                      <option value="" selected >{{ $targetScheduleEndMin }}</option >
                    </select>
                  </div>
                  <div class="col">
                    <label for="ampmSelect" class="form-label">&nbsp;</label>
                    <select id="" class="form-control form-select" disabled>
                      <option value="" selected >{{ $targetScheduleEndAmpm }}</option >
                    </select>
                  </div>
                </div>
              </div>
              <div class="py-1 col field-container">
                <div class="time-section row">
                  <div class="col">
                    <label for="hourSelect" class="form-label">End Time</label>
                    <select id="hourSelect" wire:model="targetNewScheduleEndHr" class="form-control form-select">
                      <option value="00">00</option>
                      <option value="01">01</option>
                      <option value="02">02</option>
                      <option value="03">03</option>
                      <option value="04">04</option>
                      <option value="05">05</option>
                      <option value="06">06</option>
                      <option value="07">07</option>
                      <option value="08">08</option>
                      <option value="09">09</option>
                      <option value="10">10</option>
                      <option value="11">11</option>
                      <option value="12">12</option>
                    </select>
                  </div>
                  <div class="col">
                    <label for="minuteSelect" class="form-label">&nbsp;</label>
                    <select id="minuteSelect" wire:model="targetNewScheduleEndMin" class="form-control form-select">
                      <option value="00">00</option>
                      <option value="15">15</option>
                      <option value="30">30</option>
                      <option value="45">45</option>
                    </select>
                  </div>
                  <div class="col">
                    <label for="ampmSelect" class="form-label">&nbsp;</label>
                    <select id="ampmSelect" wire:model="targetNewScheduleEndAmpm" class="form-control form-select">
                      <option value="AM">AM</option>
                      <option value="PM">PM</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="py-1 col field-container">
                <div class="">
                  <label for="type" class="form-label">Type</label>
                  <select id="" class="form-control form-select" disabled>
                    <option value="" selected disabled>{{ $targetScheduleType }}</option>
                  </select>
                </div>
              </div>
              <div class="py-1 col field-container">
                <div class="">
                  <label for="type" class="form-label">Type</label>
                  <select id="calendar-type" wire:model="targetNewScheduleType" class="form-control form-select">
                    <option value="walk-in">walk-in</option>
                    <option value="appointment">appointment</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" class="close-edit-schedule" data-dismiss="modal" aria-label="Close">Close</button>
          <button type="button" class="btn btn-primary" id="edit-schedule-confirm">Save</button>
        </div>
      </div>
    </div>
  </div>
  <!-- SCHEDULE DOCTOR -->

  <div id="scheduleDoctorModal" class=" fade modal" wire:ignore.self style="overflow: auto">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-light">
          <h5 class="modal-title"><b>Schedule Doctor Record : <u>{{ $targetDoctorLastName . ', ' . $targetDoctorFirstName . ' ' . $targetDoctorSuffix . ' ' . $targetDoctorMiddleName }}</u></b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span >&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="mb-3 card">
            <div class="card-header h6" data-toggle="collapse" href="#weekly-schedule-collapse" role="button" aria-expanded="false" aria-controls="weekly-schedule-collapse">
              WEEKLY FIXED SCHEDULE
            </div>
            <div class="collapse" id="weekly-schedule-collapse" wire:ignore.self>
              <div class="p-0 card-body">
                @php
                  $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                  $groupedSchedules = [];

                  foreach ($targetSelectedSchedule as $schedule) {
                    $groupedSchedules[$schedule['day_of_week']][] = $schedule;
                  }

                  function formatTimeRange($startTime, $endTime) {
                    $start = date('g:ia', strtotime($startTime));
                    $end = date('g:ia', strtotime($endTime));

                    // If both have same am/pm, remove it from start time
                    if (substr($start, -2) === substr($end, -2)) {
                      $start = date('g:i', strtotime($startTime));
                      $end = date('g:ia', strtotime($endTime));
                    }

                    return $start . ' – ' . strtolower($end);
                  }
                @endphp
                <table class="table mb-0 col" id="schedule-table">
                  <thead>
                    <tr>
                      <th scope="col">Monday</th>
                      <th scope="col">Tuesday</th>
                      <th scope="col">Wednesday</th>
                      <th scope="col">Thursday</th>
                      <th scope="col">Friday</th>
                      <th scope="col">Saturday</th>
                      <th scope="col">Sunday</th>
                    </tr>
                  </thead>
                  <tbody wire:model.defer="targetSelectedSchedule">
                    @if (!empty($groupedSchedules))
                      @for ($i = 0; $i < max(array_map('count', $groupedSchedules)); $i++)
                        <tr>
                          @foreach ($days as $day)
                            <td class="flex flex-column">
                              @if (isset($groupedSchedules[$day]) && !empty($groupedSchedules[$day][$i]))
                                @php
                                  $schedule = $groupedSchedules[$day][$i];
                                  $colorClass = $schedule['visit_type'] === 'walk-in' ? 'badge badge-success' : 'badge badge-primary text-light';
                                @endphp
                                <div class="schedule-item" id="{{ $schedule['id'] }}">
                                  <div class="flex-row">
                                    <small>
                                      <span class="time-range">
                                        {{ formatTimeRange($schedule['start_time'], $schedule['end_time']) }}
                                      </span>
                                    </small>
                                  </div>
                                  <div class="flex-row m-0 p-1 {{ $colorClass }}">
                                    <small class="type">
                                      {{ ucfirst($schedule['visit_type']) }}
                                    </small>
                                  </div>
                                  <div class="flex-row p-0 m-0 mt-1">
                                    <button class="btn btn-link schedule-delete"
                                    data-value="{{ $schedule['id'] }}">Delete</button>
                                    <button class="btn btn-link schedule-edit"
                                    data-value="{{ $schedule['id'] }}">Edit</button>
                                  </div>
                                </div>
                              @endif
                            </td>
                          @endforeach
                        </tr>
                      @endfor
                    @endif
                  </tbody>
                </table>
                @if (empty($groupedSchedules))
                  <div class="flex-wrap text-center d-flex justify-content-center align-items-center">
                    <div class="my-2 text-muted">
                      No schedules available
                    </div>
                  </div>
                @endif
              </div>
              <div class="card-footer">
                <div class="btn-group" role="group">
                  <button data-bs-toggle="modal" type="button" class="btn btn-primary rounded-0 text-light font-weight-bold" wire:click="setCreateSchedule">
                    <img src="{{ asset('assets/icon/calendar-add.svg') }}" width="25" alt="set">
                    ADD
                  </button>
                  <button id="clear-all-schedule" type="button" class="btn btn-secondary rounded-0 text-dark font-weight-bold">
                    <img src="{{ asset('assets/icon/calendar-del.svg') }}" width="20" alt="set">
                    CLEAR ALL
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="card" >
            <div class="card-header h6" data-toggle="collapse" href="#weekly-schedule-busy-collapse" role="button" aria-expanded="false" aria-controls="weekly-schedule-busy-collapse">
              DECLARED BUSY / DAY OFF
            </div>
            <div class="collapse" id="weekly-schedule-busy-collapse" wire:ignore.self>
              <div class="" style="">
                <div class="d-flex">
                  @php
                  @endphp
                  @if(count($targetSelectedBusySchedule) > 0)
                    @foreach($targetSelectedBusySchedule as $schedule)
                    <div class="m-2"><span class="p-3 badge badge-secondary d-inline-block">{{ \Carbon\Carbon::parse($schedule['start_datetime'])->format('l, M j, Y') }} - {{ \Carbon\Carbon::parse($schedule['end_datetime'])->format('l, M j, Y') }}</span></div>                    @endforeach
                  @endif
                </div>

                @if(count($targetSelectedBusySchedule) == 0)
                <div class="flex-wrap text-center d-flex justify-content-center align-items-center">
                  <div class="my-2 text-muted">
                    No busy schedules found for this doctor.
                  </div>
                </div>
                @endif
              </div>
              <div class="card-footer">
                <div class="btn-group" role="group">
                  <button data-bs-toggle="modal" type="button" class="btn btn-primary rounded-0 text-light font-weight-bold" wire:click="setCreateScheduleBusy">
                    <img src="{{ asset('assets/icon/calendar-busy.svg') }}" width="25" alt="set">
                    ADD
                  </button>
                  <button id="clear-all-schedule-busy" type="button" class="btn btn-secondary rounded-0 text-dark font-weight-bold">
                    <img src="{{ asset('assets/icon/calendar-del.svg') }}" width="20" alt="set">
                    CLEAR ALL
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="calendar-cancel" data-dismiss="modal" aria-label="Close">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div id="calendarDoctorModal" class="modal fade" wire:ignore.self style="overflow: auto">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-light">
          <h5 class="modal-title"><b>Calendar Doctor Record : <u>{{ $targetDoctorLastName . ', ' . $targetDoctorFirstName . ' ' . $targetDoctorSuffix . ' ' . $targetDoctorMiddleName }}</u></b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span >&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="mb-3 card">
            <div class="card-header h6">Official Availability Calendar</div>
            <div class="p-0 card-body">

            <h2 class="text-center">{{ Carbon::parse($currentDate)->setTimezone('Asia/Shanghai')->format('F Y') }}</h2>

            <div class="form-group">
              <div class="flex-row btn-group d-flex" data-toggle="buttons">
                <button class="btn btn-outline-primary" wire:click="prevMonth">PREV</button>
                <button class="btn btn-outline-primary" wire:click="nextMonth">NEXT</button>
              </div>
            </div>

            <div wire:loading>
              <div class="progress position-relative" style="
              position: fixed !important;
              top: 0;
              left: 0;
              width: 100vw;
              height: 100vh;
              background-color: rgba(255,255,255,0.8); /* Optional: semi-transparent background */
              z-index: 9999;
              transition: opacity 0.3s ease;
              margin: 0;
              border-radius: 0;
              display: flex;
              justify-content: center;
              align-items: center;
              ">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-info"
                 role="progressbar"
                 aria-valuenow="100"
                 aria-valuemin="0"
                 aria-valuemax="100"
                 style="
                  width: 80%;
                  height: 20px;
                  border-radius: 2px;
                 ">
                </div>
              </div>
            </div>

            <table class="table mb-0 col table-bordered" id="schedule-table" wire:model.defer="availableSlots">
              <thead>
                <tr>
                  @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                    <th scope="col">{{ $day }}</th>
                  @endforeach
                </tr>
              </thead>
              <tbody>
                @php
                  $startOfMonth = Carbon::parse($currentDate)->setTimezone('Asia/Shanghai')->startOfMonth();
                  $endOfMonth = Carbon::parse($currentDate)->setTimezone('Asia/Shanghai')->endOfMonth();
                  $currentDay = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY);
                  $endDay = $endOfMonth->copy()->endOfWeek(Carbon::SATURDAY);

                  $weeklySlots = $targetSelectedSchedule ?? [];

                  $specificDateSlots = $targetSelectedBusySchedule ?? [];
                @endphp

                @while($currentDay <= $endDay)
                  <tr>
                    @for($i = 0; $i < 7; $i++)
                      @php
                        $isCurrentMonth = $currentDay->month === now()->month;
                        $dayNumber = $currentDay->day;
                        $dayOfWeek = strtolower($currentDay->format('l'));
                        $currentDateFormatted = $currentDay->format('Y-m-d');

                        $dayWeeklySlots = array_filter($weeklySlots, function($slot) use ($dayOfWeek) {
                          return $slot['day_of_week'] === $dayOfWeek;
                        });
                        $daySpecificSlots = array_filter($specificDateSlots, function($slot) use ($currentDay) {
                          $slotDate = Carbon::parse($slot['start_datetime'])->setTimezone('Asia/Shanghai')->startOfDay();
                          return $slotDate->equalTo($currentDay->copy()->startOfDay());
                        });
                      @endphp

                      <td class="{{ $isCurrentMonth ? '' : 'text-muted' }}" style="height: 100px; vertical-align: top;">
                        <div class="d-flex justify-content-between">
                            <span>{{ $dayNumber }}</span>
                            @if($currentDay->eq(now()))
                                <span class="badge bg-primary text-light">Today</span>
                            @endif
                        </div>

                        @if($isCurrentMonth)

                        @endif
                        <div class="mt-1">
                          @foreach($dayWeeklySlots as $slotWeekly)
                            @php
                              // Parse weekly slots with the current day's date
                              $weeklyStart = Carbon::parse($currentDateFormatted . ' ' . $slotWeekly['start_time'])->setTimezone('Asia/Shanghai');
                              $weeklyEnd = Carbon::parse($currentDateFormatted . ' ' . $slotWeekly['end_time'])->setTimezone('Asia/Shanghai');
                              $weeklyStartTime = $weeklyStart->format('h:i A');
                              $weeklyEndTime = $weeklyEnd->format('h:i A');

                              // Collect all conflicting specific slots (DO NOT FILTER BY CURRENT DAY)
                              $conflicts = [];
                              foreach($specificDateSlots as $slotSpecific) {
                                $specificStart = Carbon::parse($slotSpecific['start_datetime'])->setTimezone('Asia/Shanghai');
                                $specificEnd = Carbon::parse($slotSpecific['end_datetime'])->setTimezone('Asia/Shanghai');

                                // Check if the busy slot overlaps with the current day's weekly slot
                                // Case 1: Busy slot starts before today and ends after today (covers whole day)
                                // Case 2: Busy slot starts today and ends later
                                // Case 3: Busy slot started earlier and ends today
                                if (
                                  ($specificStart <= $weeklyEnd && $specificEnd >= $weeklyStart)
                                ) {
                                  // Calculate the actual overlapping period
                                  $conflictStart = max($specificStart, $weeklyStart);
                                  $conflictEnd = min($specificEnd, $weeklyEnd);

                                  $conflicts[] = [
                                    'start' => $conflictStart,
                                    'end' => $conflictEnd,
                                    'type' => $slotSpecific['visit_type'] ?? $slotWeekly['visit_type']
                                  ];
                                }
                              }

                              // Sort conflicts by start time
                              usort($conflicts, function($a, $b) {
                                return $a['start'] <=> $b['start'];
                              });

                              // Calculate available slots between conflicts
                              $availableSlots = [];
                              $currentStart = $weeklyStart;

                              foreach ($conflicts as $conflict) {
                                if ($currentStart < $conflict['start']) {
                                  $availableSlots[] = [
                                    'start' => $currentStart,
                                    'end' => $conflict['start']
                                  ];
                                }
                                $currentStart = max($currentStart, $conflict['end']);
                              }

                              // Add remaining time after last conflict
                              if ($currentStart < $weeklyEnd) {
                                $availableSlots[] = [
                                  'start' => $currentStart,
                                  'end' => $weeklyEnd
                                ];
                              }
                            @endphp

                            {{-- Display available slots --}}
                            @if(empty($conflicts))
                              <div class="p-1 mb-1 text-white rounded small bg-success">
                                {{ $weeklyStartTime }} - {{ $weeklyEndTime }}
                                <br>
                                <small>Available</small>
                              </div>
                            @else
                              @foreach($availableSlots as $available)
                                <div class="p-1 mb-1 text-white rounded small bg-success">
                                  {{ $available['start']->format('h:i A') }} - {{ $available['end']->format('h:i A') }}
                                  <br>
                                  <small>Available</small>
                                </div>
                              @endforeach
                            @endif

                            {{-- Display conflict slots --}}
                            @foreach($conflicts as $conflict)
                              <div class="p-1 mb-1 text-white rounded small bg-danger">
                                {{ $conflict['start']->format('h:i A') }} - {{ $conflict['end']->format('h:i A') }}
                                <br>
                                <small>{{ $conflict['type'] }}</small>
                              </div>
                            @endforeach
                          @endforeach
                        </div>
                      </td>

                      @php $currentDay->addDay(); @endphp
                    @endfor
                  </tr>
                @endwhile
              </tbody>
            </table>
            </div>
            <div class="card-footer"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="calendar-cancel" data-dismiss="modal" aria-label="Close">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div id="createDoctorModal" class="z-0 modal fade" tabindex="-1" role="dialog" aria-labelledby="createDoctorModalTitle" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-light">
          <h5 class="modal-title"><b>Adding Doctor Record</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit.prevent="proceedCreate">
          <div class="modal-body">
              <div class="container">
                <div class="p-0 m-0 row">
                  <div class="col field-container">
                    <label for="create-first-name">First Name</label>
                    <input id="create-first-name" type="text" placeholder="N/A"  class="form-control" wire:model.defer="newDoctorFirstName">
                    <small class="form-text text-muted">At least 6 characters</small>
                    @error('newDoctorFirstName') <div class="alert alert-warning">{{ $message }}</div> @enderror
                  </div>
                  <div class="col field-container">
                    <label for="create-last-name">Last Name</label>
                    <input id="create-last-name" type="text" placeholder="N/A"  class="form-control" wire:model.defer="newDoctorLastName">
                    <small class="form-text text-muted">At least 6 characters</small>
                    @error('newDoctorLastName') <div class="alert alert-warning">{{ $message }}</div> @enderror
                  </div>
                  <div class="col field-container">
                    <label for="create-middle-name">Middle Name</label>
                    <input id="create-middle-name" type="text" placeholder="N/A"  class="form-control" wire:model.defer="newDoctorMiddleName">
                  </div>
                  <div class="col-2 field-container">
                    <label for="create-suffix">Suffix</label>
                    <input id="create-suffix" type="text" placeholder="N/A"  class="form-control" wire:model.defer="newDoctorSuffix">
                  </div>
                </div>
                <div class="p-0 m-0 row">
                  <div class="col field-container">
                    <label for="create-code-name">Clinic Code Name</label>
                    <input id="create-code-name" type="text" placeholder="N/A"  class="form-control" wire:model.defer="newClinicCodeName">
                    <small class="form-text text-muted">Ex. MAB XXX</small>
                  </div>
                  <div class="col field-container">
                    <label for="create-contact-number">Contact Number</label>
                    <input id="create-contact-number" type="text" placeholder="N/A"  class="form-control" wire:model.defer="newContactNumber">
                    <small class="form-text text-muted">Ex. 09XX-XXX-XXXX</small>
                  </div>
                  <div class="col field-container">
                    <label for="create-datebirth">Date of Birth</label>
                    <input id="create-datebirth" type="date" class="form-control" wire:model.defer="newDoctorBirthdate">
                  </div>
                  <div class="col-2 field-container">
                    <div class="form-check">
                      <br>
                      <input id="create-active" type="checkbox" class="form-check-input" wire:model.defer="newActive">
                      <label for="create-active">Active</label>
                    </div>
                  </div>
                </div>
                <div class="p-0 m-0 row">
                  <div class="py-1 col field-container">
                    <label for="create-master-specialization" class="form-label fw-bold">Specialization</label>
                    <select id="create-master-specialization" name="" wire:model="newMasterSpecializationId" class="form-control form-select">
                      <option value="" selected>N/A</option>
                      @foreach($master_specializations as $master_specialization)
                        <option value="{{ $master_specialization->id }}">{{ $master_specialization->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col field-container">
                    <label for="create-modal-profile" class="form-label">Profile Picture</label>
                    <br>
                    <input type="file" class="p-1 form-control" id="create-modal-profile" wire:model.defer="file" wire:loading.attr="disabled">
                    <img src="{{ asset('assets/avatar/' . $newDoctorImagePath) }}" width="60" alt="">
                  </div>
                </div>

                <div class="p-0 m-0 row d-flex justify-content-between">
                  <div class="col field-container">
                    <div class="p-0 m-0 row">
                      <div class="p-0 col">
                        <label for="">Search HMO</label>
                        <input id="" type="text" placeholder="N/A"  class="form-control" wire:model.defer="newSearchHMOName">
                      </div>
                    </div>
                    <div class="p-1 row">
                      @livewire('admin.doctor.hmo-new', [
                          'newSelectedHMOArray' => $newSelectedHMOArray,
                          'newSearchHMOName' => $newSearchHMOName
                        ],
                      key('hmo-new-'.md5($newSearchHMOName . json_encode($newSelectedHMOArray))))
                    </div>
                  </div>
                  <div class="col field-container">
                    <div class="p-0 m-0 row">
                      <div class="p-0 col">
                        <label for="">Search Sub-Specialization</label>
                        <input id="" type="text" placeholder="N/A"  class="form-control" wire:model.defer="newSearchSubSpecializationName">
                      </div>
                    </div>
                    <div class="p-1 row">
                      @livewire('admin.doctor.sub-specialization-new', [
                          'newSelectedSubSpecializationArray' => $newSelectedSubSpecializationArray,
                          'newSearchSubSpecializationName' => $newSearchSubSpecializationName
                        ],
                      key('sub-specialization-new-'.md5($newSearchSubSpecializationName . json_encode($newSelectedSubSpecializationArray))))
                    </div>
                  </div>
                </div>

                <div class="p-0 m-0 row">
                  <div class="col">
                    <div class="p-0 m-0 row">
                      <div class="col">
                        <label for="create-sub-specialization" class="form-label fw-bold">HMO</label>
                        <div class="selected-items-container">
                          @php
                            $filteredHmos = collect($hmos)->filter(function ($record) use ($newSelectedHMOArray) {
                              return in_array($record->id, $newSelectedHMOArray);
                            });
                          @endphp
                          @forelse($filteredHmos as $record)
                            <div class="selected-item badge bg-primary bg-opacity-10 text-light btn"
                                wire:click="removeSelectedHMOId({{ $record->id }})">
                              {{ $record->name }}
                              &nbsp;&nbsp;&nbsp;&nbsp;
                              <div
                                class="text-light"
                              >X</div>
                            </div>
                          @empty
                            <span class="text-muted">No HMO selected</span>
                          @endforelse
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col">
                    <div class="p-0 m-0 row">
                      <div class="col">
                        <label for="create-sub-specialization" class="form-label fw-bold">Sub Specialization</label>
                        <div class="selected-items-container">
                          @php
                            $filteredSubSpecializations = collect($sub_specializations)->filter(function ($record) use ($newSelectedSubSpecializationArray) {
                              return in_array($record->id, $newSelectedSubSpecializationArray);
                            });
                          @endphp
                          @forelse($filteredSubSpecializations as $record)
                            <div class="selected-item badge bg-primary bg-opacity-10 text-light btn"
                                wire:click="removeSelectedSubSpecializationId({{ $record->id }})">
                              {{ $record->name }}
                              &nbsp;&nbsp;&nbsp;&nbsp;
                              <div
                                class=" text-light"
                              >X</div>
                            </div>
                          @empty
                            <span class="text-muted">No Sub Specialization selected</span>
                          @endforelse
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="create-cancel" data-dismiss="modal" aria-label="Close">Close</button>
            <button type="submit" class="btn btn-primary" id="">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div id="deleteDoctorModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteDoctorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-light">
          <h5 class="modal-title"><b>Deleting Doctor Record</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>
            Are you sure to delete <b><u>{{ $targetDoctorLastName . ', ' . $targetDoctorFirstName }}</u></b>?
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          <button id="delete-confirmed" type="button" class="btn btn-primary">Yes</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal"></div>

  <div class="modal fade" id="deleteAllScheduleCollapse" wire:ignore.self >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-light">
          <h5 class="modal-title" id="deleteAllScheduleCollapseLabel"><b>Clearing All Record Schedule...</b></h5>
          <button type="button" class="close" data-dismiss="modal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="close-delete-all-schedule">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          Are you sure to clear all schedule of <u><b>{{
            $targetDoctorLastName . ', ' .
            $targetDoctorFirstName . ' ' .
            $targetDoctorMiddleName . ' ' .
            $targetDoctorSuffix
           }}</b></u>?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" class="close-delete-all-schedule" data-dismiss="modal" aria-label="Close">Close</button>
          <button type="button" class="btn btn-primary" id="clear-all-schedule-confirm">Confirm</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal"></div>

  <div class="modal fade" id="deleteAllScheduleBusyCollapse" wire:ignore.self >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-light">
          <h5 class="modal-title" id="deleteAllScheduleBusyCollapseLabel"><b>Clearing All Busy Record Schedule...</b></h5>
          <button type="button" class="close" data-dismiss="modal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="close-delete-all-schedule">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          Are you sure to clear all busy schedule of <u><b>{{
            $targetDoctorLastName . ', ' .
            $targetDoctorFirstName . ' ' .
            $targetDoctorMiddleName . ' ' .
            $targetDoctorSuffix
           }}</b></u>?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" class="" data-dismiss="modal" aria-label="Close">Close</button>
          <button type="button" class="btn btn-primary" id="clear-all-schedule-busy-confirm">Confirm</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal"></div>

  <div class="modal fade" id="createScheduleCollapse" wire:ignore.self >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-light">
          <h5 class="modal-title" id="createScheduleCollapseLabel"><b>Creating Record Schedule...</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="close-create-schedule">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="p-0 m-0 col">
            <div class="p-0 py-1 m-0 row field-container">
              <label for="schedule-day-of-week" class="form-label fw-bold">Day of Week</label>
              <select id="create-schedule-day-of-week" wire:model="targetNewScheduleDOW" name="" class="form-control form-select">
                <option value="monday" selected>Monday</option>
                <option value="tuesday">Tuesday</option>
                <option value="wednesday">Wednesday</option>
                <option value="thursday">Thursday</option>
                <option value="friday">Friday</option>
                <option value="saturday">Saturday</option>
                <option value="sunday">Sunday</option>
                <option value="weekends">Weekends</option>
                <option value="weekdays">Weekdays</option>
                  <option value="everyday">Everyday</option>
              </select>
            </div>
            <div class="p-0 py-1 m-0 row field-container">
              <div class="time-section row">
                <div class="col">
                  <label for="hourSelect" class="form-label">Start Time</label>
                  <select id="create-schedule-start-time-hr" wire:model="targetNewScheduleStartHr" class="form-control form-select">
                    <option value="00">00</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                  </select>
                </div>
                <div class="col">
                  <label for="minuteSelect" class="form-label">&nbsp;</label>
                  <select id="create-schedule-start-time-mn" wire:model="targetNewScheduleStartMin" class="form-control form-select">
                    <option value="00">00</option>
                    <option value="15">15</option>
                    <option value="30">30</option>
                    <option value="45">45</option>
                  </select>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="form-label fw-bold"></label>
                    <div class="flex-row btn-group btn-group-toggle d-flex" data-toggle="buttons">
                      <label class="btn btn-outline-primary {{ $targetNewScheduleStartAmpm === 'AM' ? 'active' : '' }}">
                        <input
                          class="form-check-input"
                          type="radio"
                          name="hmo"
                          id="AM"
                          value="AM"
                          wire:model="targetNewScheduleStartAmpm"
                          autocomplete="off"
                        />
                        AM
                      </label>
                      <label class="btn btn-outline-primary {{ $targetNewScheduleStartAmpm === 'PM' ? 'active' : '' }}">
                        <input
                          class="form-check-input"
                          type="radio"
                          name="hmo"
                          id="PM"
                          value="PM"
                          wire:model="targetNewScheduleStartAmpm"
                          autocomplete="off"
                        />
                        PM
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="p-0 py-1 m-0 row field-container">
              <div class="time-section row">
                <div class="col">
                  <label for="hourSelect" class="form-label">End Time</label>
                  <select id="hourSelect" wire:model="targetNewScheduleEndHr" class="form-control form-select">
                    <option value="00">00</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                  </select>
                </div>
                <div class="col">
                  <label for="minuteSelect" class="form-label">&nbsp;</label>
                  <select id="minuteSelect" wire:model="targetNewScheduleEndMin" class="form-control form-select">
                    <option value="00">00</option>
                    <option value="15">15</option>
                    <option value="30">30</option>
                    <option value="45">45</option>
                  </select>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="form-label fw-bold"></label>
                    <div class="flex-row btn-group btn-group-toggle d-flex" data-toggle="buttons">
                      <label class="btn btn-outline-primary {{ $targetNewScheduleEndAmpm === 'AM' ? 'active' : '' }}">
                        <input
                          class="form-check-input"
                          type="radio"
                          name="hmo"
                          id="AM"
                          value="AM"
                          wire:model="targetNewScheduleEndAmpm"
                          autocomplete="off"targetNewScheduleEndAmpm
                        />
                        AM
                      </label>
                      <label class="btn btn-outline-primary {{ $targetNewScheduleEndAmpm === 'PM' ? 'active' : '' }}">
                        <input
                          class="form-check-input"
                          type="radio"
                          name="hmo"
                          id="PM"
                          value="PM"
                          wire:model="targetNewScheduleEndAmpm"
                          autocomplete="off"
                        />
                        PM
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="type" class="form-label">Type</label>
              <div class="flex-row btn-group btn-group-toggle d-flex" data-toggle="buttons">
                <label class="btn btn-outline-primary {{ $targetNewScheduleType === 'walk-in' ? 'active' : '' }}">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="hmo"
                      id="walk-in"
                      value="walk-in"
                      wire:model="targetNewScheduleType"
                      autocomplete="off"
                    />
                    Walk-in
                  </label>
                <label class="btn btn-outline-primary {{ $targetNewScheduleType === 'appointment' ? 'active' : '' }}">
                  <input
                    class="form-check-input"
                    type="radio"
                    name="hmo"
                    id="appointment"
                    value="appointment"
                    wire:model="targetNewScheduleType"
                    autocomplete="off"
                  />
                  Appointment
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" class="close-create-schedule" data-dismiss="modal" aria-label="Close">Close</button>
          <button type="button" class="btn btn-primary" id="create-schedule-confirm">Save</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal"></div>

  <div class="modal fade" id="deleteScheduleCollapse" wire:ignore.self >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-light">
          <h5 class="modal-title" id="deleteScheduleCollapseLabel"><b>Deleting Record Schedule...</b></h5>
          <button type="button" class="close" data-dismiss="modal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="close-delete-schedule">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Are you sure to delete? <br>
          <ul><u>
            <li>
              {{ date('h:i A', strtotime($targetScheduleStart)) . ' - ' .
              date('h:i A', strtotime($targetScheduleEnd)) }}
            </li>
            <li>
              {{ strtoupper($targetScheduleType) }}

            </li>
            <li>
              {{ strtoupper($targetScheduleDOW) }}
            </li>
          </u></ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" class="close-delete-schedule" data-dismiss="modal" aria-label="Close">Close</button>
          <button type="button" class="btn btn-primary" id="delete-schedule-confirm">Confirm</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal"></div>

  <div class="modal fade" id="createScheduleBusyCollapse" wire:ignore.self >
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-light">
          <h5 class="modal-title" id="createScheduleBusyCollapseLabel"><b>Creating Busy Schedule...</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="close-create-schedule">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="mb-1 form-group">
            <label class="mt-3 form-label fw-bold">Day</label>
            <div class="flex-row btn-group btn-group-toggle d-flex" data-toggle="buttons">
              <label class="btn btn-outline-primary {{ $targetNewScheduleBusyDateSelect === 'today' ? 'active' : '' }}">
                <input
                  class="form-check-input"
                  type="radio"
                  name="hmo"
                  id="self-pay"
                  value="today"
                  wire:model="targetNewScheduleBusyDateSelect"
                  autocomplete="off"
                />
                Today
              </label>
              <label class="btn btn-outline-primary {{ $targetNewScheduleBusyDateSelect === 'tomorrow' ? 'active' : '' }}">
                <input
                  class="form-check-input"
                  type="radio"
                  name="hmo"
                  id="self-pay"
                  value="tomorrow"
                  wire:model="targetNewScheduleBusyDateSelect"
                  autocomplete="off"
                />
                Tomorrow
              </label>
              <label class="btn btn-outline-primary {{ $targetNewScheduleBusyDateSelect === 'specifyRange' ? 'active' : '' }}"
                href="#specific-date-range"
                data-toggle="collapse"
              aria-expanded="{{ $targetNewScheduleBusyDateSelect === 'specifyRange' ? 'true' : 'false' }}"
              aria-controls="specific-date-range"
              >
                <input
                  class="form-check-input"
                  type="radio"
                  name="hmo"
                  id="self-pay"
                  value="specifyRange"
                  wire:model="targetNewScheduleBusyDateSelect"
                  autocomplete="off"
                />
                Specific Range
              </label>
            </div>
          </div>

          <div id="specific-date-range" class="collapse {{ $targetNewScheduleBusyDateSelect === 'specifyRange' ? 'show' : '' }}">
            <div class="mx-2 row">
              <div class="p-0 input-group col">
                <div class="input-group-append">
                  <span class="input-group-text" id="">Start</span>
                </div>
                <input class="form-control" type="date" class="form-control" wire:model="targetNewScheduleBusySpecifyDateStart" name="" placeholder="" min="{{ now()->format('Y-m-d') }}">
              </div>

              <div class="p-0 input-group col">
                <div class="input-group-append">
                  <span class="input-group-text" id="">End</span>
                </div>
                <input class="form-control" type="date" class="form-control" wire:model="targetNewScheduleBusySpecifyDateEnd" name="" placeholder="" min="{{ now()->format('Y-m-d') }}">
              </div>
            </div>
          </div>

          <div class="mb-1 form-group">
            <label class="mt-3 form-label fw-bold">Time</label>
            <div class="flex-row btn-group btn-group-toggle d-flex" data-toggle="buttons">
              <label class="btn btn-outline-primary {{ $targetNewScheduleBusyTimeSelect === 'whole_day' ? 'active' : '' }}">
                <input
                  class="form-check-input"
                  type="radio"
                  name="hmo"
                  id="self-pay"
                  value="whole_day"
                  wire:model="targetNewScheduleBusyTimeSelect"
                  autocomplete="off"
                />
                Whole Day
              </label>
              <label class="btn btn-outline-primary {{ $targetNewScheduleBusyTimeSelect === 'specific' ? 'active' : '' }}"
                href="#specific-time-range"
                data-toggle="collapse"
              aria-expanded="{{ $targetNewScheduleBusyTimeSelect === 'specific' ? 'true' : 'false' }}"
              aria-controls="specific-time-range"
              >
                <input
                  class="form-check-input"
                  type="radio"
                  name="hmo"
                  id="self-pay"
                  value="specific"
                  wire:model="targetNewScheduleBusyTimeSelect"
                  autocomplete="off"
                />
                Specific Range
              </label>
            </div>
            <div id="specific-time-range" class="collapse {{ $targetNewScheduleBusyTimeSelect === 'specific' ? 'show' : '' }}">
              <div class="mx-2 row">
                <div class="p-0 m-1 input-group col">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Start</span>
                  </div>
                  <input type="time" step="900" class="form-control" wire:model="targetNewScheduleBusySpecifyTimeStart" placeholder="">
                </div>

                <div class="p-0 m-1 input-group col">
                  <div class="input-group-prepend">
                    <span class="input-group-text">End</span>
                  </div>
                  <input type="time" step="900" class="form-control" wire:model="targetNewScheduleBusySpecifyTimeEnd" placeholder="">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" class="close-create-schedule" data-dismiss="modal" aria-label="Close">Close</button>
          <button type="button" class="btn btn-primary" id="create-schedule-busy-confirm">Save</button>
        </div>
      </div>
    </div>
  </div>

  <div id="editDoctorModal" class="z-0 modal fade" tabindex="-1" role="dialog" aria-labelledby="editDoctorModalTitle" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-light">
          <h5 class="modal-title"><b>Editing Doctor Record</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit.prevent="proceedEdit">
          <div class="modal-body">
              <div class="container">
                <div class="p-0 m-0 row">
                  <div class="col field-container">
                    <label for="edit-first-name">First Name</label>
                    <input id="edit-first-name" type="text" placeholder="N/A"  class="form-control" wire:model.defer="targetDoctorFirstName">
                    @error('targetDoctorFirstName') <div class="alert alert-warning">{{ $message }}</div> @enderror
                  </div>
                  <div class="col field-container">
                    <label for="edit-last-name">Last Name</label>
                    <input id="edit-last-name" type="text" placeholder="N/A"  class="form-control" wire:model.defer="targetDoctorLastName">
                    @error('targetDoctorLastName') <div class="alert alert-warning">{{ $message }}</div> @enderror
                  </div>
                  <div class="col field-container">
                    <label for="edit-middle-name">Middle Name</label>
                    <input id="edit-middle-name" type="text" placeholder="N/A"  class="form-control" wire:model.defer="targetDoctorMiddleName">
                  </div>
                  <div class="col-2 field-container">
                    <label for="edit-suffix">Suffix</label>
                    <input id="edit-suffix" type="text" placeholder="N/A"  class="form-control" wire:model.defer="targetDoctorSuffix">
                  </div>
                </div>
                <div class="p-0 m-0 row">
                  <div class="col field-container">
                    <label for="edit-code-name">Clinic Code Name</label>
                    <input id="edit-code-name" type="text" placeholder="N/A"  class="form-control" wire:model.defer="targetClinicCodeName">
                  </div>
                  <div class="col field-container">
                    <label for="edit-contact-number">Contact Number</label>
                    <input id="edit-contact-number" type="text" placeholder="N/A"  class="form-control" wire:model.defer="targetContactNumber">
                  </div>
                  <div class="col field-container">
                    <label for="edit-datebirth">Date of Birth</label>
                    <input id="edit-datebirth" type="date" class="form-control" wire:model.defer="targetDoctorBirthdate">
                  </div>
                  <div class="col-2 field-container">
                    <div class="form-check">
                      <br>
                      <input id="edit-active" type="checkbox" class="form-check-input" wire:model.defer="targetActive">
                      <label for="edit-active">Active</label>
                    </div>
                  </div>
                </div>
                <div class="p-0 m-0 row">
                  <div class="py-1 col field-container">
                    <label for="edit-master-specialization" class="form-label fw-bold">Specialization</label>
                    <select id="edit-master-specialization" name="" wire:model="targetMasterSpecializationId" class="form-control form-select">
                      <option value="" selected>N/A</option>
                      @foreach($master_specializations as $master_specialization)
                        <option value="{{ $master_specialization->id }}">{{ $master_specialization->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col field-container">
                    <label for="edit-modal-profile" class="form-label">Profile Picture</label>
                    <br>
                    <div class="custom-file">
                      <input type="file" class="p-1 form-control custom-file-input" id="edit-modal-profile" wire:model.defer="file" wire:loading.attr="disabled">
                      <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                    <img src="{{ asset('assets/avatar/' . $targetDoctorImagePath) }}" width="60" alt="">
                  </div>
                </div>
                <div class="p-0 m-0 row d-flex justify-content-between">
                  <div class="col field-container">
                    <div class="p-0 m-0 row">
                      <div class="p-0 col">
                        <label for="">Search HMO</label>
                        <input id="" type="text" placeholder="Search HMO of..."  class="form-control" wire:model="targetSearchHMOName">
                      </div>
                    </div>
                    <div class="p-1 row" id="targetEditTable" wire:model="targetSelectedHMOArray">
                      @livewire('admin.doctor.hmo-edit', [
                        'targetSearchHMOName' => $targetSearchHMOName,
                        'targetSelectedHMOArray' => $targetSelectedHMOArray
                        ], key('hmo-edit-' . md5($targetSearchHMOName . json_encode($targetSelectedHMOArray))))
                    </div>
                  </div>
                  <div class="col field-container">
                    <div class="p-0 m-0 row">
                      <div class="p-0 col">
                        <label for="">Search Sub-Specialization</label>
                        <input id="" type="text" placeholder="Search Sub-Specialization of..."  class="form-control" wire:model="targetSearchSubSpecializationName">
                      </div>
                    </div>
                    <div class="p-1 row" wire:model="targetSelectedSubSpecializationArray">
                      @livewire('admin.doctor.sub-specialization-edit', [
                        'targetSearchSubSpecializationName' => $targetSearchSubSpecializationName,
                        'targetSelectedSubSpecializationArray' => $targetSelectedSubSpecializationArray
                       ],

                        key('sub-specialization-edit-'.md5($targetSearchSubSpecializationName . json_encode($targetSelectedSubSpecializationArray))))
                    </div>
                  </div>
                </div>
                <div class="p-0 m-0 row">
                  <div class="col">
                    <div class="p-0 m-0 row">
                      <div class="col">
                        <label for="edit-sub-specialization" class="form-label fw-bold">HMO</label>
                        <div class="selected-items-container">
                          @php
                            $filteredHmos = collect($hmos)->filter(function ($record) use ($targetSelectedHMOArray) {
                              return in_array($record->id, $targetSelectedHMOArray);
                            });
                          @endphp
                          @forelse($filteredHmos as $record)
                            <div class="selected-item badge bg-primary bg-opacity-10 text-light btn"
                                wire:click="removeTargetSelectedHMOId({{ $record->id }})">
                              {{ $record->name }}
                              &nbsp;&nbsp;&nbsp;&nbsp;
                              <div
                                class=" text-light"
                              >X</div>
                            </div>
                          @empty
                            <span class="text-muted">No HMO selected</span>
                          @endforelse
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col">
                    <div class="p-0 m-0 row">
                      <div class="col">
                        <label for="edit-sub-specialization" class="form-label fw-bold">Sub Specialization</label>
                        <div class="selected-items-container">
                          @php
                            $filteredSubSpecialization = collect($sub_specializations)->filter(function ($record) use ($targetSelectedSubSpecializationArray) {
                              return in_array($record->id, $targetSelectedSubSpecializationArray);
                            });
                          @endphp
                          @forelse($filteredSubSpecialization as $record)
                            <div class="selected-item badge bg-primary bg-opacity-10 text-light btn"
                                wire:click="removeTargetSelectedSubSpecializationId({{ $record->id }})">
                              {{ $record->name }}
                              &nbsp;&nbsp;&nbsp;&nbsp;
                              <div
                                class="text-light"
                              >X</div>
                            </div>
                          @empty
                            <span class="text-muted">No Sub Specialization selected</span>
                          @endforelse
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
            <button type="submit" class="btn btn-primary" id="">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <!--

  NOT MODAL START

  -->

  <div class="my-1 btn-group btn-group-toggle" data-toggle="buttons">
    <div class="btn-group" role="group" aria-label="Basic example">
      <button type="button" class="btn btn-primary text-light" wire:click="setSelectedDoctor('0', 'create')">
        <img src="{{ asset("assets/icon/add-person.svg") }}" width="20" alt="">
        ADD DOCTOR
      </button>
    </div>
  </div>

  <form class="mb-3 input-group" wire:submit.prevent="setFilters">
    <input type="text" class="form-control" placeholder="Search Last Name of...  " aria-label="Search" wire:model="searchLastName">
    <button class="btn btn-primary" type="submit" wire:click="setFilters">
      <img src="{{ asset('assets/icon/search.svg') }}" width="30" alt="">
      Search
    </button>
    <button class="btn btn-outline-secondary text-dark" type="button" data-toggle="collapse" data-target="#filter-options" aria-expanded="true" aria-controls="filter-options">
      <img src="{{ asset('assets/icon/funnel.svg') }}" width="30" alt="">
      Filters
    </button>
  </form>

  <div class="border collapse" id="filter-options" wire:ignore.self>
    <form id="" action="" class="" wire:submit.prevent="setFilters">
      <!-- Name and Specialization Filters -->
      <div class="p-3 option-section border-bottom">

        <div class="mt-2 row">
          <div class="mb-2 col-md-4">
            <label for="firstName" class="form-label fw-bold">First Name</label>
            <input id="searchFirstName" type="text" class="form-control" placeholder="Any" wire:model="searchFirstName">
          </div>
          <div class="mb-2 col-md-4">
            <label for="" class="form-label fw-bold">Specialization</label>
            <select wire:model="searchSpecializationNameSelect" class="form-control form-select">
              <option value="" selected>Any</option>
              @foreach($master_specializations as $master_specialization)
                <option value="{{ $master_specialization->name }}">{{ $master_specialization->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-2 col-md-4">
            <label for="" class="form-label fw-bold">Sub Specialization</label>
            <select wire:model="searchSubSpecializationNameSelect" class="form-control form-select">
              <option value="" selected>Any</option>
              @foreach($sub_specializations as $sub_specialization)
                <option value="{{ $sub_specialization->name }}">{{ $sub_specialization->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>

      <!-- Active Status Radio Buttons -->
      <div class="p-3 option-section border-bottom">
        <div class="form-group">
          <label class="mb-1 form-check-label d-block fw-bold">Active Only</label>
          <div class="form-check">
            <div class="form-check form-check-inline">
              <input id="activeAny" class="form-check-input" type="radio" name="searchActiveOnly" wire:model="searchActiveOnly" value="any">
              <label class="form-check-label" for="activeAny">Any</label>
            </div>
            <div class="form-check form-check-inline">
              <input id="activeYes" class="form-check-input" type="radio" name="searchActiveOnly" wire:model="searchActiveOnly" value="yes">
              <label class="form-check-label" for="activeYes">Yes</label>
            </div>
            <div class="form-check form-check-inline">
              <input id="activeNo" class="form-check-input" type="radio" name="searchActiveOnly" wire:model="searchActiveOnly" value="no">
              <label class="form-check-label" for="activeNo">No</label>
            </div>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="p-3 d-flex justify-content-end border-top">
        <button type="button" class="btn btn-sm btn-outline-secondary me-2 text-dark" wire:click="resetFilters">
          <i class="bi bi-arrow-counterclockwise"></i> CLEAR
        </button>
        <button type="submit" class="btn btn-sm btn-primary" wire:click="setFilters">
          <i class="bi bi-search"></i> APPLY FILTERS
        </button>
      </div>
    </form>
  </div>
  <div class="m-1 shadow-lg card">
    <div class="text-white card-header bg-dark">
      SEARCH RESULTS
    </div>
    <div class="card-body table-responsive-lg" style="">
      <div class="p-0 m-0 d-flex justify-content-center">
        {{ $doctors->links() }}
      </div>
      <table class="table border shadow-sm table-bordered">
        <thead class="bg-white sticky-top">
          <tr>
            <th class="font-weight-bold sortable" wire:click="sortBy('last_name')">Info <img src="{{ asset('assets/icon/arrow-updown.svg') }}" width="15" alt="sort"></th>
            <th class="font-weight-bold">Specialization</th>
            <th class="font-weight-bold">Active</th>
            <th class="font-weight-bold sortable" wire:click="sortBy('created_at')">Created At <img src="{{ asset('assets/icon/arrow-updown.svg') }}" width="15" alt="sort"></th>
            <th class="font-weight-bold sortable" wire:click="sortBy('updated_at')">Last Update <img src="{{ asset('assets/icon/arrow-updown.svg') }}" width="15" alt="sort"></th>
            <th class="font-weight-bold">Manage</th>
          </tr>
        </thead>
        <tbody>
          @forelse($doctors as $doctor)
            <tr>
              <td>
                <div class="card">
                  <div class="row no-gutters">
                    <div class="col-4 d-flex align-items-center justify-content-center">
                      <img
                        src="{{ asset('assets/avatar/' . (string) $doctor->image_path) }}"
                        class="img-thumbnail img-fluid"
                        style="max-width: 100%; height: auto;"
                        alt="Doctor Image"
                      />
                    </div>
                    <div class="col-8">
                      <div class="card-body">
                        <h5 class="mb-0 card-title">{{ $doctor->last_name }}, {{ $doctor->first_name }} {{ $doctor->suffix }} {{ $doctor->middle_name }} ({{ \Carbon\Carbon::parse($doctor->date_of_birth)->setTimezone('Asia/Manila')->age }})</h5>
                        <div class="mb-0 card-text">
                          <img src="{{ asset('assets/icon/building.svg') }}" width="10px" alt="Clinic">
                          <span>{{ $doctor->dc_code_name }}</span>
                        </div>
                        <div class="mb-0 card-text">
                          <img src="{{ asset('assets/icon/phone.svg') }}" width="15px" alt="Phone">
                          <span>{{ $doctor->contact_number }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
              <td>
                @php
                  $specializations = json_decode($doctor->specializations, true);
                @endphp

                @foreach($specializations as $spec)
                  <span @if($spec['type'] === 'master') class="font-weight-bold" @endif>
                    {{ $spec['name'] }}
                  </span>
                  @if($spec['type'] === 'master')
                    <span class="badge badge-warning">
                      Master
                    </span>
                  @endif
                  @if(!$loop->last)
                    &#8226<br>
                  @endif
                @endforeach
              </td>
              <td>
                <span class="badge badge-pill {{ $doctor->is_active ? 'badge-success' : 'badge-danger' }}">
                  {{ $doctor->is_active ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td>{{ \Carbon\Carbon::parse($doctor->created_at, 'Asia/Singapore')->setTimezone('Asia/Shanghai')->diffForHumans() }}</td>
              <td>{{ \Carbon\Carbon::parse($doctor->updated_at, 'Asia/Singapore')->setTimezone('Asia/Shanghai')->diffForHumans() }}</td>
              <td>
                <button
                class="m-1 btn btn-primary"
                wire:click="setSelectedDoctor('{{ $doctor->id }}', 'edit')"
                >
                  <img src="{{ asset('assets/icon/pencil.svg') }}" width="20" >
                </button>
                <button
                class="m-1 btn btn-primary"
                wire:click="setSelectedDoctor('{{ $doctor->id }}', 'delete')"
                >
                  <img src="{{ asset('assets/icon/bin.svg') }}" width="20" >
                </button>
                <button
                class="m-1 btn btn-primary"
                wire:click="setSelectedDoctor('{{ $doctor->id }}', 'schedule')"
                >
                  <img src="{{ asset('assets/icon/schedule.svg') }}" width="20" >
                </button>
                <button
                class="m-1 btn btn-primary"
                wire:click="setSelectedDoctor('{{ $doctor->id }}', 'calendar')"
                >
                  <img src="{{ asset('assets/icon/calendar.svg') }}" width="20" >
                </button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="13" class="text-center">No records found.</td>
            </tr>
          @endforelse
          @if  ($doctors->currentPage() === $doctors->lastPage())
            <tr>
              <td colspan="13" class="text-center"><b><u>end of results</u></b></td>
            </tr>
          @endif
        </tbody>
      </table>
      <div class="p-0 m-0 d-flex justify-content-center" wire:model="">
        {{ $doctors->links() }}
      </div>
    </div>
  </div>
</div>
<script>

  (function() {
    let initialized = false;
    let modalInProcess = false;
    let previewModalTimeout = null;
    let mutationObservers = [];

    function initializeScript() {
      if (initialized) return;
      initialized = true;

      cleanupObservers();


      window.livewire.on('deleteModal', () => {
        clearTimeout(previewModalTimeout);
        previewModalTimeout = setTimeout(() => {
          $('#doctor #deleteDoctorModal').modal('show');
        }, 0);
      });

      window.livewire.on('calendarModal', () => {
        clearTimeout(previewModalTimeout);
        previewModalTimeout = setTimeout(() => {
          $('#doctor #calendarDoctorModal').modal('show');
        }, 0);
      });
      window.livewire.on('scheduleModal', () => {
        clearTimeout(previewModalTimeout);
        previewModalTimeout = setTimeout(() => {
          $('#doctor #scheduleDoctorModal').modal('show');
        }, 0);
      });

      window.livewire.on('editModal', (data) => {
        clearTimeout(previewModalTimeout);
        previewModalTimeout = setTimeout(() => {
          $('#doctor #editDoctorModal').modal('show');
          disableOnUploadEditmodal();
        }, 0);
      });

      window.livewire.on('createModal', () => {
        clearTimeout(previewModalTimeout);
        previewModalTimeout = setTimeout(() => {
          $('#doctor #createDoctorModal').modal('show');
          disableOnUploadCreatemodal();
        }, 0);
      });

      window.livewire.on('createSchedule', () => {
        clearTimeout(previewModalTimeout);
        previewModalTimeout = setTimeout(() => {
          $('#doctor #createScheduleCollapse').modal('show');
          disableOnUploadCreatemodal();
        }, 0);
      });

      window.livewire.on('createScheduleBusy', () => {
        clearTimeout(previewModalTimeout);
        previewModalTimeout = setTimeout(() => {
          $('#doctor #createScheduleBusyCollapse').modal('show');
          disableOnUploadCreatemodal();
        }, 0);
      });

      $(document).on('click', '.schedule-delete', function() {
        const value = $(this).data('value');
        $('#deleteScheduleCollapse').modal('toggle');
        window.livewire.emit('setSelectedSchedule', {
          mode: 'delete',
          id: value
        });
      });




      $(document).on('click', '#toggle-filter-options', function() {
        $('#filter-options').collapse('toggle');
      });

      $(document).on('click', '.schedule-edit', function() {
        const value = $(this).data('value');
        $('#editScheduleCollapse').modal('toggle');
        window.livewire.emit('setSelectedSchedule', {
          mode: 'edit',
          id: value
        });
      });

      $(document).on('click', '#doctor #create-schedule-confirm', function() {
        window.livewire.emit('proceedCreateSchedule');
        $('#doctor #createScheduleCollapse').modal('hide');
      });
      $(document).on('click', '#doctor #create-schedule-busy-confirm', function() {
        window.livewire.emit('proceedCreateScheduleBusy');
        $('#doctor #createScheduleBusyCollapse').modal('hide');
      });

      $(document).on('click', '#doctor #delete-confirmed', function() {
        window.livewire.emit('proceedDelete');
        $('#doctor #deleteDoctorModal').modal('hide');
      });

      $(document).on('click', '#doctor #clear-all-schedule', function() {
        $('#doctor #deleteAllScheduleCollapse').modal('show');
      });

      $(document).on('click', '#doctor #clear-all-schedule-busy', function() {
        $('#doctor #deleteAllScheduleBusyCollapse').modal('show');
      });


      $(document).on('click', '#doctor #clear-all-schedule-busy-confirm', function() {
        window.livewire.emit('proceedDeleteAllScheduleBusy');
        $('#doctor #deleteAllScheduleBusyCollapse').modal('hide');
      });
      $(document).on('click', '#doctor #clear-all-schedule-confirm', function() {
        window.livewire.emit('proceedDeleteAllSchedule');
        $('#doctor #deleteAllScheduleCollapse').modal('hide');
      });

      $(document).on('click', '#doctor #edit-schedule-confirm', function() {
        window.livewire.emit('proceedEditSchedule');
        $('#doctor #editScheduleCollapse').modal('hide');
      });

      $(document).on('click', '#doctor .close-delete-schedule', function() {
        $('#deleteScheduleCollapse').modal('toggle');
      });

      $(document).on('click', '#doctor #delete-schedule-confirm', function() {
        window.livewire.emit('proceedDeleteSchedule');
        $('#doctor #deleteScheduleCollapse').modal('hide');
      });

      $(document).on('click', '#doctor #edit-confirmed', function() {
        window.livewire.emit('proceedEdit', {
          firstName: $('#doctor #edit-first-name').val(),
          lastName: $('#doctor #edit-last-name').val(),
          dateBirth: $('#doctor #edit-datebirth').val(),
          middleName: $('#doctor #edit-middle-name').val(),
          suffix: $('#doctor #edit-suffix').val(),
          contactNumber: $('#doctor #edit-contact-number').val(),
          codeName: $('#doctor #edit-code-name').val(),
          active: $('#doctor #edit-active').prop('checked')
        });
        $('#doctor #editDoctorModal').modal('hide');
      });

      $(document).on('click', '#doctor #create-confirmed', function() {
        window.livewire.emit('proceedCreate', {
          firstName: $('#doctor #create-first-name').val(),
          lastName: $('#doctor #create-last-name').val(),
          dateBirth: $('#doctor #create-datebirth').val(),
          middleName: $('#doctor #create-middle-name').val(),
          suffix: $('#doctor #create-suffix').val(),
          contactNumber: $('#doctor #create-contact-number').val(),
          codeName: $('#doctor #create-code-name').val(),
          active: $('#doctor #create-active').prop('checked')
        });
        $('#doctor #createDoctorModal').modal('hide');
      });
    }

    function disableOnUploadEditmodal() {
      const saveButton = document.getElementById('edit-confirmed');
      const fileUpload = document.getElementById('edit-modal-profile');

      if (!saveButton || !fileUpload) return;

      function updateButtonState() {
        saveButton.disabled = fileUpload.disabled;
      }

      updateButtonState();

      const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
          if (mutation.attributeName === 'disabled') {
            updateButtonState();
          }
        });
      });

      observer.observe(fileUpload, {
        attributes: true
      });

      mutationObservers.push(observer);
    }

    function disableOnUploadCreatemodal() {
      const saveButtonCreate = document.getElementById('create-confirmed');
      const fileUploadCreate = document.getElementById('create-modal-profile');

      if (!saveButtonCreate || !fileUploadCreate) return;

      function updateButtonState() {
        saveButtonCreate.disabled = fileUploadCreate.disabled;
      }

      updateButtonState();

      const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
          if (mutation.attributeName === 'disabled') {
            updateButtonState();
          }
        });
      });

      observer.observe(fileUploadCreate, {
        attributes: true
      });

      mutationObservers.push(observer);
    }

    function cleanupObservers() {
      mutationObservers.forEach(observer => {
        observer.disconnect();
      });
      mutationObservers = [];
    }

    function handleLivewireLoad() {
      if (window.Livewire) {
        initializeScript();
      }

      document.addEventListener('livewire:load', function() {
        initializeScript();
      });

      document.addEventListener('livewire:update', function() {
        if (!initialized && window.Livewire) {
          initializeScript();
        }
      });

      document.addEventListener('turbo:before-cache', cleanupObservers);
      document.addEventListener('livewire:navigating', cleanupObservers);
    }

    if (document.readyState === 'complete') {
      handleLivewireLoad();
    } else {
      document.addEventListener('DOMContentLoaded', handleLivewireLoad);
      window.addEventListener('load', handleLivewireLoad);
    }
  })();
</script>
