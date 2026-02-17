<?php

use Livewire\Component;

new class extends Component
{
    
};
?>

<div class="space-y-8">

    {{-- ===================== --}}
    {{-- JADWAL PENGIRIMAN HARI INI --}}
    {{-- ===================== --}}
    <div>
        <h2 class="text-xl font-semibold mb-4">Jadwal Pengiriman Hari Ini</h2>

        <div class="bg-white rounded-xl shadow p-6">

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

                <div class="border rounded-lg p-4">
                    <p class="text-sm text-gray-500">Tanggal</p>
                    <h3 class="text-lg font-semibold mt-1">
                        16 Februari 2026
                    </h3>
                </div>

                <div class="border rounded-lg p-4">
                    <p class="text-sm text-gray-500">Jam Berangkat</p>
                    <h3 class="text-lg font-semibold mt-1">
                        06:00 WIB
                    </h3>
                </div>

                <div class="border rounded-lg p-4">
                    <p class="text-sm text-gray-500">Total Muatan</p>
                    <h3 class="text-lg font-semibold mt-1 text-blue-600">
                        2.450 Porsi
                    </h3>
                </div>

            </div>

        </div>
    </div>



    {{-- ===================== --}}
    {{-- RUTE PENGIRIMAN --}}
    {{-- ===================== --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Rute Pengiriman</h2>

        <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700">
            <li>Dapur Utama SPPG</li>
            <li>SDN 01 Kertamandala</li>
            <li>SMPN 02 Kertamandala</li>
            <li>SDIT Harapan Bangsa</li>
            <li>Kembali ke Dapur</li>
        </ol>
    </div>



    {{-- ===================== --}}
    {{-- SEKOLAH TUJUAN & JUMLAH PORSI --}}
    {{-- ===================== --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Sekolah Tujuan</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Sekolah</th>
                        <th class="p-3 text-left">Alamat</th>
                        <th class="p-3 text-left">Jumlah Porsi</th>
                        <th class="p-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>

                    <tr class="border-b">
                        <td class="p-3">SDN 01 Kertamandala</td>
                        <td class="p-3">Jl. Raya Kertamandala No. 12</td>
                        <td class="p-3 font-semibold">320</td>
                        <td class="p-3">
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded text-xs">
                                Belum Dikirim
                            </span>
                        </td>
                    </tr>

                    <tr class="border-b">
                        <td class="p-3">SMPN 02 Kertamandala</td>
                        <td class="p-3">Jl. Pendidikan No. 5</td>
                        <td class="p-3 font-semibold">410</td>
                        <td class="p-3">
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded text-xs">
                                Belum Dikirim
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td class="p-3">SDIT Harapan Bangsa</td>
                        <td class="p-3">Jl. Melati Indah No. 8</td>
                        <td class="p-3 font-semibold">275</td>
                        <td class="p-3">
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded text-xs">
                                Belum Dikirim
                            </span>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>



    {{-- ===================== --}}
    {{-- RINGKASAN CEPAT --}}
    {{-- ===================== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

        <div class="bg-green-600 text-white p-5 rounded-xl shadow">
            <p class="text-sm opacity-80">Total Sekolah Tujuan</p>
            <h3 class="text-3xl font-bold mt-2">3</h3>
        </div>

        <div class="bg-blue-600 text-white p-5 rounded-xl shadow">
            <p class="text-sm opacity-80">Estimasi Selesai</p>
            <h3 class="text-xl font-bold mt-2">
                09:30 WIB
            </h3>
        </div>

    </div>

</div>

