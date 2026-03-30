<?php

use Livewire\Component;
use App\Models\User;
use App\Models\Attendance;
use App\Models\AttendanceLog;
use App\enum\AttendanceStatus;
use App\Services\AttendanceService;
use App\enum\AttendanceType;
use Carbon\Carbon;

new class extends Component
{
    public $breadcrumbs;
    public $selected_date;

    public $workers;
    public $selected_worker;
    public $attendance_modal;

    // attendance
    public $event_time;
    public $mode; // checkin / checkout / manual
    public $manual_check_in;
    public $manual_check_out;

    public function mount()
    {
        $today = Carbon::today();

        $this->selected_date = $today->toDateString();
        $this->date = $this->selected_date;

        // default waktu sekarang (dipakai saat buka modal)
        $this->event_time = now()->format('H:i');

        $this->loadWorkers();

        $this->breadcrumbs = [
            ['icon' => 'o-home', 'link' => route('dashboard')],
            ['label' => 'Presensi Relawan'],
        ];
    }

    public function loadWorkers()
    {
        $this->workers = User::whereIn('role', [
                'PERSIAPAN','PENGOLAHAN','PEMORSIAN','DISTRIBUSI','PENCUCIAN'
            ])
            ->with(['attendances' => function ($q) {
                $q->whereDate('date', $this->selected_date);
            }])
            ->orderBy('role')
            ->get();
    }

    public function open_attendance_modal($id)
    {
        $this->selected_worker = User::find($id);

        $attendance = Attendance::firstWhere([
            'user_id' => $id,
            'date' => $this->selected_date
        ]);

        $this->manual_check_in  = $attendance?->first_check_in?->format('H:i');
        $this->manual_check_out = $attendance?->last_check_out?->format('H:i');

        $this->attendance_modal = true;
    }

    public function quickCheckIn($userId)
    {
        $attendance = Attendance::firstOrCreate(
            ['user_id' => $userId, 'date' => $this->selected_date],
            ['recorded_by' => auth()->id()]
        );

        if (!$attendance->first_check_in) {
            $attendance->first_check_in = now();
            $attendance->calculate();
            $attendance->save();
        }

        $this->loadWorkers();
    }

    public function quickCheckOut($userId)
    {
        $attendance = Attendance::firstOrCreate(
            ['user_id' => $userId, 'date' => $this->selected_date],
            ['recorded_by' => auth()->id()]
        );

        $attendance->last_check_out = now();
        $attendance->calculate();
        $attendance->save();

        $this->loadWorkers();
    }

    public function updatedSelectedDate()
    {
        $this->loadWorkers();
    }

    public function markStatus($userId, $status)
    {
        $attendance = Attendance::firstOrCreate(
            [
                'user_id' => $userId,
                'date' => $this->selected_date
            ],
            [
                'recorded_by' => auth()->id()
            ]
        );

        // Kosongkan jam karena ini bukan kehadiran fisik
        $attendance->first_check_in = null;
        $attendance->last_check_out = null;
        $attendance->late_minutes = 0;
        $attendance->work_minutes = 0;

        $attendance->status = AttendanceStatus::from($status);

        $attendance->save();

        $this->loadWorkers();
    }

    public function resetAttendance($userId)
    {
        $attendance = Attendance::where([
            'user_id' => $userId,
            'date' => $this->selected_date
        ])->first();

        if (!$attendance) return;

        $attendance->first_check_in = null;
        $attendance->last_check_out = null;
        $attendance->late_minutes = 0;
        $attendance->work_minutes = 0;
        $attendance->status = null;

        $attendance->save();

        $this->loadWorkers();
    }


    public function save()
    {
        $attendance = Attendance::firstOrCreate(
            [
                'user_id' => $this->selected_worker->id,
                'date' => $this->selected_date
            ],
            [
                'recorded_by' => auth()->id()
            ]
        );

        if ($this->manual_check_in) {
            $attendance->first_check_in = Carbon::parse(
                $this->selected_date.' '.$this->manual_check_in
            );
        }

        if ($this->manual_check_out) {
            $attendance->last_check_out = Carbon::parse(
                $this->selected_date.' '.$this->manual_check_out
            );
        }

        $attendance->calculate();
        $attendance->save();

        $this->attendance_modal = false;
        $this->loadWorkers();
    }

};
?>

