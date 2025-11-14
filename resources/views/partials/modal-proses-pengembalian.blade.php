<div
    x-show="isProsesPengembalianModalOpen"
    style="display: none;"
    x-cloak
    @keydown.escape.window="isProsesPengembalianModalOpen = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <div 
        @click="isProsesPengembalianModalOpen = false" 
        class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
        x-show="isProsesPengembalianModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
    </div>

        <div
            x-show="isProsesPengembalianModalOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative bg-white w-full max-w-lg rounded-lg shadow-xl">
            
            <div class="p-6 overflow-auto max-h-[85vh] mt-4 sm:mt-0">
                <div class="mb-4">
                    <h2 class="text-xl font-bold text-biru-primary">Proses Pengembalian</h2>
                    <p class="text-gray-600">Menunggu konfirmasi pengembalian dari pemilik.</p>
                </div>
        
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
                            <span class="text-sm text-gray-500 block">Pemilik</span>
                            <span class="text-md font-semibold text-gray-800" x-text="selectedLoan.pemilik.username"></span>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500 block">Tanggal Selesai</span>
                            <span class="text-md font-semibold text-gray-800" x-text="new Date(selectedLoan.tanggal_selesai).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })"></span>
                        </div>
                    </div>
        
                    <div>
                        <span class="text-sm text-gray-500 block mb-2">Status</span>
                        <span class="bg-white text-biru-primary border border-notice-stroke text-sm font-medium px-3 py-1 rounded-full inline-block">
                            Proses Pengembalian
                        </span>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-bold text-biru-primary mb-3">Bukti Kondisi Barang</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm font-medium text-gray-700 block mb-1">Foto Kondisi Awal</span>
                                <a :href="'/storage/' + selectedLoan.foto_kondisi_awal" target="_blank" x-show="selectedLoan.foto_kondisi_awal">
                                    <img :src="'/storage/' + selectedLoan.foto_kondisi_awal" alt="Foto Kondisi Awal" class="w-full h-32 object-cover rounded-lg border border-gray-300">
                                </a>
                                <span class="text-gray-500" x-show="!selectedLoan.foto_kondisi_awal">Tidak ada file.</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700 block mb-1">Foto Kondisi Akhir</span>
                                <a :href="'/storage/' + selectedLoan.foto_kondisi_akhir" target="_blank" x-show="selectedLoan.foto_kondisi_akhir">
                                    <img :src="'/storage/' + selectedLoan.foto_kondisi_akhir" alt="Foto Kondisi Akhir" class="w-full h-32 object-cover rounded-lg border border-gray-300">
                                </a>
                                <span class="text-gray-500" x-show="!selectedLoan.foto_kondisi_akhir">Tidak ada file.</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="p-6 text-right">
                <button @click="isProsesPengembalianModalOpen = false" type="button" class="w-full px-6 py-2 bg-white border border-black rounded-lg text-gray-700 font-medium hover:bg-gray-50">Tutup</button>
            </div>
        </div>
</div>