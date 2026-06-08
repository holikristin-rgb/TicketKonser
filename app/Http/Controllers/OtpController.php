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

        $user = Auth::user();
        $userId = $user->id ?? $user->ID;

        $otpRecord = DB::table('USER_OTPS')
            ->where('USER_ID', $userId)
            ->orderBy('ID', 'desc')
            ->first();

        if ($otpRecord && $otpRecord->code == $request->otp) {
            DB::table('USER_OTPS')->where('USER_ID', $userId)->delete();

            return redirect()->route('user.dashboard')->with('success', 'Email berhasil diverifikasi!');
        }

        return redirect()->back()->with('error', 'Kode OTP yang Anda masukkan salah atau kadaluarsa.');
    }

    public function resend()
    {
        $user = Auth::user();
        $userId = $user->id ?? $user->ID;
        $otpCode = rand(1000, 9999);

        DB::table('USER_OTPS')->updateOrInsert(
            ['USER_ID' => $userId],
            [
                'CODE' => $otpCode,
                'EXPIRES_AT' => now()->addMinutes(10),
                'CREATED_AT' => now(),
                'UPDATED_AT' => now()
            ]
        );

        Mail::to($user->email ?? $user->EMAIL)->send(new SendOtpMail($otpCode));

        return redirect()->back()->with('status', 'verification-link-sent')->with('success', 'Kode OTP baru berhasil dikirim!');
    }
}