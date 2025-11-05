<div
    x-show="isMenungguDiambilModalOpen"
    style="display: none;"
    x-cloak
    @keydown.escape.window="isMenungguDiambilModalOpen = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <div 
        @click="isMenungguDiambilModalOpen = false" 
        class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
        x-show="isMenungguDiambilModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
    </div>

        <div
            x-show="isMenungguDiambilModalOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative bg-white    max-w-lg rounded-lg shadow-xl ">
            
            <div class="p-6 overflow-auto max-h-[85vh] mt-4 sm:mt-0">
                <div class="mb-4">
                    <h2 class="text-xl font-bold text-biru-primary">Detail Peminjaman</h2>
                    <p class="text-gray-600">Informasi lengkap peminjaman barang</p>
                </div>
        
                <div class="space-y-4">
                    
                    <div>
                        <span class="text-sm text-gray-500 block">Nama Barang</span>
                        <span class="text-md font-semibold text-gray-800">Kabel HDMI</span>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500 block">Jumlah Unit</span>
                        <span class="text-md font-semibold text-gray-800">3 unit</span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <span class="text-sm text-gray-500 block">Peminjam</span>
                            <span class="text-md font-semibold text-gray-800">Koperasi Mahasiswa</span>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500 block">Pemilik</span>
                            <span class="text-md font-semibold text-gray-800">Himpunan Mahasiswa Teknologi Informasi</span>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500 block">Tanggal Mulai</span>
                            <span class="text-md font-semibold text-gray-800">Senin, 28 November 2025</span>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500 block">Tanggal Selesai</span>
                            <span class="text-md font-semibold text-gray-800">Minggu, 2 Desember 2025</span>
                        </div>
                    </div>
        
                    <div>
                        <span class="text-sm text-gray-500 block mb-2">Status</span>
                        <span class="bg-caution-fill text-yellow-500 border-caution-stroke  border text-sm font-medium px-3 py-1 rounded-full inline-block">Menunggu Pengambilan Barang Oleh Peminjam</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-biru-primary mb-3">Dokumen Peminjaman</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm font-medium text-gray-700 block mb-1">Foto KIM</span>
                                <div class="bg-gray-100 border border-gray-300 rounded-lg h-32 flex items-center justify-center">
                                    <span class="text-gray-500">Foto KIM tersimpan</span>
                                </div>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700 block mb-1">Surat Peminjaman</span>
                                <div class="bg-gray-100 border border-gray-300 rounded-lg h-32 flex items-center justify-center">
                                    <span class="text-gray-500">Surat tersimpan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 text-right">
                <button @click="isMenungguDiambilModalOpen = false" type="button" class="w-full  px-6 py-2 bg-white border border-black rounded-lg text-gray-700 font-medium hover:bg-gray-50">Tutup</button>
            </div>
        </div>
</div>