<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Akun Berhasil Dibuat</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f8; font-family: Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="padding: 30px 0; background-color:#f4f6f8;">
    <tr>
        <td align="center">

            <table width="600" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff; border-radius:8px; overflow:hidden;">
                
                {{-- Header --}}
                <tr>
                    <td style="background:#1f2937; padding:20px; text-align:center;">
                        <h1 style="margin:0; color:#ffffff; font-size:20px; letter-spacing:1px;">
                            Mandalacore
                        </h1>
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td style="padding:30px; color:#333333; font-size:14px; line-height:1.6;">
                        <p style="margin-top:0;">
                            Yth. <strong>{{ $user->name }}</strong>,
                        </p>

                        <p>
                            Akun Anda telah berhasil dibuat dan sudah dapat digunakan untuk mengakses sistem kami.
                            Berikut adalah informasi akun Anda:
                        </p>

                        {{-- Informasi Akun --}}
                        <table width="100%" cellpadding="8" cellspacing="0" role="presentation" style="background:#f9fafb; border:1px solid #e5e7eb; margin:15px 0;">
                            <tr>
                                <td width="30%" style="font-weight:bold;">Nama</td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">Email</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">Password</td>
                                <td>password (default)</td>
                            </tr>
                        </table>

                        {{-- Tombol Login --}}
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin:25px 0; text-align:center;">
                            <tr>
                                <td>
                                    <a href="{{ route('login') }}"
                                       style="background:#2563eb; color:#ffffff; text-decoration:none; padding:12px 25px; border-radius:5px; display:inline-block; font-weight:bold;">
                                        Login ke Sistem
                                    </a>
                                </td>
                            </tr>
                        </table>

                        {{-- Notis Ganti Password --}}
                        <p style="color:#b91c1c; font-weight:bold;">
                            Demi keamanan akun Anda, harap segera mengganti password setelah berhasil login pertama kali.
                        </p>

                        <p>
                            Apabila Anda tidak merasa meminta pembuatan akun ini, silakan hubungi tim support kami.
                        </p>

                        <p style="margin-bottom:0;">
                            Hormat kami,<br>
                            <strong>Tim Support Mandalacore</strong>
                        </p>
                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td style="background:#f9fafb; padding:20px; text-align:center; font-size:12px; color:#888888;">
                        © {{ date('Y') }} Mandalacore. Seluruh hak cipta dilindungi.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
