<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Pembayaran - BlueTicket</title>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">
    <div class="max-w-md w-full bg-white rounded-[40px] shadow-2xl p-8 text-center">
        <h2 class="text-2xl font-black italic mb-2">Selesaikan Pembayaran</h2>
        <p class="text-slate-500 mb-8">Total yang harus dibayar: <br> <span class="text-2xl font-black text-blue-600">Rp {{ number_format($booking->total_harga) }}</span></p>
        
        <div class="bg-blue-50 rounded-3xl p-6 mb-8">
            <p class="text-[10px] font-black uppercase text-blue-400 mb-2">Transfer Ke Bank Mandiri</p>
            <p class="text-xl font-black text-blue-900">123-000-456-7890</p>
            <p class="text-xs font-bold text-blue-700 mt-1">a.n. PT BlueTicket Nusantara</p>
        </div>

        <form action="{{ route('payment.upload', $booking->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-6 text-left">
                <label class="text-[10px] font-black uppercase text-slate-400 ml-2">Upload Bukti Transfer</label>
                <input type="file" name="bukti_transfer" required class="w-full mt-2 text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>
            <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-black uppercase tracking-widest hover:bg-blue-600 transition-all">Kirim Bukti Pembayaran</button>
        </form>
    </div>
</body>
</html>