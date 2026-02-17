<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div class="space-y-8">

    {{-- ===================== --}}
    {{-- MENU HARI INI --}}
    {{-- ===================== --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Menu Hari Ini</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="border rounded-lg p-4">
                <h3 class="text-lg font-semibold">
                    Nasi Putih, Ayam Panggang, Sayur Bayam, Pisang, Susu
                </h3>
                <p class="text-sm text-gray-500 mt-2">
                    Tanggal: 16 Februari 2026
                </p>
            </div>

            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <p class="text-sm text-gray-500">Total Porsi Produksi</p>
                <h3 class="text-3xl font-bold mt-2 text-green-600">
                    2.450 Porsi
                </h3>
            </div>

        </div>
    </div>



    {{-- ===================== --}}
    {{-- DAFTAR BAHAN YANG DIBUTUHKAN --}}
    {{-- ===================== --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Daftar Bahan yang Dibutuhkan</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Bahan</th>
                        <th class="p-3 text-left">Kebutuhan</th>
                        <th class="p-3 text-left">Stok Tersedia</th>
                        <th class="p-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>

                    <tr class="border-b">
                        <td class="p-3">Beras</td>
                        <td class="p-3">250 kg</td>
                        <td class="p-3">300 kg</td>
                        <td class="p-3">
                            <span class="px-2 py-1 bg-green-100 text-green-600 rounded text-xs">
                                Cukup
                            </span>
                        </td>
                    </tr>

                    <tr class="border-b">
                        <td class="p-3">Ayam</td>
                        <td class="p-3">180 kg</td>
                        <td class="p-3">150 kg</td>
                        <td class="p-3">
                            <span class="px-2 py-1 bg-red-100 text-red-600 rounded text-xs">
                                Kurang
                            </span>
                        </td>
                    </tr>

                    <tr class="border-b">
                        <td class="p-3">Bayam</td>
                        <td class="p-3">75 kg</td>
                        <td class="p-3">80 kg</td>
                        <td class="p-3">
                            <span class="px-2 py-1 bg-green-100 text-green-600 rounded text-xs">
                                Cukup
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td class="p-3">Susu UHT</td>
                        <td class="p-3">2.450 kotak</td>
                        <td class="p-3">2.300 kotak</td>
                        <td class="p-3">
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded text-xs">
                                Hampir Habis
                            </span>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>



    {{-- ===================== --}}
    {{-- RINGKASAN PERSIAPAN --}}
    {{-- ===================== --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Ringkasan Persiapan</h2>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

            <div class="bg-blue-500 text-white p-5 rounded-xl shadow">
                <p class="text-sm opacity-80">Total Item Bahan</p>
                <h3 class="text-3xl font-bold mt-2">12</h3>
            </div>

            <div class="bg-yellow-500 text-white p-5 rounded-xl shadow">
                <p class="text-sm opacity-80">Bahan Perlu Restock</p>
                <h3 class="text-3xl font-bold mt-2">2</h3>
            </div>

            <div class="bg-green-600 text-white p-5 rounded-xl shadow">
                <p class="text-sm opacity-80">Estimasi Siap Produksi</p>
                <h3 class="text-xl font-bold mt-2">
                    05:30 WIB
                </h3>
            </div>

        </div>
    </div>

</div>
