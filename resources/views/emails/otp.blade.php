<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP BlueTicket</title>
</head>
<body style="background-color: #0b111e; font-family: sans-serif; color: #ffffff; padding: 40px; text-align: center;">

    <div style="max-width: 500px; margin: 0 auto; background-color: #161f30; padding: 30px; border-radius: 16px; border: 1px solid #1e293b;">
        <h2 style="color: #ffffff; margin-bottom: 10px;">Halo, Rockstars! 🎸</h2>
        <p style="color: #94a3b8; font-size: 14px; line-height: 1.6;">
            Terima kasih telah bergabung di <strong>BlueTicket</strong>. Gunakan kode OTP di bawah ini untuk memverifikasi akun kamu:
        </p>
        
        <div style="background-color: rgba(6, 182, 212, 0.1); border: 1px solid rgba(6, 182, 212, 0.2); padding: 15px; border-radius: 12px; margin: 25px 0; display: inline-block; min-width: 150px;">
            <h1 style="color: #22d3ee; font-size: 32px; font-weight: bold; letter-spacing: 6px; margin: 0;">{{ $otp }}</h1>
        </div>

        <p style="color: #64748b; font-size: 12px; margin-top: 20px;">
            *Kode ini berlaku selama 10 menit. Jangan bagikan kode ini kepada siapa pun demi keamanan akunmu.
        </p>
    </div>

</body>
</html>