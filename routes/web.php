<?php

use App\Http\Controllers\TicketController;
use App\Http\Controllers\OtpController; 
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

// Controller yang berada di DALAM folder Auth
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController; 
use App\Http\Controllers\Auth\VerifyEmailController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| 1. HALAMAN UTAMA & REDIRECTOR UTAMA
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        $role = strtolower($user->role ?? 'user');
        return $role === 'admin' ? redirect()->route('admin.dashboard') : redirect()->route('user.dashboard');
    }
    return view('welcome');
})->name('home');


/*
|--------------------------------------------------------------------------
| 2. JALUR AUTENTIKASI GUEST (GUEST MIDDLEWARE)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Register
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Forgot Password
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    // Reset Password
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});


/*
|--------------------------------------------------------------------------
| 3. JALUR AUTENTIKASI LANJUTAN (AUTH MIDDLEWARE & OTP)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Menampilkan halaman form OTP
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    
    // Verifikasi Email via Link (safety route - sistem ini pakai OTP custom)
    Route::get('email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    // Penangan Submit Verifikasi Angka OTP ke OtpController
    Route::post('verify-otp', [OtpController::class, 'verify'])->name('otp.verify');
    Route::get('verify-otp', function() { return redirect()->route('verification.notice'); });
    
    // Penangan Tombol Minta Kirim Ulang OTP Baru
    Route::post('email/verification-notification', [OtpController::class, 'resend'])->middleware('throttle:6,1')->name('verification.send');

    // Confirm Password
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Update Password
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});


/*
|--------------------------------------------------------------------------
| 4. AREA AKSES USER BIASA (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Halaman Dashboard Utama User
    Route::get('/dashboard', [TicketController::class, 'index'])->name('user.dashboard');
    
    // DETAIL KONSER: Menampilkan deskripsi konser sebelum membeli tiket (Mengarahkan ke concert_detail)
    Route::get('/concert/{id}', [TicketController::class, 'show'])->name('concert.show');
    
    // PROSES BOOKING: Menyimpan data reservasi tiket (Aksi tombol konfirmasi pesanan)
    Route::post('/book-ticket', [TicketController::class, 'store'])->name('booking.store');
    
    // INVOICE / HALAMAN BAYAR: Tempat user melihat instruksi & form upload transfer
    Route::get('/payment/{id}', [TicketController::class, 'payment'])->name('payment');
    Route::post('/payment/upload/{id}', [TicketController::class, 'uploadBukti'])->name('payment.upload');
    
    // E-TICKET FINAL: Halaman e-ticket ber-barcode yang bisa diunduh
    Route::get('/ticket/{id}', [TicketController::class, 'downloadTicket'])->name('ticket.download');
});


/*
|--------------------------------------------------------------------------
| 5. AREA AKSES MANAGEMENT ADMIN (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [TicketController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::post('/confirm/{id}', [TicketController::class, 'confirmPayment'])->name('admin.confirm');
    Route::post('/reject/{id}', [TicketController::class, 'rejectPayment'])->name('admin.reject');
    
    Route::post('/concert', [TicketController::class, 'storeConcert'])->name('admin.concert.store');
    Route::put('/concert/update/{id}', [TicketController::class, 'updateConcert'])->name('admin.concert.update');
    Route::delete('/concert/delete/{id}', [TicketController::class, 'destroyConcert'])->name('admin.concert.destroy');
});


/*
|--------------------------------------------------------------------------
| 6. FALLBACK ROUTE REDIRECTOR (PENGAMAN SISTEM REDIRECT LARAVEL BREEZE)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->get('/redirect-dashboard', function () {
    $user = Auth::user();
    $role = strtolower($user->role ?? 'user');
    return $role === 'admin' ? redirect()->route('admin.dashboard') : redirect()->route('user.dashboard');
})->name('dashboard');