<?php

use Livewire\Component;
use App\Models\BudgetPlan;
use App\Models\PurchaseOrder;

new class extends Component
{
    public $modal = false;

    public $name;
    public $start_date;
    public $end_date;
    public $budget;

    protected function rules()
    {
        return [
            'name' => 'required|unique:budget_plans,name',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'budget' => 'required|numeric|min:1',
        ];
    }

    public function save()
    {
        $this->validate();

        BudgetPlan::create([
            'name' => $this->name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'budget' => $this->budget,
        ]);

        $this->reset();
        $this->modal = false;
    }

    public function getPlansProperty()
    {
        return BudgetPlan::orderByDesc('start_date')->get();
    }
};
?>

<div class="p-6 space-y-6">

    <x-header title="Budget Plan Mingguan" subtitle="Kontrol anggaran dan realisasi belanja" separator>
        <x-slot:actions>
            <x-button label="Buat Budget Plan" class="btn-primary" wire:click="$set('modal', true)" />
        </x-slot:actions>
    </x-header>

    {{-- LIST BUDGET PLAN --}}
    <div class="space-y-4">
        @foreach($this->plans as $plan)
            <div class="border rounded-lg p-4 shadow">

                <div class="flex justify-between items-center">
                    <div>
                        <div class="text-lg font-semibold">
                            {{ $plan->name }}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $plan->start_date }} s/d {{ $plan->end_date }}
                        </div>
                        <div class="text-sm">
                            Budget: Rp {{ number_format($plan->budget, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                {{-- PO DALAM RANGE --}}
                <div class="mt-4 border-t pt-4">
                    <div class="font-semibold mb-2">Purchase Orders</div>

                    @php
                        $pos = \App\Models\PurchaseOrder::whereBetween('date', [
                            $plan->start_date,
                            $plan->end_date
                        ])->orderBy('date')->get();
                    @endphp

                    @forelse($pos as $po)
                        <div class="flex justify-between py-2 border-b text-sm">
                            <div>
                                {{ $po->date }}
                                @if($po->menu)
                                    — {{ $po->menu->name }}
                                @endif
                            </div>
                            <div class="capitalize">
                                {{ $po->status }}
                            </div>
                        </div>
                    @empty
                        <div class="text-gray-400 text-sm">
                            Belum ada PO
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>


    <x-modal wire:model="modal" title="Buat Budget Plan" separator>

        <div class="space-y-4">
    
            <x-input
                label="Nama Budget Plan"
                wire:model="name"
                placeholder="Minggu 28 (M28)"
            />
    
            <x-datetime
                label="Tanggal Mulai"
                wire:model="start_date"
                type="date"
            />
    
            <x-datetime
                label="Tanggal Selesai"
                wire:model="end_date"
                type="date"
            />
    
            <x-input
                label="Total Budget"
                wire:model="budget"
                type="number"
                prefix="Rp"
            />
    
        </div>
    
        <x-slot:actions>
            <x-button label="Batal" @click="$wire.modal = false" />
            <x-button label="Simpan" class="btn-primary" wire:click="save" />
        </x-slot:actions>
    
    </x-modal>
    

</div>
