<form
    method="POST"
    action="/link-persetujuan-peminjaman" 
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

        <div
            x-show="isPermintaanPeminjamanModalOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative bg-white w-full max-w-lg rounded-lg shadow-xl">

            <div class="sm:max-h-[85vh] max-h-[78vh] mt-4 sm:mt-0 overflow-y-auto">
                <div class="p-6">
                    <div class="mb-4 flex justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-biru-primary">Detail Peminjaman</h2>
                            <p class="text-gray-600">Informasi lengkap peminjaman barang</p>
                        </div>
                        <button type="button" @click="isPermintaanPeminjamanModalOpen = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-times fa-lg"></i></button>
                    </div>


                    <div class="space-y-4">
                        <div>
                            <span class="text-sm text-gray-500 block">Nama Barang</span>
                            <span class="text-md font-semibold text-gray-800">Wireless Mouse Logitech</span>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500 block">Jumlah Unit</span>
                            <span class="text-md font-semibold text-gray-800">5 unit</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm text-gray-500 block">Peminjam</span>
                                <span class="text-md font-semibold text-gray-800">Himpunan Mahasiswa Teknologi Informasi</span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 block">Pemilik</span>
                                <span class="text-md font-semibold text-gray-800">Rektorat</span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 block">Tanggal Mulai</span>
                                <span class="text-md font-semibold text-gray-800">Senin, 1 Desember 2025</span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 block">Tanggal Selesai</span>
                                <span class="text-md font-semibold text-gray-800">Minggu, 7 Desember 2025</span>
                            </div>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500 block mb-2">Status</span>
                            <span class="bg-warning-fill text-warning-stroke border-warning-stroke border text-sm font-medium px-3 py-1 rounded-full inline-block">Menunggu Persetujuan Dari Pemilik</span>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div>
                        <h3 class="text-lg font-bold text-biru-primary mb-3">Dokumen Peminjaman</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-100 border border-gray-300 rounded-lg h-32 flex items-center justify-center">
                                <span class="text-gray-500">Foto KTP tersimpan</span>
                            </div>
                            <div class="bg-gray-100 border border-gray-300 rounded-lg h-32 flex items-center justify-center">
                                <span class="text-gray-500">Surat tersimpan</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="alasan-penolakan-persetujuan" class="block text-sm font-medium text-gray-700">
                            Alasan Penolakan (Opsional)
                        </label>
                        <textarea id="alasan-penolakan-persetujuan" name="alasan" rows="3" placeholder="Jika menolak, masukkan alasan di sini..." class="mt-1 block w-full rounded-md border border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        <p class="mt-2 text-sm text-gray-500">
                            Kosongkan jika Anda menyetujui. Wajib diisi jika Anda menolak.
                        </p>
                    </div>
                </div> 
            </div> 
            <div class="p-6 bg-gray-50 rounded-b-lg flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3 gap-2">
                <button class="flex-1 bg-green-500 text-white py-2 px-3 rounded-lg text-sm font-medium hover:bg-green-600">Setujui</button>
                <button class="flex-1 bg-red-500 text-white py-2 px-3 rounded-lg text-sm font-medium hover:bg-red-600">Tolak</button>
            </div>
        </div>
</form>