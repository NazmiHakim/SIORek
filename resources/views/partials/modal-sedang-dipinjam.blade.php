<div
    x-show="isDetailDipinjamModalOpen"
    style="display: none;"
    x-cloak
    @keydown.escape.window="isDetailDipinjamModalOpen = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4">
    
    <div 
        @click="isDetailDipinjamModalOpen = false"
        class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
        x-show="isDetailDipinjamModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
    </div>

        <div 
            x-show="isDetailDipinjamModalOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative bg-white w-full max-w-lg rounded-lg shadow-xl">
            
            <div class="max-h-[85vh] mt-4 sm:mt-0 p-6 overflow-y-auto">
                
                <div>
                    <div class="mb-4">
                        <h2 class="text-xl font-bold text-biru-primary">Detail Peminjaman</h2>
                        <p class="text-gray-600">Informasi lengkap peminjaman barang</p>
                    </div>

                    <div class="space-y-4 mb-4">
                        
                        <div>
                            <span class="text-sm text-gray-500 block">Nama Barang</span>
                            <span class="text-md font-semibold text-gray-800">Gimbal Stabilizer</span>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500 block">Jumlah Unit</span>
                            <span class="text-md font-semibold text-gray-800">1 unit</span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm text-gray-500 block">Peminjam</span>
                                <span class="text-md font-semibold text-gray-800">Kampung Seni Budaya</span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 block">Pemilik</span>
                                <span class="text-md font-semibold text-gray-800">Himpunan Mahasiswa Teknologi Informasi</span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 block">Tanggal Mulai</span>
                                <span class="text-md font-semibold text-gray-800">Jumat, 28 November 2025</span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 block">Tanggal Selesai</span>
                                <span class="text-md font-semibold text-gray-800">Selasa, 2 Desember 2025</span>
                            </div>
                        </div>

                        <div>
                            <span class="text-sm text-gray-500 block mb-2">Status</span>
                            <span class="bg-white text-biru-primary border border-notice-stroke text-sm font-medium px-3 py-1 rounded-full inline-block">
                                Aktif
                            </span>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-biru-primary mb-3">Dokumen Peminjaman</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm font-medium text-gray-700 block mb-1">Foto KTP</span>
                                <div class="bg-gray-100 border border-gray-300 rounded-lg h-32 flex items-center justify-center">
                                    <span class="text-gray-500">Foto KTP tersimpan</span>
                                </div>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700 block mb-1">Surat Peminjaman</span>
                                <div class="bg-gray-100 border border-gray-300 rounded-lg h-32 flex items-center justify-center">
                                    <span class="text-gray-500">Surat tersimpan</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 mb-4">
                            <span class="text-sm font-medium text-gray-700 block mb-1">Foto Kondisi Awal Barang</span>
                            <div class="bg-gray-100 border border-gray-300 rounded-lg h-40 flex items-center justify-center">
                                <span class="text-gray-500">Foto kondisi barang tersimpan</span>
                            </div>
                        </div>
                    </div>
                </div> 
            </div> 
            <div class="p-6">
                <button type="button"  @click="isDetailDipinjamModalOpen = false" class="w-full px-6 py-2 bg-white border border-black rounded-lg text-gray-700 font-medium hover:bg-gray-50">Tutup</button>
            </div>
        </div> 
</div>