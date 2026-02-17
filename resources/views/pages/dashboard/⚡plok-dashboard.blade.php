<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div class="space-y-8">

    {{-- ===================== --}}
    {{-- TOTAL ANGGARAN --}}
    {{-- ===================== --}}
    <div>
        <h2 class="text-xl font-semibold mb-4">Ringkasan Anggaran</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="bg-blue-600 text-white p-5 rounded-xl shadow">
                <p class="text-sm opacity-80">Total Anggaran Bulan Ini</p>
                <h3 class="text-2xl font-bold mt-2">Rp 150.000.000</h3>
            </div>

            <div class="bg-green-600 text-white p-5 rounded-xl shadow">
                <p class="text-sm opacity-80">Realisasi</p>
                <h3 class="text-2xl font-bold mt-2">Rp 132.500.000</h3>
            </div>

            <div class="bg-yellow-500 text-white p-5 rounded-xl shadow">
                <p class="text-sm opacity-80">Sisa Anggaran</p>
                <h3 class="text-2xl font-bold mt-2">Rp 17.500.000</h3>
            </div>

            <div class="bg-indigo-500 text-white p-5 rounded-xl shadow">
                <p class="text-sm opacity-80">Biaya per Porsi (Hari Ini)</p>
                <h3 class="text-2xl font-bold mt-2">Rp 4.450</h3>
            </div>

        </div>
    </div>



    {{-- ===================== --}}
    {{-- PENGELUARAN HARIAN --}}
    {{-- ===================== --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Pengeluaran Harian</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">

            <div class="border rounded-lg p-4">
                <p class="text-gray-500">Bahan Baku</p>
                <h3 class="text-xl font-bold mt-1">Rp 8.750.000</h3>
            </div>

            <div class="border rounded-lg p-4">
                <p class="text-gray-500">Operasional</p>
                <h3 class="text-xl font-bold mt-1">Rp 2.150.000</h3>
            </div>

            <div class="border rounded-lg p-4">
                <p class="text-gray-500">Transportasi</p>
                <h3 class="text-xl font-bold mt-1">Rp 950.000</h3>
            </div>

        </div>
    </div>



    {{-- ===================== --}}
    {{-- PEMBELIAN BAHAN --}}
    {{-- ===================== --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Pembelian Bahan</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Tanggal</th>
                        <th class="p-3 text-left">Supplier</th>
                        <th class="p-3 text-left">Item</th>
                        <th class="p-3 text-left">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="p-3">16 Feb 2026</td>
                        <td class="p-3">CV Sumber Pangan</td>
                        <td class="p-3">Beras 250 kg</td>
                        <td class="p-3">Rp 3.750.000</td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-3">16 Feb 2026</td>
                        <td class="p-3">PT Ayam Sejahtera</td>
                        <td class="p-3">Ayam 180 kg</td>
                        <td class="p-3">Rp 4.200.000</td>
                    </tr>
                    <tr>
                        <td class="p-3">15 Feb 2026</td>
                        <td class="p-3">UD Sayur Makmur</td>
                        <td class="p-3">Sayuran & Buah</td>
                        <td class="p-3">Rp 1.850.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>



    {{-- ===================== --}}
    {{-- RINGKASAN BIAYA PRODUKSI --}}
    {{-- ===================== --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Ringkasan Biaya Produksi Hari Ini</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">

            <div class="border rounded-lg p-4">
                <p class="text-gray-500">Total Produksi</p>
                <h3 class="text-xl font-bold mt-1">2.450 Porsi</h3>
            </div>

            <div class="border rounded-lg p-4">
                <p class="text-gray-500">Total Biaya</p>
                <h3 class="text-xl font-bold mt-1 text-red-600">
                    Rp 10.900.000
                </h3>
            </div>

        </div>

        <div class="mt-4 p-4 bg-gray-100 rounded-lg text-sm">
            <p>
                Perhitungan:
                <span class="font-semibold">
                    Rp 10.900.000 ÷ 2.450 Porsi = Rp 4.450 / Porsi
                </span>
            </p>
        </div>

    </div>

</div>
