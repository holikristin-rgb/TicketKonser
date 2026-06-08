<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric', 
        ]);

        $user   = Auth::user();
        $userId = $user->id;

        $otpRecord = DB::table('user_otps')
            ->where('email', $user->email)
            ->orderBy('id', 'desc')
            ->first();

        if ($otpRecord && $otpRecord->otp == $request->otp) {
            DB::table('user_otps')->where('email', $user->email)->delete();

            return redirect()->route('user.dashboard')->with('success', 'Email berhasil diverifikasi!');
        }

        return redirect()->back()->with('error', 'Kode OTP yang Anda masukkan salah atau kadaluarsa.');
    }

    public function resend()
    {
        $user    = Auth::user();
        $otpCode = rand(1000, 9999);

        DB::table('user_otps')->updateOrInsert(
            ['email' => $user->email],
            [
                'otp'        => $otpCode,
                'expires_at' => now()->addMinutes(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        Mail::to($user->email)->send(new SendOtpMail($otpCode));

        return redirect()->back()->with('status', 'verification-link-sent')->with('success', 'Kode OTP baru berhasil dikirim!');
    }
}