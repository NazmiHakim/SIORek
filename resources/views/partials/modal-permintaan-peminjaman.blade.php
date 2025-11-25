<div
    x-show="isPermintaanPeminjamanModalOpen"
    style="display: none;"
    x-cloak
    @keydown.escape.window="isPermintaanPeminjamanModalOpen = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <div 
        @click="isPermintaanPeminjamanModalOpen = false" 
        class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
        x-show="isPermintaanPeminjamanModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
    </div>

    <form
        method="POST" 
        :action="'/loan/handle-permintaan/' + (selectedLoan ? selectedLoan.id : '')"
        x-show="isPermintaanPeminjamanModalOpen"
        
        {{-- 1. INISIALISASI VARIABEL UNTUK MEMANTAU ALASAN --}}
        x-data="{ alasan: '' }"

        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative bg-white w-full max-w-lg rounded-lg shadow-xl max-h-[90vh] overflow-y-auto">

        @csrf
        @method('POST')

        <div class="flex items-start justify-between p-6 sticky top-0 bg-white z-10">
            <div>
                <h2 class="text-xl font-bold text-gray-900">
                    Konfirmasi Permintaan
                </h2>
                <p class="text-gray-600 mt-1">
                    Barang: <span class="font-semibold" x-text="selectedLoan ? selectedLoan.item.nama_item : '...' "></span>
                </p>
            </div>
            <button type="button" @click="isPermintaanPeminjamanModalOpen = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-times fa-lg"></i></button>
        </div>

        <div class="px-6 space-y-4">
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <span class="text-sm text-gray-500 block">Peminjam</span>
                    <span class="font-medium text-gray-900" x-text="selectedLoan ? selectedLoan.peminjam.username : '...'"></span>
                </div>
                <div>
                    <span class="text-sm text-gray-500 block">Jumlah</span>
                    <span class="font-medium text-gray-900" x-text="selectedLoan ? selectedLoan.jumlah + ' unit' : '...'"></span>
                </div>
                <div>
                    <span class="text-sm text-gray-500 block">Tanggal Mulai</span>
                    <span class="font-medium text-gray-900" x-text="selectedLoan ? new Date(selectedLoan.tanggal_mulai).toLocaleDateString('id-ID', {day:'numeric', month:'long', year:'numeric'}) : '...'"></span>
                </div>
                <div>
                    <span class="text-sm text-gray-500 block">Tanggal Selesai</span>
                    <span class="font-medium text-gray-900" x-text="selectedLoan ? new Date(selectedLoan.tanggal_selesai).toLocaleDateString('id-ID', {day:'numeric', month:'long', year:'numeric'}) : '...'"></span>
                </div>
            </div>

            <div class="space-y-2">
                <span class="text-sm text-gray-500 block">Dokumen Pendukung</span>
                <div>
                    <a :href="'/storage/' + (selectedLoan ? selectedLoan.foto_kim : '')" target="_blank" class="text-blue-600 hover:underline text-sm">
                        <i class="fa-solid fa-id-card w-4"></i> Lihat KTM/KTP
                    </a>
                </div>
                <div>
                    <a :href="'/storage/' + (selectedLoan ? selectedLoan.surat_peminjaman : '')" target="_blank" class="text-blue-600 hover:underline text-sm">
                        <i class="fa-solid fa-file-pdf w-4"></i> Lihat Surat Peminjaman
                    </a>
                </div>
            </div>

            <hr>

            <div>
                <label for="alasan_penolakan" class="block text-sm font-medium text-gray-700">Alasan Penolakan</label>
                <textarea 
                    id="alasan_penolakan" 
                    name="alasan_penolakan" 
                    rows="2" 
                    x-model="alasan"
                    placeholder="Wajib diisi jika Anda ingin menolak (Min. 10 karakter)..." 
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </textarea>
                
                {{-- pesan eror real time --}}
                <p x-show="alasan.length > 0 && alasan.length < 10" class="text-red-500 text-xs mt-1">
                    Alasan terlalu pendek (minimal 10 karakter).
                </p>
                <p class="text-xs text-gray-500 mt-1">Alasan wajib diisi jika ingin menekan tombol <strong>Tolak</strong>.</p>
            </div>
        </div>

        <div class="p-6 bg-gray-50 rounded-b-lg mt-6 flex gap-4">
            {{-- tombol ini mati jika alasan < 10 karakter --}}
            <button type="submit" name="action" value="tolak"
                    :disabled="alasan.length < 10"
                    :class="alasan.length < 10 ? 'bg-red-300 cursor-not-allowed' : 'bg-red-600 hover:bg-red-700'"
                    class="w-full text-white py-2 px-4 rounded-lg font-medium transition-colors">
                Tolak
            </button>
            
            {{-- tombol Setuju --}}
            <button type="submit" name="action" value="setujui"
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                Setuju
            </button>
        </div>
    </form>
</div>