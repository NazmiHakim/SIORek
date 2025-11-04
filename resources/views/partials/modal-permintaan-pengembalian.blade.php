<form
    method="POST"
    action="/link-konfirmasi-pengembalian" 
    x-show="isPermintaanPengembalianModalOpen"
    style="display: none;"
    x-cloak
    @keydown.escape.window="isPermintaanPengembalianModalOpen = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <div 
        @click="isPermintaanPengembalianModalOpen = false" 
        class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
        x-show="isPermintaanPengembalianModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
    </div>

        <div
            x-show="isPermintaanPengembalianModalOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative bg-white w-full max-w-lg rounded-lg shadow-xl">
            
            <div class="sm:max-h-[85vh] max-h-[75vh] mt-4 sm:mt-0 overflow-y-auto p-6">
                <div class="">
                    <div class="mb-4 flex justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-biru-primary">Konfirmasi Pengembalian</h2>
                            <p class="text-gray-600">Periksa barang dan konfirmasi pengembalian</p>
                        </div>
                        <button type="button" @click="isPermintaanPengembalianModalOpen = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-times fa-lg"></i></button>
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
                            <span class="bg-caution-fill text-yellow-500 border-caution-stroke border text-sm font-medium px-3 py-1 rounded-full inline-block">
                                Menunggu Konfirmasi Pengembalian Dari Pemilik
                            </span>
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
                        <h3 class="text-lg font-bold text-biru-primary mb-3">Perbandingan Foto Kondisi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm font-medium text-gray-700 block mb-1">Foto Kondisi Awal</span>
                                <div class="bg-gray-100 border border-gray-300 rounded-lg h-40 flex items-center justify-center">
                                    <span class="text-gray-500">Foto awal tersimpan</span>
                                </div>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700 block mb-1">Foto Kondisi Terakhir</span>
                                <div class="bg-gray-100 border border-gray-300 rounded-lg h-40 flex items-center justify-center">
                                    <span class="text-gray-500">Foto akhir tersimpan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="alasan-sanksi" class="block text-sm font-medium text-gray-700">
                            Alasan Sanksi (Opsional)
                        </label>
                        <textarea id="alasan-sanksi" name="sanksi" rows="3" placeholder="Jika ada kerusakan, masukkan alasan sanksi di sini..." class="mt-1 block w-full rounded-md border border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        <p class="mt-2 text-sm text-gray-500">
                            Kosongkan jika kondisi barang sesuai dan disetujui.
                        </p>
                    </div>
                </div> 
            </div> 
            <div class="p-6 bg-gray-50 rounded-b-lg flex flex-col-reverse sm:flex-row  sm:space-x-3">
                <button type="submit" name="action" value="tolak_sanksi" class="w-full flex-1 sm:w-auto mt-2 sm:mt-0 px-6 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700">Tolak / Beri Sanksi</button>
                <button type="submit" name="action" value="setuju" class="w-full flex-1 sm:w-auto mt-2 sm:mt-0 px-6 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700">Setujui Pengembalian</button>
            </div>
        </div> 
</form>