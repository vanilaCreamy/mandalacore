<?php

use Livewire\Component;
use App\Models\BudgetPlan;
use App\Models\PurchaseOrder;

new class extends Component
{
    public $breadcrumbs;
    public $po;

    public function mount($id)
    {
        $this->po = BudgetPlan::with('purchaseOrders')->findOrFail($id);

        $this->breadcrumbs = [
            ['icon' => 'o-home', 'link' => route('dashboard')],
            ['label' => 'Rencana Belanja', 'link' => route('purchase.index')],
            ['label' => 'Detail PO']
        ];
    }
};
?>

<div>
    <x-breadcrumbs :items="$breadcrumbs" />

    <x-header title="Purchase Order" subtitle="List of Purchase Orders">
        <x-slot:actions>
            <x-button link="{{ route('purchase.index') }}" class="btn-dash" icon="o-arrow-left" label="Kembali" />
            <a href="{{ route('purchase.print', $po->id) }}" target="_blank" class="btn btn-warning">
                <x-icon name="o-printer" />
                Print
            </a>
        </x-slot:actions>
    </x-header>

    @php
        $grandAll = 0;
        $rekap = [];
    @endphp

    @foreach ($po->purchaseOrders->groupBy('date') as $date => $purchaseOrders)

        <div class="mt-10">

            {{-- HEADER --}}
            <div class="text-center mb-4">
                <div class="font-bold text-lg">SPPG CIAMIS PANJALU KERTAMANDALA 2</div>
                <div class="font-semibold">PEMESANAN BAHAN BAKU</div>
                <div class="text-sm">Periode: {{ $po->start_date }} s/d {{ $po->end_date }}</div>
                <div class="text-sm font-semibold mt-1">Tanggal: {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</div>
            </div>

            {{-- TABEL PO HARIAN --}}
            <table class="w-full text-sm border border-slate-300">
                <thead class="bg-slate-100">
                    <tr class="text-center">
                        <th class="border p-2 w-10">No</th>
                        <th class="border p-2">Nama Bahan</th>
                        <th class="border p-2 w-24">Kuantitas</th>
                        <th class="border p-2 w-20">Satuan</th>
                        <th class="border p-2 w-28">Harga</th>
                        <th class="border p-2 w-32">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp

                    @foreach ($purchaseOrders as $order)
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="border p-2 text-center">{{ $no++ }}</td>
                                <td class="border p-2">{{ $item->material->name }}</td>
                                <td class="border p-2 text-center">{{ $item->qty_display }}</td>
                                <td class="border p-2 text-center">{{ $item->material->display_unit }}</td>
                                <td class="border p-2 text-right">Rp {{ number_format($item->price) }}</td>
                                <td class="border p-2 text-right">Rp {{ number_format($item->price * $item->qty_display) }}</td>
                            </tr>
                        @endforeach
                    @endforeach

                    {{-- GRAND TOTAL HARIAN --}}
                    <tr class="bg-slate-100 font-semibold">
                        <td colspan="5" class="border p-2 text-right">Grand Total Belanja Harian</td>
                        <td class="border p-2 text-right">
                            Rp {{ number_format($order->grand_total) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        @php
            $rekap[$date] = $order->grand_total;
            $grandAll += $order->grand_total;
        @endphp

    @endforeach

    {{-- REKAPITULASI --}}
    <div class="mt-12">
        <div class="text-center font-bold text-lg mb-3">REKAPITULASI BELANJA</div>

        <table class="w-full text-sm border border-slate-300">
            <thead class="bg-slate-100">
                <tr>
                    <th class="border p-2 w-48">Tanggal</th>
                    <th class="border p-2">Total Belanja</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rekap as $tgl => $total)
                    <tr>
                        <td class="border p-2">
                            {{ \Carbon\Carbon::parse($tgl)->translatedFormat('d F Y') }}
                        </td>
                        <td class="border p-2 text-right">
                            Rp {{ number_format($total) }}
                        </td>
                    </tr>
                @endforeach

                <tr class="bg-slate-200 font-bold">
                    <td class="border p-2 text-right">TOTAL KESELURUHAN</td>
                    <td class="border p-2 text-right">
                        Rp {{ number_format($grandAll) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>