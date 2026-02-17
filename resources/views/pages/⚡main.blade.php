<?php

use Livewire\Component;

new class extends Component
{
    public function render()
    {
        return $this->view()
            ->layout('layouts::app');
    }
};
?>

<div class="font-sans text-gray-800 scroll-smooth">

    {{-- ================= NAVBAR ================= --}}
    <nav class="bg-white shadow-md fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            
            {{-- Logo + Nama --}}
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo_bgn.png') }}" 
                     class="h-10 w-10 object-contain" 
                     alt="Logo SPPG">
                <span class="font-bold text-blue-700 text-lg">
                    SPPG Kertamandala 2
                </span>
            </div>

            {{-- Menu --}}
            <div class="hidden md:flex gap-8 items-center text-sm font-medium">
                <a href="#visi" class="hover:text-blue-600">Visi Misi</a>
                <a href="#program" class="hover:text-blue-600">Program</a>
                <a href="#galeri" class="hover:text-blue-600">Galeri</a>
                <a href="#kontak" class="hover:text-blue-600">Kontak</a>

                <a href="/login" 
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Login
                </a>
            </div>
        </div>
    </nav>


    {{-- ================= HERO ================= --}}
    <section class="bg-gradient-to-r from-blue-700 to-blue-500 text-white pt-32 pb-24">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">

            {{-- Text --}}
            <div>
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">
                    Pelayanan Gizi Berkualitas  
                    untuk Generasi Sehat
                </h1>

                <p class="text-lg mb-8">
                    Satuan Pelayanan Pemenuhan Gizi yang mendukung program 
                    pemerintah dalam meningkatkan kualitas gizi masyarakat.
                </p>

                <div class="flex gap-4">
                    <a href="/login" 
                       class="bg-white text-blue-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200">
                        Login
                    </a>

                    <a href="/login" 
                       class="border border-white px-6 py-3 rounded-lg hover:bg-white hover:text-blue-700 transition">
                        Hubungi Kami
                    </a>
                </div>
            </div>

            {{-- Image --}}
            <div class="hidden md:block">
                <img src="{{ asset('images/avatars.png') }}" 
                     class="w-full rounded-xl shadow-xl"
                     alt="Ilustrasi Gizi">
            </div>

        </div>
    </section>


    {{-- ================= VISI MISI ================= --}}
    <section id="visi" class="py-20 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6 text-center mb-12">
            <h2 class="text-3xl font-bold">Visi & Misi</h2>
        </div>

        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-10">

            {{-- VISI --}}
            <div class="bg-white p-8 rounded-xl shadow">
                <div class="flex items-center gap-3 mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 6v6l4 2" />
                    </svg>
                    <h3 class="text-xl font-semibold text-blue-700">Visi</h3>
                </div>
                <p>
                    Mewujudkan pelayanan pemenuhan gizi yang berkualitas, 
                    merata dan berkelanjutan.
                </p>
            </div>

            {{-- MISI --}}
            <div class="bg-white p-8 rounded-xl shadow">
                <div class="flex items-center gap-3 mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12l2 2l4 -4" />
                    </svg>
                    <h3 class="text-xl font-semibold text-blue-700">Misi</h3>
                </div>
                <ul class="list-disc list-inside space-y-2">
                    <li>Menyediakan makanan bergizi sesuai standar.</li>
                    <li>Menjaga kebersihan dan keamanan dapur.</li>
                    <li>Distribusi tepat sasaran.</li>
                </ul>
            </div>

        </div>
    </section>


    {{-- ================= PROGRAM ================= --}}
    <section id="program" class="py-20">
        <div class="max-w-6xl mx-auto px-6 text-center mb-12">
            <h2 class="text-3xl font-bold">Program & Layanan</h2>
        </div>

        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-8">

            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition text-center">
                <div class="bg-blue-100 w-16 h-16 mx-auto flex items-center justify-center rounded-full mb-4">
                    🍱
                </div>
                <h3 class="font-semibold text-lg mb-3 text-blue-700">
                    Produksi Makanan
                </h3>
                <p>Pengolahan sesuai standar keamanan pangan.</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition text-center">
                <div class="bg-blue-100 w-16 h-16 mx-auto flex items-center justify-center rounded-full mb-4">
                    📊
                </div>
                <h3 class="font-semibold text-lg mb-3 text-blue-700">
                    Monitoring
                </h3>
                <p>Evaluasi dan pelaporan distribusi.</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition text-center">
                <div class="bg-blue-100 w-16 h-16 mx-auto flex items-center justify-center rounded-full mb-4">
                    👩‍🍳
                </div>
                <h3 class="font-semibold text-lg mb-3 text-blue-700">
                    Relawan
                </h3>
                <p>Pemberdayaan masyarakat dalam pelayanan gizi.</p>
            </div>

        </div>
    </section>


    {{-- ================= STATISTIK ================= --}}
    <section class="py-20 bg-blue-700 text-white">
        <div class="max-w-6xl mx-auto px-6 text-center mb-12">
            <h2 class="text-3xl font-bold">Statistik Pelayanan</h2>
        </div>

        <div class="grid md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold">1.250+</div>
                <p>Penerima Manfaat</p>
            </div>
            <div>
                <div class="text-4xl font-bold">5.000+</div>
                <p>Porsi Disalurkan</p>
            </div>
            <div>
                <div class="text-4xl font-bold">35</div>
                <p>Relawan Aktif</p>
            </div>
            <div>
                <div class="text-4xl font-bold">12</div>
                <p>Bulan Operasional</p>
            </div>
        </div>
    </section>


    {{-- ================= GALERI ================= --}}
    <section id="galeri" class="py-20 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6 text-center mb-12">
            <h2 class="text-3xl font-bold">Galeri Kegiatan</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-6 max-w-6xl mx-auto px-6">
            <img src="{{ asset('galeri1.jpg') }}" class="rounded-lg shadow">
            <img src="{{ asset('galeri2.jpg') }}" class="rounded-lg shadow">
            <img src="{{ asset('galeri3.jpg') }}" class="rounded-lg shadow">
        </div>
    </section>


    {{-- ================= FOOTER ================= --}}
    <footer id="kontak" class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-8">

            <div>
                <h3 class="text-white font-semibold mb-4">
                    SPPG Kertamandala 2
                </h3>
                <p>
                    Satuan Pelayanan Pemenuhan Gizi dalam mendukung program 
                    Badan Gizi Nasional.
                </p>
            </div>

            <div>
                <h3 class="text-white font-semibold mb-4">Kontak</h3>
                <p>Alamat: Kertamandala</p>
                <p>Email: sppg@email.com</p>
                <p>Telp: 08xxxxxxxx</p>
            </div>

            <div>
                <h3 class="text-white font-semibold mb-4">Operasional</h3>
                <p>Senin - Jumat</p>
                <p>08.00 - 16.00 WIB</p>
            </div>
        </div>

        <div class="text-center mt-8 text-sm text-gray-500">
            © {{ date('Y') }} SPPG Kertamandala 2
        </div>
    </footer>

</div>
