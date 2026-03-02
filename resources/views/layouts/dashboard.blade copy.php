<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body>
        <div 
            x-data="{ open: false }" 
            class="h-screen bg-gray-100 flex text-slate-700 overflow-hidden"    
        >

            {{-- Sidebar --}}
            <aside 
                :class="open ? 'translate-x-0' : '-translate-x-full'"
                class="fixed z-30 inset-y-0 left-0 w-44 h-screen bg-white shadow-md transform transition-transform duration-300
                    md:translate-x-0 md:static md:inset-0"
            >
                <div class="p-1 border-b flex items-center gap-1">
                    <img src="{{ asset('/images/logo-web.png') }}" alt="" class="w-9 h-9">
                    <h1 class="text-lg font-bold">Mandala <sup class="text-sm font-light"> beta</sup></h1>
                </div>

                <nav class="p-4 space-y-6 text-sm h-full overflow-y-auto">

                    {{-- ================= MENU UTAMA ================= --}}
                    <div>
                        <p class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            -- Menu Utama --
                        </p>
                
                        <div class="space-y-1">
                            <livewire:links.nav-link url="dashboard">Dashboard</livewire:links.nav-link>
                            <livewire:links.nav-link url="biodata">Biodata</livewire:links.nav-link>
                        </div>
                    </div>
                
                    {{-- ================= Aksi ================= --}}
                    <div>
                        <p class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            -- Aksi --
                        </p>
                
                        <div class="space-y-1">
                            @if (Auth::user()->role->name == 'ADMIN')
                                <livewire:links.nav-link url="user.view">Kelola User</livewire:links.nav-link>
                                <livewire:buttons.nav-btn href="user.view" scope="user.*" color="gray">Kelola User</livewire:buttons.nav-btn> 
                                <livewire:buttons.nav-btn href="school.view" scope="school.*" color="gray">Master Sekolah</livewire:buttons.nav-btn> 
                                <livewire:buttons.nav-btn href="posyandu.view" scope="posyandu.*" color="gray">Master Posyandu</livewire:buttons.nav-btn>
                            @endif
                            @if (Auth::user()->role->name == 'PLOK')
                                <livewire:buttons.nav-btn href="" color="gray">Input Data</livewire:buttons.nav-btn>
                            @endif
                            @if (Auth::user()->role->name == 'PLOG')
                                <a href="#" class="block px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                                    Gizi
                                </a>   
                            @endif
                            @if (Auth::user()->role->name == 'ASLAP')
                                <livewire:links.nav-link url="school.view">Sekolah</livewire:links.nav-link>
                                <livewire:links.nav-link url="posyandu.view">Posyandu</livewire:links.nav-link>
                                <livewire:links.nav-link url="distribution.index">Distribusi</livewire:links.nav-link>
                            @endif
                            @if (Auth::user()->role->name == 'DRIVER')
                                <livewire:buttons.nav-btn href="log_distribution">Log Pengantaran</livewire:buttons.nav-btn>
                            @endif
                        </div>
                    </div>
                
                    {{-- ================= PENGATURAN ================= --}}
                    <div>
                        <p class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            -- Pengaturan --
                        </p>
                
                        <div class="space-y-1">
                            <livewire:links.nav-link url="profile">Profile</livewire:links.nav-link>
                            <livewire:links.nav-link url="change_password">Ubah Password</livewire:links.nav-link>
            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full text-left p-2 cursor-pointer rounded-lg hover:bg-red-100 hover:text-red-600 transition">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>

                </nav>
                
            </aside>

            {{-- Overlay (mobile only) --}}
            <div 
                x-show="open"
                @click="open = false"
                class="fixed h-screen w-screen inset-0 bg-slate-500 opacity-40 z-20 md:hidden"
            ></div>

            {{-- Main Content --}}
            <div class="flex-1 flex flex-col h-screen">

                {{-- Top Navbar --}}
                <header class="bg-white shadow-md p-2 flex items-center justify-between">
                    
                    {{-- Menu Button (Mobile) --}}
                    <button 
                        @click="open = true"
                        class="md:hidden text-gray-600"
                    >
                        ☰
                    </button>

                    <h2 class="font-semibold">Welcome {{ Auth::user()['name'] }}</h2>

                    <div class="invisible md:visible">
                        {{-- Profile / Logout --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="text-sm bg-red-500 text-white px-3 py-1 rounded">
                                Logout
                            </button>
                        </form>
                    </div>
                </header>

                {{-- Content Area --}}
                <main class="p-2 flex-1 bg-slate-200 overflow-y-auto">  
                    {{ $slot }}
                </main>

            </div>
        </div>

        @livewireScripts
    </body>
</html>
