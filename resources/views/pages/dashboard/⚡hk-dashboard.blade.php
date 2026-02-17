<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div class="space-y-8">

    {{-- ===================== --}}
    {{-- RINGKASAN PRODUKSI --}}
    {{-- ===================== --}}
    <div>
        <h2 class="text-xl font-semibold mb-4">Ringkasan Produksi Harian</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="bg-indigo-500 text-white p-5 rounded-xl shadow">
                <p class="text-sm opacity-80">Total Porsi Hari Ini</p>
                <h3 class="text-3xl font-bold mt-2">2.450</h3>
            </div>

            <div class="bg-green-500 text-white p-5 rounded-xl shadow">
                <p class="text-sm opacity-80">Sekolah Terkirim</p>
                <h3 class="text-3xl font-bold mt-2">18</h3>
            </div>

            <div class="bg-red-500 text-white p-5 rounded-xl shadow">
                <p class="text-sm opacity-80">Belum Terkirim</p>
                <h3 class="text-3xl font-bold mt-2">4</h3>
            </div>

            <div class="bg-yellow-500 text-white p-5 rounded-xl shadow">
                <p class="text-sm opacity-80">Menu Hari Ini</p>
                <h3 class="text-lg font-semibold mt-2">
                    Nasi, Ayam, Sayur, Buah
                </h3>
            </div>

        </div>
    </div>



    {{-- ===================== --}}
    {{-- STATUS DISTRIBUSI SEKOLAH --}}
    {{-- ===================== --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Status Distribusi Sekolah</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Sekolah</th>
                        <th class="p-3 text-left">Jumlah Porsi</th>
                        <th class="p-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="p-3">SDN 01 Kertamandala</td>
                        <td class="p-3">320</td>
                        <td class="p-3">
                            <span class="px-2 py-1 bg-green-100 text-green-600 rounded text-xs">
                                Sudah Terkirim
                            </span>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-3">SMPN 02 Kertamandala</td>
                        <td class="p-3">410</td>
                        <td class="p-3">
                            <span class="px-2 py-1 bg-green-100 text-green-600 rounded text-xs">
                                Sudah Terkirim
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-3">SDIT Harapan Bangsa</td>
                        <td class="p-3">275</td>
                        <td class="p-3">
                            <span class="px-2 py-1 bg-red-100 text-red-600 rounded text-xs">
                                Belum Terkirim
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>



    {{-- ===================== --}}
    {{-- LAPORAN KEUANGAN RINGKAS --}}
    {{-- ===================== --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Laporan Keuangan (Ringkas)</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">

            <div class="border rounded-lg p-4">
                <p class="text-gray-500">Biaya Bahan Hari Ini</p>
                <h3 class="text-xl font-bold mt-1">Rp 8.750.000</h3>
            </div>

            <div class="border rounded-lg p-4">
                <p class="text-gray-500">Biaya Operasional</p>
                <h3 class="text-xl font-bold mt-1">Rp 2.150.000</h3>
            </div>

            <div class="border rounded-lg p-4">
                <p class="text-gray-500">Total Pengeluaran</p>
                <h3 class="text-xl font-bold mt-1 text-red-600">
                    Rp 10.900.000
                </h3>
            </div>

        </div>
    </div>



    {{-- ===================== --}}
    {{-- LAPORAN GIZI --}}
    {{-- ===================== --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Laporan Gizi Menu Hari Ini</h2>

        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Komponen</th>
                    <th class="p-3 text-left">Nilai</th>
                    <th class="p-3 text-left">Standar</th>
                    <th class="p-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b">
                    <td class="p-3">Kalori</td>
                    <td class="p-3">650 kcal</td>
                    <td class="p-3">600–700 kcal</td>
                    <td class="p-3 text-green-600 font-semibold">
                        Sesuai
                    </td>
                </tr>
                <tr class="border-b">
                    <td class="p-3">Protein</td>
                    <td class="p-3">28 g</td>
                    <td class="p-3">20–30 g</td>
                    <td class="p-3 text-green-600 font-semibold">
                        Sesuai
                    </td>
                </tr>
                <tr>
                    <td class="p-3">Lemak</td>
                    <td class="p-3">18 g</td>
                    <td class="p-3">15–25 g</td>
                    <td class="p-3 text-green-600 font-semibold">
                        Sesuai
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
