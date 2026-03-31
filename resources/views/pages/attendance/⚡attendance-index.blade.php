<?php

use Livewire\Component;
use App\Models\Attendance;
use Carbon\Carbon;

new class extends Component
{
    public $breadcrumbs;
    public $events;

    public function mount()
    {
        $this->events = Attendance::where('user_id', Auth::id())
            ->get()
            ->map(fn ($event) => [
                'label' => $event->status->label(),
                'css'   => $event->status->color(), // e.g. bg-green-500 text-white
                'date'  => Carbon::parse($event->date)->format('Y-m-d'),           // YYYY-MM-DD
            ])->toArray();

        $this->breadcrumbs = [
            ['icon' => 'o-home', 'link' => route('dashboard')],
            ['label' => 'Absensi']
        ];
    }
};
?>

<div>
    <x-breadcrumbs :items="$breadcrumbs" />

    <!-- Header -->
    <x-header title="Rekap Absensi" separator />

    {{-- Calendar --}}
    <div id="calendar"></div>
</div>

<script>
    const events = JSON.parse(JSON.stringify($wire.events));
    console.log(events);
    window.initVanillaCalendar($wire.events);
</script>