<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div class="space-y-8">

    {{-- ===================== --}}
    {{-- MENU HARIAN --}}
    {{-- ===================== --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Menu Harian</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="border rounded-lg p-4">
                <h3 class="font-semibold text-lg">
                    Nasi Putih, Ayam Panggang, Sayur Bayam, Pisang, Susu
                </h3>
                <p class="text-sm text-gray-500 mt-2">
                    Tanggal: 16 Februari 2026
                </p>
            </div>

            <div class="border rounded-lg p-4">
                <p class="text-gray-500 text-sm">Standar Kalori</p>
                <h3 class="text-2xl font-bold mt-1 text-green-600">
                    650 kcal / Porsi
                </h3>
                <p class="text-xs text-gray-400 mt-1">
                    Standar nasional: 600–700 kcal
                </p>
            </div>

        </div>
    </div>



    {{-- ===================== --}}
    {{-- KOMPOSISI BAHAN --}}
    {{-- ===================== --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Komposisi Bahan</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Bahan</th>
                        <th class="p-3 text-left">Jumlah</th>
                        <th class="p-3 text-left">Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="p-3">Beras</td>
                        <td class="p-3">250</td>
                        <td class="p-3">kg</td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-3">Ayam</td>
                        <td class="p-3">180</td>
                        <td class="p-3">kg</td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-3">Bayam</td>
                        <td class="p-3">75</td>
                        <td class="p-3">kg</td>
                    </tr>
                    <tr>
                        <td class="p-3">Susu UHT</td>
                        <td class="p-3">2.450</td>
                        <td class="p-3">kotak</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>



    {{-- ===================== --}}
    {{-- JUMLAH PORSI --}}
    {{-- ===================== --}}
    <div>
        <h2 class="text-lg font-semibold mb-4">Jumlah Porsi</h2>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

            <div class="bg-blue-500 text-white p-5 rounded-xl shadow">
                <p class="text-sm opacity-80">Total Diproduksi</p>
                <h3 class="text-3xl font-bold mt-2">2.450</h3>
            </div>

            <div class="bg-green-500 text-white p-5 rounded-xl shadow">
                <p class="text-sm opacity-80">Terkirim</p>
                <h3 class="text-3xl font-bold mt-2">2.180</h3>
            </div>

            <div class="bg-red-500 text-white p-5 rounded-xl shadow">
                <p class="text-sm opacity-80">Sisa / Cadangan</p>
                <h3 class="text-3xl font-bold mt-2">270</h3>
            </div>

        </div>
    </div>



    {{-- ===================== --}}
    {{-- LOG PRODUKSI --}}
    {{-- ===================== --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Log Produksi</h2>

        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Tanggal</th>
                    <th class="p-3 text-left">Menu</th>
                    <th class="p-3 text-left">Total Porsi</th>
                    <th class="p-3 text-left">Kalori</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b">
                    <td class="p-3">16 Feb 2026</td>
                    <td class="p-3">Nasi, Ayam, Bayam</td>
                    <td class="p-3">2.450</td>
                    <td class="p-3 text-green-600 font-semibold">
                        650 kcal
                    </td>
                </tr>
                <tr class="border-b">
                    <td class="p-3">15 Feb 2026</td>
                    <td class="p-3">Nasi, Telur, Sayur</td>
                    <td class="p-3">2.380</td>
                    <td class="p-3 text-green-600 font-semibold">
                        630 kcal
                    </td>
                </tr>
                <tr>
                    <td class="p-3">14 Feb 2026</td>
                    <td class="p-3">Nasi, Ikan, Tahu</td>
                    <td class="p-3">2.510</td>
                    <td class="p-3 text-yellow-600 font-semibold">
                        590 kcal
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
