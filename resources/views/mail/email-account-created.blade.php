<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <h2>Selamat, {{ $user->name }} 👋</h2>

    <p>Akun Anda telah berhasil dibuat pada sistem <strong>{{ config('app.name') }}</strong>.</p>

    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Role:</strong> {{ $user->role ?? '-' }}</p>

    <p>
        Silakan login melalui tombol berikut:
    </p>

    <a href="{{ route('login') }}"
       style="background:#16a34a;color:#fff;padding:10px 20px;text-decoration:none;border-radius:6px;">
        Login Sekarang
    </a>

    <p style="margin-top:20px;">
        Jika Anda merasa tidak membuat akun ini, segera hubungi admin.
    </p>

    <br>
    <p>
        Salam,<br>
        Tim Support {{ config('app.name') }}
    </p>
</body>
</html>
