<?php

use Livewire\Component;
use App\Models\BudgetPlan;
use App\Models\PurchaseOrder;

new class extends Component
{
    public $breadcrumbs;

    public $modal = false;
    public $poModal = false;

    public $name;
    public $start_date;
    public $end_date;
    public $budget;
    public $po;

    public function mount()
    {
        $this->breadcrumbs = [
            ['icon' => 'o-home', 'link' => route('dashboard')],
            ['label' => 'Rencana Belanja']
        ];
    }

    protected function rules()
    {
        return [
            'name' => 'required|unique:budget_plans,name',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'budget' => 'required|numeric|min:1',
        ];
    }

    public function openPoModal($id)
    {
        $this->po = PurchaseOrder::with(['items.material', 'menu'])->findOrFail($id);
        $this->poModal = true;
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

        $this->reset(['name','start_date','end_date','budget']);
        $this->modal = false;
    }

    public function getPlansProperty()
    {
        return BudgetPlan::query()
            ->withCount('purchaseOrders')
            ->withSum('purchaseOrders as total_used', 'grand_total')
            ->orderByDesc('start_date')
            ->get()
            ->each(function ($p) {
                $p->remaining_budget = $p->budget - ($p->total_used ?? 0);
            });
    }


};
?>

<div>
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

    <x-modal wire:model="poModal" title="Detail Purchase Order" separator>
        @if($po)
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Material</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->po->items as $item)
                    <tr>
                        <td>{{ $item->material->name }}</td>
                        <td>{{ $item->qty_display }}</td>
                        <td>{{ 'Rp ' . number_format($item->price , 0, ',', '.') }}</td>
                        <td>{{ 'Rp ' . number_format($item->price * $item->qty_display, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="text-right font-bold">Grand Total:</td>
                        <td class="font-bold">{{ 'Rp ' . number_format($this->po->grand_total, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-modal>

    <x-breadcrumbs :items="$breadcrumbs" />

    <x-header title="Rencana Pembelanjaan" subtitle="Daftar pemesanan" separator>
        <x-slot:actions>
            <x-button label="Buat Budget Plan" class="btn-primary" wire:click="$set('modal', true)" />
            <x-button label="Buat Pemesanan" link="{{ route('purchase.create') }}" class="btn-primary" />
        </x-slot:actions>
    </x-header>

    {{-- LIST BUDGET PLAN --}}
    <div class="space-y-4">
        @foreach($this->plans as $plan)
            <div class="border rounded-lg p-4 shadow">
                <div class="flex items-center justify-between">
                    <div class="">
                        <div class="text-lg font-semibold">{{ $plan->name }}</div>
                        <div class="text-sm text-gray-500">
                            {{ $plan->start_date }} s/d {{ $plan->end_date }}
                        </div>
                    </div>
                    <div class="">
                        <x-button label="Lihat Detail" link="{{ route('purchase.po', $plan->id) }}" class="btn-dash" icon="o-eye" />
                    </div>
                </div>
            
                <div class="grid grid-cols-3 gap-4">
                    <x-stat
                        title="Budget"
                        description="Total alokasi"
                        :value="'Rp ' . number_format($plan->budget, 0, ',', '.')"
                        icon="o-banknotes"
                    />
            
                    <x-stat
                        title="Terpakai"
                        description="Akumulasi PO"
                        :value="'Rp ' . number_format($plan->total_used ?? 0, 0, ',', '.')"
                        icon="o-arrow-trending-up"
                    />
            
                    <x-stat
                        title="Sisa"
                        description="Budget tersisa"
                        :value="'Rp ' . number_format($plan->remaining_budget ?? $plan->budget, 0, ',', '.')"
                        icon="o-wallet"
                    />
                </div>
            
                <x-collapse separator>
                    <x-slot:heading>Daftar PO ({{ $plan->purchase_orders_count }})</x-slot:heading>
                    <x-slot:content>
                        @forelse($plan->purchaseOrders as $po)
                            <div class="flex items-center justify-between py-3 border-b text-sm">

                                {{-- Kiri: Tanggal + Menu --}}
                                <div class="space-y-1">
                                    <div class="font-semibold text-slate-700">
                                        {{ \Carbon\Carbon::parse($po->date)->translatedFormat('l, d F Y') }}
                                    </div>

                                    @if($po->menu)
                                        <div class="text-slate-500">
                                            Menu: {{ $po->menu->name }}
                                        </div>
                                    @endif
                                </div>

                                {{-- Tengah: Status + Total --}}
                                <div class="text-right space-y-1">
                                    <div class="capitalize text-xs px-2 py-1 rounded bg-slate-100 inline-block">
                                        {{ $po->status }}
                                    </div>

                                    <div class="font-bold text-emerald-600">
                                        Rp {{ number_format($po->grand_total, 0, ',', '.') }}
                                    </div>
                                </div>

                                {{-- Kanan: Aksi --}}
                                <div class="flex gap-2">
                                    {{-- Lihat (modal Livewire) --}}
                                    <x-button label="Lihat PO" icon="o-eye" wire:click="openPoModal({{ $po->id }})" />
                                    {{-- Edit --}}
                                    <x-button label="Edit" icon="o-pencil" link="{{ route('purchase.edit', $po->id) }}" />
                                </div>

                            </div>
                        @empty
                            <div class="py-4 text-center text-slate-400 text-sm">
                                Belum ada Purchase Order pada plan ini.
                            </div>
                        @endforelse

                    </x-slot:content>
                </x-collapse>
            </div>
        @endforeach
    </div>
</div>