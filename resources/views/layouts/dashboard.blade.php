<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="winter" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>

        {{-- Leaflet & Cluster CDN --}}
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css"/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles

    </head>
    <body class="font-sans antialiased">

        {{-- The navbar with `sticky` and `full-width` --}}
        <x-nav sticky full-width>
    
            <x-slot:brand>
                {{-- Drawer toggle for "main-drawer" --}}
                <label for="main-drawer" class="lg:hidden mr-3">
                    <x-icon name="o-bars-3" class="cursor-pointer" />
                </label>

                {{-- Brand --}}
                <div class="flex gap-2 items-center">
                    <img src="{{ asset('/images/logo-web.png') }}" alt="" class="w-9 h-9">
                    <h2>Mandala</h2>
                </div>
            </x-slot:brand>
    
            {{-- Right side actions --}}
            <x-slot:actions>
                <x-dropdown right>
                    <x-slot:trigger>
                        <x-button icon="o-bell" class="btn-circle" />
                    </x-slot:trigger>
                
                    <x-menu-item title="Archive" />
                    <x-menu-item title="Move" />
                </x-dropdown>
            </x-slot:actions>
        </x-nav>
    
        {{-- The main content with `full-width` --}}
        <x-main with-nav full-width>
    
            {{-- This is a sidebar that works also as a drawer on small screens --}}
            {{-- Notice the `main-drawer` reference here --}}
            <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-200" right-mobile>
    
                {{-- User --}}
                @if($user = auth()->user())
                    <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover class="pt-2">
                        <x-slot:actions>
                            <x-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff" no-wire-navigate link="/logout" />
                        </x-slot:actions>
                    </x-list-item>
    
                    <x-menu-separator />
                @endif
    
                {{-- Activates the menu item when a route matches the `link` property --}}
                <x-menu activate-by-route>
                    <x-menu-item title="Dashboard" icon="o-home" link="/dashboard" />
                    <x-menu-item title="Biodata" icon="o-document-text" link="/biodata" />   
                    
                    <x-menu-separator />
                    
                    @if (Auth::user()->role->name == 'ADMIN')
                        <x-menu-item title="Kelola User" icon="o-users" link="{{ route('user.view') }}" route="user.view" />   
                    @endif

                    @if (Auth::user()->role->name == 'PLOK')
                        <x-menu-item title="Presensi Relawan" icon="o-users" link="{{ route('attendance.create') }}" route="attendance.create" />   
                    @endif

                    @if (Auth::user()->role->name == 'ASLAP')
                        <x-menu-item title="Data Sekolah" icon="o-academic-cap" link="{{ route('school.index') }}" route="school.index" />   
                        <x-menu-item title="Data Posyandu" icon="o-squares-plus" link="{{ route('posyandu.index') }}" route="posyandu.index" /> 
                        <x-menu-separator /> 
                        <x-menu-item title="Manajemen Distribusi" icon="o-truck" link="{{ route('distribution.index') }}" route="distribution.index" />   
                    @endif

                    @if (Auth::user()->role->name == 'DISTRIBUSI')
                        <x-menu-item title="Distribusi" icon="o-users" link="{{ route('distribution.index') }}" route="distribution.index" />   
                    @endif

                    <x-menu-separator />

                    <x-menu-sub title="Profile" icon="o-user-circle">
                        <x-menu-item title="Pengaturan Akun" icon="o-adjustments-horizontal" link="{{ route('profile') }}" route="profile" />
                        <x-menu-item title="Ubah Password" icon="o-key" link="{{ route('change_password') }}" route="change_password" />
                    </x-menu-sub>
                </x-menu>
            </x-slot:sidebar>
    
            {{-- The `$slot` goes here --}}
            <x-slot:content>
                {{ $slot }}
            </x-slot:content>
        </x-main>
    
        {{--  TOAST area --}}
        <x-toast />
        @livewireScripts
    </body>
</html>
