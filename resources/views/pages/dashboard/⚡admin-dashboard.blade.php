<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div class="space-y-8">

    {{-- ===================== --}}
    {{-- STATISTIK KESELURUHAN --}}
    {{-- ===================== --}}
    <div>
        <h2 class="text-xl font-semibold mb-4">Statistik Keseluruhan</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="bg-blue-500 text-white p-5 rounded-xl shadow">
                <p class="text-sm opacity-80">Total User</p>
                <h3 class="text-3xl font-bold mt-2">125</h3>
            </div>

            <div class="bg-green-500 text-white p-5 rounded-xl shadow">
                <p class="text-sm opacity-80">Sekolah Penerima</p>
                <h3 class="text-3xl font-bold mt-2">32</h3>
            </div>

            <div class="bg-yellow-500 text-white p-5 rounded-xl shadow">
                <p class="text-sm opacity-80">Produksi Hari Ini</p>
                <h3 class="text-3xl font-bold mt-2">2.450 Porsi</h3>
            </div>

            <div class="bg-red-500 text-white p-5 rounded-xl shadow">
                <p class="text-sm opacity-80">Distribusi Bulan Ini</p>
                <h3 class="text-3xl font-bold mt-2">18.320 Porsi</h3>
            </div>

        </div>
    </div>


    {{-- ===================== --}}
    {{-- DATA USER & ROLE --}}
    {{-- ===================== --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Data User & Role</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Nama</th>
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">Role</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="p-3">Admin SPPG</td>
                        <td class="p-3">admin@sppg.id</td>
                        <td class="p-3">
                            <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded text-xs">
                                Admin
                            </span>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-3">Budi Santoso</td>
                        <td class="p-3">driver@sppg.id</td>
                        <td class="p-3">
                            <span class="px-2 py-1 bg-green-100 text-green-600 rounded text-xs">
                                Driver
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-3">Siti Rahma</td>
                        <td class="p-3">keuangan@sppg.id</td>
                        <td class="p-3">
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded text-xs">
                                Keuangan
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    {{-- ===================== --}}
    {{-- DATA SEKOLAH PENERIMA --}}
    {{-- ===================== --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Data Sekolah Penerima</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

            <div class="border rounded-lg p-4">
                <h3 class="font-semibold">SDN 01 Kertamandala</h3>
                <p class="text-sm text-gray-500">Jumlah Siswa: 320</p>
            </div>

            <div class="border rounded-lg p-4">
                <h3 class="font-semibold">SMPN 02 Kertamandala</h3>
                <p class="text-sm text-gray-500">Jumlah Siswa: 410</p>
            </div>

            <div class="border rounded-lg p-4">
                <h3 class="font-semibold">SDIT Harapan Bangsa</h3>
                <p class="text-sm text-gray-500">Jumlah Siswa: 275</p>
            </div>

        </div>
    </div>


    {{-- ===================== --}}
    {{-- MENU & STANDAR GIZI --}}
    {{-- ===================== --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Menu & Standar Gizi</h2>

        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Menu</th>
                    <th class="p-3 text-left">Kalori</th>
                    <th class="p-3 text-left">Protein</th>
                    <th class="p-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b">
                    <td class="p-3">Nasi, Ayam, Sayur, Buah</td>
                    <td class="p-3">650 kcal</td>
                    <td class="p-3">28 g</td>
                    <td class="p-3 text-green-600 font-semibold">Sesuai Standar</td>
                </tr>
                <tr>
                    <td class="p-3">Nasi, Telur, Tahu, Susu</td>
                    <td class="p-3">620 kcal</td>
                    <td class="p-3">25 g</td>
                    <td class="p-3 text-green-600 font-semibold">Sesuai Standar</td>
                </tr>
            </tbody>
        </table>
    </div>


    {{-- ===================== --}}
    {{-- LOG PRODUKSI & DISTRIBUSI --}}
    {{-- ===================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Log Produksi Harian</h2>

            <ul class="space-y-2 text-sm">
                <li class="flex justify-between border-b pb-2">
                    <span>15 Feb 2026</span>
                    <span>2.450 Porsi</span>
                </li>
                <li class="flex justify-between border-b pb-2">
                    <span>14 Feb 2026</span>
                    <span>2.380 Porsi</span>
                </li>
                <li class="flex justify-between">
                    <span>13 Feb 2026</span>
                    <span>2.510 Porsi</span>
                </li>
            </ul>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Distribusi Terbaru</h2>

            <ul class="space-y-2 text-sm">
                <li class="flex justify-between border-b pb-2">
                    <span>SDN 01</span>
                    <span>320 Porsi</span>
                </li>
                <li class="flex justify-between border-b pb-2">
                    <span>SMPN 02</span>
                    <span>410 Porsi</span>
                </li>
                <li class="flex justify-between">
                    <span>SDIT Harapan</span>
                    <span>275 Porsi</span>
                </li>
            </ul>
        </div>

    </div>


    {{-- ===================== --}}
    {{-- LAPORAN KEUANGAN --}}
    {{-- ===================== --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Laporan Keuangan (Ringkasan)</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">

            <div class="border rounded-lg p-4">
                <p class="text-gray-500">Anggaran Bulan Ini</p>
                <h3 class="text-xl font-bold mt-1">Rp 150.000.000</h3>
            </div>

            <div class="border rounded-lg p-4">
                <p class="text-gray-500">Realisasi</p>
                <h3 class="text-xl font-bold mt-1">Rp 132.500.000</h3>
            </div>

            <div class="border rounded-lg p-4">
                <p class="text-gray-500">Sisa Anggaran</p>
                <h3 class="text-xl font-bold mt-1 text-green-600">Rp 17.500.000</h3>
            </div>

        </div>
    </div>

</div>
