<div
    x-show="isSedangMeminjamModalOpen"
    style="display: none;"
    x-cloak
    @keydown.escape.window="isSedangMeminjamModalOpen = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <div @click="isSedangMeminjamModalOpen = false" class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
        x-show="isSedangMeminjamModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
    </div>

    <form
        method="POST" 
        :action="'/loan/ajukan-pengembalian/' + (selectedLoan ? selectedLoan.id : '')"
        enctype="multipart/form-data" {{-- Wajib untuk upload file --}}
        x-show="isSedangMeminjamModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative bg-white w-full max-w-lg rounded-lg shadow-xl max-h-[90vh] overflow-y-auto">

        @csrf

        <div class="flex items-start justify-between p-6 sticky top-0 bg-white z-10 border-b">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Ajukan Pengembalian Barang</h2>
                <p class="text-gray-600 mt-1">
                    Barang: <span class="font-semibold" x-text="selectedLoan ? selectedLoan.item.nama_item : '...' "></span>
                </p>
            </div>
            <button type="button" @click="isSedangMeminjamModalOpen = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-times fa-lg"></i></button>
        </div>

        <div class="px-6 py-4 space-y-4">
            
            {{-- ALERT: Hanya muncul jika foto_kondisi_akhir sudah ada (artinya ditolak/revisi) --}}
            <template x-if="selectedLoan && selectedLoan.foto_kondisi_akhir">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 flex gap-3 items-start animate-pulse">
                    <div class="text-red-600 mt-0.5">
                        <i class="fa-solid fa-triangle-exclamation fa-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-red-700 text-sm">Foto Pengembalian Ditolak!</h4>
                        <p class="text-xs text-red-600 mt-1">
                            Pemilik barang menolak bukti foto yang Anda kirim sebelumnya. 
                            Mohon pastikan foto kondisi barang terlihat jelas dan sesuai, lalu upload ulang.
                        </p>
                        <a :href="'/storage/' + selectedLoan.foto_kondisi_akhir" target="_blank" 
                           class="text-xs text-red-700 underline mt-2 inline-block hover:text-red-900 font-medium">
                           <i class="fa-regular fa-image"></i> Lihat foto yang ditolak
                        </a>
                    </div>
                </div>
            </template>

            <p class="text-sm text-gray-700">
                Untuk menyelesaikan peminjaman, silakan upload foto kondisi akhir barang yang akan Anda kembalikan.
            </p>

            <div x-data="{ fileError: null }">
                <label for="foto_kondisi_akhir" class="block text-sm font-medium text-gray-700">Foto Kondisi Akhir</label>
                <input type="file" name="foto_kondisi_akhir" id="foto_kondisi_akhir" 
                       class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" 
                       accept="image/png, image/jpeg, image/jpg"
                       required
                       @change="
                            const file = $el.files[0];
                            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
                            const maxSize = 10 * 1024 *1024;

                            if (file) {
                                if (!validTypes.includes(file.type)) {
                                    fileError = 'File harus berupa gambar (JPG, PNG, WEBP)';
                                    $el.value = '';
                                } else if (file.size > maxSize) {
                                    fileError = 'Ukuran file terlalu besar (Max 10MB)';
                                    $el.value = ''; 
                                } else {
                                    fileError = null;    
                                }
                            }
                        "                       
                >

                <p x-show="fileError" 
                   x-text="fileError" 
                   class="mt-1 text-sm text-red-600 font-medium" style="display: none;">
                </p>
                
                <p class="mt-1 text-xs text-gray-500">
                    Format: PNG/JPG. Maksimal: 10MB.
                </p>
            </div>

            <div x-show="selectedLoan && selectedLoan.foto_kondisi_awal" class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                <span class="text-xs font-semibold text-gray-500 uppercase block mb-2">Referensi: Foto Kondisi Awal</span>
                <a :href="'/storage/' + selectedLoan.foto_kondisi_awal" target="_blank">
                    <img :src="'/storage/' + selectedLoan.foto_kondisi_awal" alt="Foto Awal" class="w-full h-40 object-cover rounded-md border hover:opacity-90 transition">
                </a>
            </div>
        </div>

        <div class="p-6 bg-gray-50 rounded-b-lg mt-6 flex justify-end">
            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700 shadow-sm transition-all transform active:scale-95">
                <span x-text="selectedLoan && selectedLoan.foto_kondisi_akhir ? 'Upload Ulang & Ajukan' : 'Ajukan Pengembalian'"></span>
            </button>
        </div>
    </form>
</div>