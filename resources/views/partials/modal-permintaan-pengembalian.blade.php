<div
    x-show="isPermintaanPengembalianModalOpen"
    style="display: none;"
    x-cloak
    @keydown.escape.window="isPermintaanPengembalianModalOpen = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <div @click="isPermintaanPengembalianModalOpen = false" class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
        x-show="isPermintaanPengembalianModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
    </div>

    <form
        method="POST" 
        :action="'/loan/konfirmasi-pengembalian/' + (selectedLoan ? selectedLoan.id : '')"
        x-show="isPermintaanPengembalianModalOpen"
        {{-- Kita gunakan x-data untuk mengontrol validasi keterangan --}}
        x-data="{ keterangan: '' }"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative bg-white w-full max-w-2xl rounded-lg shadow-xl max-h-[90vh] overflow-y-auto">

        @csrf

        <div class="flex items-start justify-between p-6 sticky top-0 bg-white z-10 border-b">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Konfirmasi Pengembalian</h2>
                <p class="text-gray-600 mt-1">
                    Barang: <span class="font-semibold" x-text="selectedLoan ? selectedLoan.item.nama_item : '...' "></span>
                </p>
            </div>
            <button type="button" @click="isPermintaanPengembalianModalOpen = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-times fa-lg"></i></button>
        </div>

        <div class="px-6 py-4 space-y-4">
            <p class="text-sm text-gray-700">
                Peminjam (<span x-text="selectedLoan ? selectedLoan.peminjam.username : ''"></span>) telah mengajukan pengembalian.
                Silakan periksa perbandingan foto kondisi barang.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <span class="text-sm text-gray-500 block mb-1">Foto Kondisi Awal</span>
                    <template x-if="selectedLoan && selectedLoan.foto_kondisi_awal">
                        <a :href="'/storage/' + selectedLoan.foto_kondisi_awal" target="_blank">
                            <img :src="'/storage/' + selectedLoan.foto_kondisi_awal" class="w-full h-40 object-cover rounded-lg border hover:opacity-90">
                        </a>
                    </template>
                </div>
                <div>
                    <span class="text-sm text-gray-500 block mb-1">Foto Kondisi Akhir (Saat Ini)</span>
                    <template x-if="selectedLoan && selectedLoan.foto_kondisi_akhir">
                        <a :href="'/storage/' + selectedLoan.foto_kondisi_akhir" target="_blank">
                            <img :src="'/storage/' + selectedLoan.foto_kondisi_akhir" class="w-full h-40 object-cover rounded-lg border hover:opacity-90">
                        </a>
                    </template>
                </div>
            </div>

            <hr class="my-4">

            <div>
                <label for="keterangan_sanksi" class="block text-sm font-medium text-gray-700">
                    Keterangan Sanksi / Masalah <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="keterangan_sanksi" 
                    name="keterangan_sanksi" 
                    rows="2" 
                    x-model="keterangan" {{-- Hubungkan dengan variabel Alpine --}}
                    placeholder="Wajib diisi jika barang bermasalah (Min. 10 karakter)..." 
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </textarea>
                <p class="text-xs text-gray-500 mt-1">Hanya wajib diisi jika barang bermasalah.</p>
                
                <p x-show="keterangan.length > 0 && keterangan.length < 10" class="text-red-500 text-xs mt-1">
                    (min. 10 karakter).
                </p>
            </div>
        </div>

        <div class="p-6 bg-gray-50 rounded-b-lg flex gap-3">
            <button type="submit" name="action" value="bermasalah"
                    {{-- Kunci tombol jika keterangan kurang dari 10 karakter --}}
                    :disabled="keterangan.length < 10"
                    :class="keterangan.length < 10 ? 'bg-red-300 cursor-not-allowed' : 'bg-red-600 hover:bg-red-700'"
                    class="flex-1 text-white py-2 px-4 rounded-lg font-medium transition-colors">
                Bermasalah
            </button>

            <button type="submit" name="action" value="selesai"
                    onclick="return confirm('Apakah Anda yakin barang sudah kembali dengan baik? Transaksi akan ditutup.')"
                    class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                Selesaikan Peminjaman
            </button>
        </div>
    </form>
</div>