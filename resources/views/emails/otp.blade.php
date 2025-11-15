<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verifikasi OTP - SMK Bakti Nusantara 666</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background: #f9fafb;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #2563eb;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 5px;
            color: #2563eb;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            border: 2px dashed #2563eb;
            text-align: center;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="color: #2563eb; margin: 0;">SMK BAKTI NUSANTARA 666</h1>
            <p style="color: #6b7280; margin: 5px 0;">Sistem Penerimaan Murid Baru</p>
        </div>
        
        <h2 style="color: #2563eb;">Halo, {{ $nama }}!</h2>
        
        <p>Terima kasih telah mendaftar di SMK Bakti Nusantara 666. Berikut adalah kode OTP untuk verifikasi akun Anda:</p>
        
        <div class="otp-code">
            {{ $otp }}
        </div>
        
        <p><strong>Kode OTP ini berlaku selama {{ $expires }} menit.</strong></p>
        
        <p>Gunakan kode ini untuk menyelesaikan proses pendaftaran akun Anda.</p>
        
        <p>Jika Anda tidak merasa mendaftar, silakan abaikan email ini.</p>
        
        <div class="footer">
            <p>
                Email ini dikirim secara otomatis. Mohon tidak membalas email ini.<br>
                &copy; {{ date('Y') }} SMK Bakti Nusantara 666. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>