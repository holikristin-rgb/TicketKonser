<x-app-layout>
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-2xl shadow-xl border border-sky-100">
                <h2 class="text-2xl font-bold text-sky-900 mb-6">Konfirmasi Pesanan</h2>
                <form action="{{ route('booking.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="concert_id" value="{{ $concert->id }}">
                    <p class="mb-4">Anda akan memesan tiket: <strong>{{ $concert->nama_konser }}</strong></p>
                    <div class="mb-6">
                        <label class="block text-sm font-bold mb-2">Jumlah Tiket:</label>
                        <input type="number" name="jumlah_tiket" min="1" max="{{ $concert->stok }}" value="1" 
                            class="w-full border-gray-200 rounded-xl p-3 text-lg font-bold">
                    </div>
                    <button type="submit" class="w-full bg-sky-600 text-white py-3 rounded-xl font-bold text-lg hover:bg-sky-700 shadow-lg shadow-sky-200">
                        KONFIRMASI PESANAN
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>