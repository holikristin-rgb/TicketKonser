<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control - BlueTicket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#F8FAFC] text-slate-700">
    <div class="flex min-h-screen">
        
        <aside class="w-64 bg-[#1E293B] text-white p-8 flex flex-col hidden lg:block">
            <h1 class="text-2xl font-black italic mb-10 text-blue-400">BlueTicket.</h1>
            <nav class="space-y-4 flex-1">
                <a href="{{ route('admin.dashboard') }}" class="block bg-blue-600 p-4 rounded-2xl font-bold text-sm">Dashboard Admin</a>
            </nav>
            <div class="mt-auto border-t border-slate-700 pt-6">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="w-full flex items-center p-4 text-red-400 hover:bg-red-500/10 rounded-2xl transition font-bold text-sm cursor-pointer">Keluar Akun</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            </div>
        </aside>

        <main class="flex-1 p-6 lg:p-12">
            <header class="mb-12 flex justify-between items-center">
                <div>
                    <h2 class="text-4xl font-black text-slate-900 mb-2">Admin Control</h2>
                    <p class="text-slate-400">Verifikasi pembayaran dan kelola event konser secara real-time.</p>
                </div>
                <div class="bg-white px-6 py-3 rounded-2xl shadow-sm border border-slate-100">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Logged in as</p>
                    <p class="font-bold text-blue-600 text-sm">{{ Auth::user()->NAME ?? Auth::user()->name ?? 'Admin' }}</p>
                </div>
            </header>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-sm font-semibold shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-8">
                    
                    <section class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100">
                        <h3 class="text-[11px] font-black uppercase tracking-widest text-slate-400 mb-6">Konfirmasi Pembayaran User</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-separate border-spacing-y-3">
                                <thead>
                                    <tr class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                                        <th class="px-4 py-2">User</th>
                                        <th class="px-4 py-2">Konser & Tiket</th>
                                        <th class="px-4 py-2 text-center">Bukti Transfer</th>
                                        <th class="px-4 py-2 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($allBookings as $booking)
                                        @php
                                            $bStatus = strtoupper($booking->BOOKING_STATUS ?? $booking->status ?? $booking->STATUS ?? 'PENDING');
                                            $bBukti = $booking->BUKTI_TRANSFER ?? $booking->bukti_transfer ?? null;
                                            $bId = $booking->BOOKING_ID ?? $booking->id ?? $booking->ID;
                                            $bJumlah = $booking->JUMLAH_TIKET ?? $booking->jumlah_tiket ?? 1;
                                            $uName = $booking->USER_NAME ?? 'User Tak Dikenal';
                                            $kName = $booking->NAMA_KONSER ?? 'Konser Telah Dihapus';
                                        @endphp
                                        <tr class="bg-white border border-slate-100 shadow-sm rounded-2xl">
                                            <td class="p-4 font-bold text-sm text-slate-900">{{ $uName }}</td>
                                            <td class="p-4 text-sm">
                                                <span class="font-extrabold text-slate-900 block text-base">{{ $kName }}</span>
                                                <span class="text-xs text-blue-600 font-semibold">{{ $bJumlah }} Tiket</span>
                                            </td>
                                            <td class="p-4 text-center">
                                                @if($bBukti)
                                                    <img src="{{ asset('storage/' . $bBukti) }}" class="w-12 h-12 object-cover rounded-xl mx-auto border cursor-zoom-in hover:scale-105 transition" onclick="openImageModal('{{ asset('storage/' . $bBukti) }}')">
                                                @else
                                                    <span class="text-xs text-slate-400 italic">Belum Upload</span>
                                                @endif
                                            </td>
                                            <td class="p-4 text-center">
                                                <div class="flex justify-center gap-2">
                                                    @if($bStatus === 'PENDING')
                                                        <form action="{{ route('admin.confirm', $bId) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-xs font-bold shadow-md cursor-pointer">TERIMA</button>
                                                        </form>
                                                        <form action="{{ route('admin.reject', $bId) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-xl text-xs font-bold cursor-pointer">TOLAK</button>
                                                        </form>
                                                    @else
                                                        <span class="px-3 py-1 rounded-full text-xs font-black tracking-wider uppercase {{ $bStatus === 'SUKSES' || $bStatus === 'SUCCESS' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-500' }}">
                                                            {{ $bStatus }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center p-8 text-slate-400 italic text-sm">Belum ada transaksi masuk.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <section class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100">
                        <h3 class="text-[11px] font-black uppercase tracking-widest text-slate-400 mb-6">Manajemen Event Konser Aktif</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-separate border-spacing-y-3">
                                <thead>
                                    <tr class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                                        <th class="px-4 py-2">Poster</th>
                                        <th class="px-4 py-2">Detail Event</th>
                                        <th class="px-4 py-2">Stok Tiket</th>
                                        <th class="px-4 py-2 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($concerts as $concert)
                                        @php
                                            $cId = $concert->ID ?? $concert->id;
                                            $cTitle = $concert->NAMA_KONSER ?? $concert->nama_konser ?? 'Event';
                                            $cPrice = $concert->HARGA ?? $concert->harga ?? 0;
                                            $cStock = $concert->STOK_TIKET ?? $concert->stok_tiket ?? 0;
                                            $cLocation = $concert->LOKASI ?? $concert->lokasi ?? '-';
                                            $cDate = $concert->TANGGAL_KONSER ?? $concert->tanggal_konser ?? '';
                                            $cGenre = $concert->GENRE ?? $concert->genre ?? '-';
                                            $cPoster = $concert->POSTER ?? $concert->poster ?? '';
                                        @endphp
                                        <tr class="bg-white border border-slate-100 shadow-sm rounded-2xl">
                                            <td class="p-4 w-20">
                                                @if($cPoster)
                                                    <img src="{{ asset('storage/' . $cPoster) }}" class="w-14 h-20 object-cover rounded-xl border shadow-xs">
                                                @else
                                                    <div class="w-14 h-20 bg-slate-100 rounded-xl flex items-center justify-center text-[10px] text-slate-400">No Img</div>
                                                @endif
                                            </td>
                                            <td class="p-4 text-sm">
                                                <p class="font-extrabold text-slate-900 text-base mb-0.5">{{ $cTitle }}</p>
                                                <p class="text-xs text-slate-400 font-medium mb-1">{{ $cLocation }}</p>
                                                <p class="text-xs font-bold text-blue-600">Rp {{ number_format($cPrice, 0, ',', '.') }}</p>
                                            </td>
                                            <td class="p-4 text-sm font-bold text-slate-800">{{ $cStock }} Pcs</td>
                                            <td class="p-4">
                                                <div class="flex justify-center gap-2">
                                                    <button type="button" onclick="openEditModal('{{ $cId }}', '{{ addslashes($cTitle) }}', '{{ $cPrice }}', '{{ $cStock }}', '{{ $cDate }}', '{{ addslashes($cLocation) }}', '{{ addslashes($cGenre) }}')" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-xl text-xs font-bold transition shadow-sm cursor-pointer">Edit</button>
                                                    <form action="{{ route('admin.concert.destroy', $cId) }}" method="POST" onsubmit="return confirm('Hapus konser?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-xl text-xs font-bold transition cursor-pointer">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>

                <aside>
                    <section class="bg-[#1E293B] p-8 rounded-[32px] text-white shadow-xl sticky top-8 border border-slate-800">
                        <h3 class="text-[11px] font-black uppercase tracking-widest text-blue-400 mb-6">Tambah Concert Baru</h3>
                        <form action="{{ route('admin.concert.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Nama Artis & Judul Tour</label>
                                <input type="text" name="nama_konser" class="w-full bg-slate-800 border border-slate-700 rounded-xl p-3.5 text-sm text-white outline-none focus:border-blue-500" required>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Harga (Rp)</label>
                                    <input type="number" name="harga" class="w-full bg-slate-800 border border-slate-700 rounded-xl p-3.5 text-sm text-white outline-none focus:border-blue-500" required>
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Stok</label>
                                    <input type="number" name="stok_ticket" class="w-full bg-slate-800 border border-slate-700 rounded-xl p-3.5 text-sm text-white outline-none focus:border-blue-500" required>
                                </div>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Tanggal Pelaksanaan</label>
                                <input type="date" name="tanggal_konser" class="w-full bg-slate-800 border border-slate-700 rounded-xl p-3.5 text-sm text-white outline-none focus:border-blue-500" required>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Lokasi / Venue</label>
                                <input type="text" name="lokasi" class="w-full bg-slate-800 border border-slate-700 rounded-xl p-3.5 text-sm text-white outline-none focus:border-blue-500" required>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Poster</label>
                                <input type="file" name="poster" class="text-xs text-slate-400 block w-full mt-1 file:py-2 file:px-4 file:rounded-xl file:bg-blue-600 file:text-white cursor-pointer" required>
                            </div>
                            <button type="submit" class="w-full py-4 bg-blue-500 hover:bg-blue-600 rounded-xl text-xs font-black uppercase tracking-widest text-white shadow-lg transition cursor-pointer">PUBLIKASIKAN EVENT</button>
                        </form>
                    </section>
                </aside>
            </div>
        </main>
    </div>

    <div id="editModal" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-[28px] p-8 w-full max-w-lg mx-4 shadow-2xl relative">
            <h3 class="text-xl font-black text-slate-900 mb-6">Edit Data Event Konser</h3>
            <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">Nama Konser</label>
                    <input type="text" id="edit_nama" name="nama_konser" class="w-full border border-slate-200 rounded-xl p-3 text-sm outline-none focus:border-blue-500" required>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">Harga (Rp)</label>
                        <input type="number" id="edit_harga" name="harga" class="w-full border border-slate-200 rounded-xl p-3 text-sm outline-none focus:border-blue-500" required>
                    </div>
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">Stok Tiket</label>
                        <input type="number" id="edit_stok" name="stok_ticket" class="w-full border border-slate-200 rounded-xl p-3 text-sm outline-none focus:border-blue-500" required>
                    </div>
                </div>
                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">Tanggal Konser</label>
                    <input type="date" id="edit_tanggal" name="tanggal_konser" class="w-full border border-slate-200 rounded-xl p-3 text-sm outline-none focus:border-blue-500" required>
                </div>
                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">Lokasi Venue</label>
                    <input type="text" id="edit_lokasi" name="lokasi" class="w-full border border-slate-200 rounded-xl p-3 text-sm outline-none focus:border-blue-500" required>
                </div>
                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">Ganti Poster</label>
                    <input type="file" name="poster" class="text-xs text-slate-500 block mt-1">
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 mt-6">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 rounded-xl text-xs font-bold text-slate-600 cursor-pointer">Batal</button>
                    <button type="submit" class="px-5 py-3 bg-blue-600 hover:bg-blue-700 rounded-xl text-xs font-bold text-white shadow-md transition cursor-pointer">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="imageModal" class="fixed inset-0 bg-black/80 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300" onclick="closeImageModal()">
        <img id="modalImage" src="" class="max-w-[90%] max-h-[85vh] rounded-2xl shadow-2xl border-4 border-white/10">
    </div>

    <script>
        function openEditModal(id, nama, harga, stok, tanggal, lokasi, genre) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');
            form.action = `/admin/concert/update/${id}`;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_harga').value = harga;
            document.getElementById('edit_stok').value = stok;
            document.getElementById('edit_tanggal').value = tanggal ? tanggal.substring(0,10) : '';
            document.getElementById('edit_lokasi').value = lokasi;
            modal.classList.remove('hidden');
            setTimeout(() => modal.classList.remove('opacity-0'), 10);
        }
        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('opacity-0');
            setTimeout(() => modal.classList.add('hidden'), 300);
        }
        function openImageModal(src) {
            const imgModal = document.getElementById('imageModal');
            document.getElementById('modalImage').src = src;
            imgModal.classList.remove('hidden');
            setTimeout(() => imgModal.classList.remove('opacity-0'), 10);
        }
        function closeImageModal() {
            const imgModal = document.getElementById('imageModal');
            imgModal.classList.add('opacity-0');
            setTimeout(() => imgModal.classList.add('hidden'), 300);
        }
    </script>
</body>
</html>