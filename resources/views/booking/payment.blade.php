<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-800 leading-tight">
            {{ __('Penyelesaian Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl rounded-[30px] border border-gray-100">
                <div class="p-8 sm:p-10">
                    
                    <div class="text-center mb-10">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-50 text-blue-600 rounded-3xl mb-4 shadow-sm">
                            <i class="fas fa-wallet text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-black text-slate-800">Transfer Manual</h3>
                        <p class="text-slate-500 mt-2">Segera selesaikan pembayaran Anda agar tiket tidak hangus.</p>
                    </div>

                    <div class="relative overflow-hidden bg-gradient-to-br from-blue-700 to-blue-900 rounded-[25px] p-8 text-white mb-10 shadow-xl shadow-blue-200">
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                        
                        <div class="relative z-10">
                            <div class="flex justify-between items-start mb-8">
                                <div>
                                    <p class="text-blue-200 text-xs font-bold uppercase tracking-widest">Metode Pembayaran</p>
                                    <p class="text-xl font-bold">Bank Mandiri</p>
                                </div>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg" class="h-8 brightness-0 invert" alt="Mandiri Logo">
                            </div>
                            
                            <div class="mb-8">
                                <p class="text-blue-200 text-xs font-bold uppercase tracking-widest mb-1">Nomor Rekening</p>
                                <div class="flex items-center gap-3">
                                    <h4 class="text-3xl font-mono font-black tracking-wider" id="no-rekening">114-00-2233-4455</h4>
                                    <button onclick="copyToClipboard()" class="bg-white/20 hover:bg-white/30 p-2 rounded-lg transition">
                                        <i class="fas fa-copy text-sm"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="flex justify-between items-end">
                                <div>
                                    <p class="text-blue-200 text-xs font-bold uppercase tracking-widest mb-1">Nama Penerima</p>
                                    <p class="text-lg font-bold">PT. BlueTicket Indonesia</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-blue-200 text-xs font-bold uppercase tracking-widest mb-1">ID Pesanan</p>
                                    <p class="text-sm font-mono">#BT-{{ $booking->id }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-2xl p-6 mb-10 border border-slate-100">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 font-medium">Total Tagihan:</span>
                            <span class="text-3xl font-black text-blue-700">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <form action="{{ route('upload.bukti', $booking->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-black text-slate-700 uppercase tracking-wider mb-3">
                                    Upload Bukti Transfer
                                </label>
                                
                                <div id="preview-container" class="hidden mb-4">
                                    <div class="relative inline-block w-full h-64 rounded-2xl overflow-hidden border-2 border-blue-100">
                                        <img id="image-preview" src="#" alt="Preview" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 hover:opacity-100 transition">
                                            <p class="text-white font-bold">Ganti Gambar</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="relative">
                                    <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" required 
                                        onchange="previewImage(this)"
                                        class="hidden">
                                    <label for="bukti_pembayaran" class="flex items-center justify-center w-full px-6 py-10 border-2 border-dashed border-slate-300 rounded-[20px] cursor-pointer hover:border-blue-500 hover:bg-blue-50/50 transition-all group">
                                        <div class="text-center">
                                            <i class="fas fa-cloud-upload-alt text-4xl text-slate-300 group-hover:text-blue-500 mb-3 transition"></i>
                                            <p class="text-slate-500 group-hover:text-blue-600 font-medium">Klik untuk pilih foto bukti transfer</p>
                                            <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-widest">JPG, PNG, atau WEBP (Max. 2MB)</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-black py-5 rounded-2xl shadow-xl shadow-blue-200 transition-all active:scale-95 flex items-center justify-center gap-3">
                                <i class="fas fa-check-circle"></i>
                                Konfirmasi Pembayaran Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-8 text-center">
                <p class="text-slate-400 text-sm">Butuh bantuan transaksi? Hubungi Kami</p>
                <div class="flex justify-center gap-4 mt-4">
                    <a href="#" class="flex items-center gap-2 bg-white px-5 py-2 rounded-full shadow-sm text-xs font-bold text-slate-600 hover:text-blue-600 transition">
                        <i class="fab fa-whatsapp text-green-500"></i> WhatsApp Admin
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const container = document.getElementById('preview-container');
            const preview = document.getElementById('image-preview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function copyToClipboard() {
            const rek = document.getElementById('no-rekening').innerText;
            navigator.clipboard.writeText(rek);
            
            // Trigger SweetAlert jika sudah install
            Swal.fire({
                icon: 'success',
                title: 'Disalin!',
                text: 'Nomor rekening berhasil disalin.',
                timer: 1500,
                showConfirmButton: false,
                customClass: {
                    popup: 'rounded-3xl'
                }
            });
        }
    </script>
</x-app-layout>