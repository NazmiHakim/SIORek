<div
    x-show="isPermintaanPengembalianModalOpen"
    style="display: none;"
    x-cloak
    @keydown.escape.window="isPermintaanPengembalianModalOpen = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <div @click="isPermintaanPengembalianModalOpen = false" class="fixed inset-0 bg-black bg-opacity-50" ...></div>

    <form
        method="POST" 
        {{-- Kita buat action-nya dinamis --}}
        :action="'/loan/konfirmasi-pengembalian/' + (selectedLoan ? selectedLoan.id : '')"
        x-show="isPermintaanPengembalianModalOpen"
        x-transition:enter="ease-out duration-300" ...
        class="relative bg-white w-full max-w-2xl rounded-lg shadow-xl max-h-[90vh] overflow-y-auto">

        @csrf

        <div class="flex items-start justify-between p-6 sticky top-0 bg-white z-10">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Konfirmasi Pengembalian</h2>
                <p class="text-gray-600 mt-1">
                    Barang: <span class="font-semibold" x-text="selectedLoan ? selectedLoan.item.nama_item : '...' "></span>
                </p>
            </div>
            <button type="button" @click="isPermintaanPengembalianModalOpen = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-times fa-lg"></i></button>
        </div>

        <div class="px-6 space-y-4">
            <p class="text-sm text-gray-700">
                Peminjam (<span x-text="selectedLoan ? selectedLoan.peminjam.username : ''"></span>) telah mengajukan pengembalian.
                Silakan periksa perbandingan foto kondisi barang.
            </p>

            {{-- Perbandingan Foto --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <span class="text-sm text-gray-500 block">Foto Kondisi Awal (Diambil Peminjam)</span>
                    <img :src="'/storage/' + (selectedLoan ? selectedLoan.foto_kondisi_awal : '')" alt="Foto Awal" class="mt-2 rounded-md border max-h-48 w-full object-cover">
                </div>
                <div>
                    <span class="text-sm text-gray-500 block">Foto Kondisi Akhir (Diunggah Peminjam)</span>
                    <img :src="'/storage/' + (selectedLoan ? selectedLoan.foto_kondisi_akhir : '')" alt="Foto Akhir" class="mt-2 rounded-md border max-h-48 w-full object-cover">
                </div>
            </div>

            <hr>

            <div>
                <label for="keterangan_sanksi" class="block text-sm font-medium text-gray-700">Keterangan Sanksi / Masalah (Opsional)</label>
                <textarea id="keterangan_sanksi" name="keterangan_sanksi" rows="2" placeholder="Isi hanya jika pengembalian bermasalah..." class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
            </div>
        </div>

        <div class="p-6 bg-gray-50 rounded-b-lg mt-6 flex gap-4">
            <button type="submit" name="action" value="bermasalah"
                    class="w-full bg-red-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-red-700">
                Bermasalah
            </button>
            <button type="submit" name="action" value="selesai"
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700">
                Selesaikan Peminjaman
            </button>
        </div>
    </form>
</div>