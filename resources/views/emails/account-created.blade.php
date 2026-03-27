<x-mail::message>
# Selamat, {{ $user->name }} 👋

Akun Anda telah berhasil dibuat pada sistem **{{ config('app.name') }}**.

**Email:** {{ $user->email }}  
**Role:** {{ $user->role->label() }}

<x-mail::button :url="route('login')">
Login Sekarang
</x-mail::button>

Jika Anda merasa tidak membuat akun ini, segera hubungi admin.

Salam,  
Tim Support {{ config('app.name') }}
</x-mail::message>
