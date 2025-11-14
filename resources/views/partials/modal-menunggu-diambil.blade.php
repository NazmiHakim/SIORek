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
            class="relative bg-white max-w-lg rounded-lg shadow-xl w-full">
            
            <div class="p-6 overflow-auto max-h-[85vh] mt-4 sm:mt-0">
                <div class="mb-4">
                    <h2 class="text-xl font-bold text-biru-primary">Detail Peminjaman</h2>
                    <p class="text-gray-600">Informasi lengkap peminjaman barang</p>
                </div>
        
                {{-- KONTEN DINAMIS --}}
                <div class="space-y-4" x-show="selectedLoan">
                    
                    <div>
                        <span class="text-sm text-gray-500 block">Nama Barang</span>
                        <span class="text-md font-semibold text-gray-800" x-text="selectedLoan.item.nama_item"></span>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500 block">Jumlah Unit</span>
                        <span class="text-md font-semibold text-gray-800" x-text="selectedLoan.jumlah + ' unit'"></span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <span class="text-sm text-gray-500 block">Peminjam</span>
                            <span class="text-md font-semibold text-gray-800" x-text="selectedLoan.peminjam.username"></span>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500 block">Pemilik</span>
                            <span class="text-md font-semibold text-gray-800" x-text="selectedLoan.pemilik.username"></span>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500 block">Tanggal Mulai</span>
                            <span class="text-md font-semibold text-gray-800" x-text="new Date(selectedLoan.tanggal_mulai).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })"></span>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500 block">Tanggal Selesai</span>
                            <span class="text-md font-semibold text-gray-800" x-text="new Date(selectedLoan.tanggal_selesai).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })"></span>
                        </div>
                    </div>
        
                    <div>
                        <span class="text-sm text-gray-500 block mb-2">Status</span>
                        <span class="bg-caution-fill text-yellow-500 border-caution-stroke border text-sm font-medium px-3 py-1 rounded-full inline-block">
                            Menunggu Diambil Peminjam
                        </span>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-bold text-biru-primary mb-3">Dokumen Peminjaman</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm font-medium text-gray-700 block mb-1">Foto KIM</span>
                                <a :href="'/storage/' + selectedLoan.foto_kim" target="_blank" x-show="selectedLoan.foto_kim">
                                    <img :src="'/storage/' + selectedLoan.foto_kim" alt="Foto KIM" class="w-full h-32 object-cover rounded-lg border border-gray-300">
                                </a>
                                <span class="text-gray-500" x-show="!selectedLoan.foto_kim">Tidak ada file.</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700 block mb-1">Surat Peminjaman</span>
                                <a :href="'/storage/' + selectedLoan.surat_peminjaman" target="_blank" class="flex items-center justify-center bg-gray-100 border border-gray-300 rounded-lg h-32 text-blue-600 underline hover:text-blue-800" x-show="selectedLoan.surat_peminjaman">
                                    Lihat Surat (PDF)
                                </a>
                                <span class="text-gray-500" x-show="!selectedLoan.surat_peminjaman">Tidak ada file.</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="p-6 text-right">
                <button @click="isMenungguDiambilModalOpen = false" type="button" class="w-full px-6 py-2 bg-white border border-black rounded-lg text-gray-700 font-medium hover:bg-gray-50">Tutup</button>
            </div>
        </div>
</div>