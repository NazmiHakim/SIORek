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
        x-transition:enter="ease-out duration-300" ... >
    </div>

    {{-- selectedLoan.id untuk membuat action URL yang unik --}}
    <form
        method="POST" 
        :action="'/loan/handle-permintaan/' + (selectedLoan ? selectedLoan.id : '')"
        x-show="isPermintaanPeminjamanModalOpen"
        x-transition:enter="ease-out duration-300" ...
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
                <label for="alasan_penolakan" class="block text-sm font-medium text-gray-700">Alasan Penolakan (Opsional)</label>
                <textarea id="alasan_penolakan" name="alasan_penolakan" rows="2" placeholder="Isi hanya jika Anda ingin menolak..." class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
            </div>
        </div>

        <div class="p-6 bg-gray-50 rounded-b-lg mt-6 flex gap-4">
            <button type="submit" name="action" value="tolak"
                    class="w-full bg-red-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-red-700">
                Tolak
            </button>
            <button type="submit" name="action" value="setujui"
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700">
                Setujui
            </button>
        </div>
    </form>
</div>