<div>
    <x-modal wire:model="attendance_modal" title="Koreksi Presensi Relawan" class="backdrop-blur">
        <x-form wire:submit.prevent="save">
    
            <div class="space-y-5">
    
                <x-input 
                    label="Relawan" 
                    :value="$selected_worker?->name" 
                    readonly
                />
    
                <div class="grid grid-cols-2 gap-4">
                    <x-datetime 
                        label="Jam Masuk"
                        type="time"
                        wire:model="manual_check_in"
                    />
    
                    <x-datetime 
                        label="Jam Pulang"
                        type="time"
                        wire:model="manual_check_out"
                    />
                </div>
    
                <div class="text-xs text-gray-500">
                    Tanggal presensi: <b>{{ \Carbon\Carbon::parse($selected_date)->format('d M Y') }}</b>
                </div>
    
            </div>
    
            <x-slot:actions>
                <x-button 
                    label="Simpan Perubahan" 
                    type="submit" 
                    class="btn-primary" 
                    spinner="save"
                />
            </x-slot:actions>
    
        </x-form>
    </x-modal>
    
    

    <x-breadcrumbs :items="$breadcrumbs" />

    <x-header title="Presensi Relawan" subtitle="Catat aktivitas kehadiran relawan" separator>
        <x-slot:actions>

        </x-slot:actions>
    </x-header>

    {{-- Input Tanggal --}}
    <x-datetime label="Pilih Tanggal" wire:model.live="selected_date" />

    <div class="mt-6">

        <h2 class="text-lg font-semibold">Daftar Relawan</h2>
        
        @foreach ($workers as $worker)
            <x-list-item :item="$worker">
                <x-slot:avatar>
                    @php
                        // $user = auth()->user();
                        $jpg = 'profile/' . $worker->id . '.jpg';
                        $png = 'profile/' . $worker->id . '.png';
                    @endphp

                    <img 
                    src="{{ 
                        Storage::disk('public')->exists($jpg) 
                            ? asset('storage/'.$jpg) 
                            : (Storage::disk('public')->exists($png) 
                                ? asset('storage/'.$png) 
                                : asset('images/ava-md.png')) 
                    }}" 
                    alt="Profile" 
                    height="50" 
                    width="50" 
                    class="rounded-2xl">
                </x-slot:avatar>

                <x-slot:value>
                    <div class="flex items-center gap-2">
                        <h3>{{ $worker->name }} -</h3>
                        <span class="text-sm font-light">
                            {{ $worker->role->label() }}
                        </span>
                    </div>
                </x-slot:value>
                
                @php $attendance = $worker->attendances->first(); @endphp

                <x-slot:sub-value>
                    @if ($attendance)
                        <div class="flex items-center gap-3 text-sm">
                            <x-badge value="{{ $attendance->status?->label() }}" class="badge-primary" />
                            <span>Masuk: {{ $attendance->first_check_in?->format('H:i') ?? '-' }}</span>
                            <span>Pulang: {{ $attendance->last_check_out?->format('H:i') ?? '-' }}</span>
                            <span>Kerja: {{ $attendance->work_minutes ?? 0 }} menit</span>
                        </div>
                    @else
                        <x-badge value="Belum Presensi" class="badge-error" />
                    @endif
                </x-slot:sub-value>

                <x-slot:actions>
                    <div class="flex gap-2">
                        @php $attendance = $worker->attendances->first(); @endphp

                        <x-button 
                            label="Masuk"
                            class="btn-success btn-sm"
                            :disabled="$attendance?->first_check_in"
                            wire:click="quickCheckIn({{ $worker->id }})"
                        />

                        <x-button 
                            label="Pulang"
                            class="btn-warning btn-sm"
                            :disabled="!$attendance?->first_check_in || $attendance?->last_check_out"
                            wire:click="quickCheckOut({{ $worker->id }})"
                        />

                        <x-dropdown label="Status" class="btn-primary btn-sm">
                            <div class="flex flex-col gap-2">
                                <x-button
                                    label="Izin"
                                    class="btn-info btn-sm"
                                    wire:click="markStatus({{ $worker->id }}, 'EXCUSED')"
                                />

                                <x-button
                                    label="Sakit"
                                    class="btn-secondary btn-sm"
                                    wire:click="markStatus({{ $worker->id }}, 'SICK')"
                                />

                                <x-button
                                    label="Alpha"
                                    class="btn-error btn-sm"
                                    wire:click="markStatus({{ $worker->id }}, 'ABSENT')"
                                />
                            </div>
                        </x-dropdown>

                        <x-button 
                            icon="o-pencil-square"
                            class="btn-ghost btn-sm"
                            wire:click="open_attendance_modal({{ $worker->id }}, 'manual')"
                        />

                        <x-button 
                            icon="o-arrow-path"
                            class="btn-ghost btn-sm text-red-500"
                            wire:click="resetAttendance({{ $worker->id }})"
                            wire:confirm="Yakin ingin menghapus presensi hari ini?"
                        />

                    </div>
                </x-slot:actions>
            </x-list-item>
        @endforeach
    </div>
</div>