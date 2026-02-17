<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div class="space-y-8">

    {{-- ===================== --}}
    {{-- RINGKASAN DISTRIBUSI HARI INI --}}
    {{-- ===================== --}}
    <div>
        <h2 class="text-xl font-semibold mb-4">Ringkasan Distribusi Hari Ini</h2>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

            <div class="bg-blue-600 text-white p-5 rounded-xl shadow">
                <p class="text-sm opacity-80">Total Sekolah</p>
                <h3 class="text-3xl font-bold mt-2">22</h3>
            </div>

            <div class="bg-green-600 text-white p-5 rounded-xl shadow">
                <p class="text-sm opacity-80">Sudah Terkirim</p>
                <h3 class="text-3xl font-bold mt-2">18</h3>
            </div>

            <div class="bg-red-500 text-white p-5 rounded-xl shadow">
                <p class="text-sm opacity-80">Belum Terkirim</p>
                <h3 class="text-3xl font-bold mt-2">4</h3>
            </div>

        </div>
    </div>



    {{-- ===================== --}}
    {{-- DATA SEKOLAH & JUMLAH SISWA --}}
    {{-- ===================== --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Data Sekolah</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Sekolah</th>
                        <th class="p-3 text-left">Jumlah Siswa</th>
                        <th class="p-3 text-left">Jumlah Porsi</th>
                        <th class="p-3 text-left">Status Distribusi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="p-3">SDN 01 Kertamandala</td>
                        <td class="p-3">320</td>
                        <td class="p-3">320</td>
                        <td class="p-3">
                            <span class="px-2 py-1 bg-green-100 text-green-600 rounded text-xs">
                                Terkirim
                            </span>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-3">SMPN 02 Kertamandala</td>
                        <td class="p-3">410</td>
                        <td class="p-3">410</td>
                        <td class="p-3">
                            <span class="px-2 py-1 bg-green-100 text-green-600 rounded text-xs">
                                Terkirim
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-3">SDIT Harapan Bangsa</td>
                        <td class="p-3">275</td>
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
    {{-- RIWAYAT PENGIRIMAN --}}
    {{-- ===================== --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Riwayat Pengiriman</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Tanggal</th>
                        <th class="p-3 text-left">Sekolah</th>
                        <th class="p-3 text-left">Jumlah Porsi</th>
                        <th class="p-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="p-3">16 Feb 2026</td>
                        <td class="p-3">SDN 01 Kertamandala</td>
                        <td class="p-3">320</td>
                        <td class="p-3 text-green-600 font-semibold">
                            Selesai
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-3">16 Feb 2026</td>
                        <td class="p-3">SMPN 02 Kertamandala</td>
                        <td class="p-3">410</td>
                        <td class="p-3 text-green-600 font-semibold">
                            Selesai
                        </td>
                    </tr>
                    <tr>
                        <td class="p-3">15 Feb 2026</td>
                        <td class="p-3">SDIT Harapan Bangsa</td>
                        <td class="p-3">275</td>
                        <td class="p-3 text-yellow-600 font-semibold">
                            Pending
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
