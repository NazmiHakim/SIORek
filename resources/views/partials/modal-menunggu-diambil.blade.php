<div
    x-show="isMenungguDiambilModalOpen"
    style="display: none;"
    x-cloak
    @keydown.escape.window="isMenungguDiambilModalOpen = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <div @click="isMenungguDiambilModalOpen = false" class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
        x-show="isMenungguDiambilModalOpen" 
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    </div>

    <div x-show="isMenungguDiambilModalOpen" class="relative bg-white w-full max-w-lg rounded-lg shadow-xl overflow-hidden"
         x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" 
         x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 scale-95">
        
        <div class="p-6 overflow-auto max-h-[85vh]">
            {{-- Header --}}
            <div class="mb-4 flex justify-between items-start border-b pb-4">
                <div>
                    <h2 class="text-xl font-bold text-biru-primary">Detail Peminjaman</h2>
                    <p class="text-gray-600 text-sm">Informasi lengkap status pengambilan barang.</p>
                </div>
                <button type="button" @click="isMenungguDiambilModalOpen = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-times fa-lg"></i></button>
            </div>
    
            <div class="space-y-5" x-show="selectedLoan">
                
                {{-- informasi barang --}}
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500 block">Barang</span>
                        <span class="font-semibold text-gray-800" x-text="selectedLoan.item.nama_item"></span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Jumlah</span>
                        <span class="font-semibold text-gray-800" x-text="selectedLoan.jumlah + ' unit'"></span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Peminjam</span>
                        <span class="font-semibold text-gray-800" x-text="selectedLoan.peminjam.username"></span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Status</span>
                        <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded inline-block" 
                              x-text="selectedLoan.status == 'disetujui' ? 'Menunggu Peminjam' : 'Perlu Verifikasi'"></span>
                    </div>
                </div>

                <hr class="border-gray-200">
                                
                {{-- peminjam belum upload foto --}}
                <template x-if="selectedLoan.status == 'disetujui'">
                    <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-lg text-center">
                        
                        {{-- tampil foto yang di tolak --}}
                        <template x-if="selectedLoan.foto_kondisi_awal">
                            <div class="mb-3 p-2 bg-white rounded border border-red-200 inline-block">
                                <p class="text-red-600 font-bold text-xs mb-1">Ditolak Sebelumnya:</p>
                                <a :href="'/storage/' + selectedLoan.foto_kondisi_awal" target="_blank">
                                    <img :src="'/storage/' + selectedLoan.foto_kondisi_awal" class="w-20 h-20 object-cover rounded opacity-50 hover:opacity-100">
                                </a>
                            </div>
                        </template>

                        <div class="mt-2">
                            <i class="fa-solid fa-hourglass-half text-yellow-600 text-2xl mb-2"></i>
                            <p class="text-gray-800 font-semibold text-sm">Menunggu Peminjam</p>
                            <p class="text-xs text-gray-600">Peminjam belum mengunggah foto bukti pengambilan.</p>
                        </div>
                    </div>
                </template>

                {{-- (peminjam menunggu konfirmasi dari pemilik ) --}}
                <template x-if="selectedLoan.status == 'menunggu_konfirmasi_pemilik'">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        
                        <div class="flex items-center gap-2 mb-3 text-blue-800">
                            <i class="fa-solid fa-camera"></i>
                            <h3 class="font-bold text-sm">Verifikasi Foto Bukti</h3>
                        </div>

                        <div class="mb-4 relative group">
                            <a :href="'/storage/' + selectedLoan.foto_kondisi_awal" target="_blank" class="block overflow-hidden rounded-lg border border-gray-300 shadow-sm">
                                <img :src="'/storage/' + selectedLoan.foto_kondisi_awal" class="w-full h-56 object-cover transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-opacity flex items-center justify-center">
                                    <span class="bg-white text-xs px-2 py-1 rounded shadow opacity-0 group-hover:opacity-100 transition-opacity">Klik untuk perbesar</span>
                                </div>
                            </a>
                            <p class="text-xs text-center text-gray-500 mt-1">Foto yang diunggah oleh peminjam</p>
                        </div>
                        
                        <form method="POST" :action="'/loan/validasi-barang-keluar/' + selectedLoan.id">
                            @csrf
                            <div class="flex gap-3">
                                <button type="submit" name="action" value="tolak" 
                                        class="flex-1 bg-white border-2 border-red-500 text-red-600 py-2 px-4 rounded-lg font-bold text-sm hover:bg-red-50 transition"
                                        onclick="return confirm('Yakin ingin menolak? Peminjam harus upload ulang.')">
                                    <i class="fa-solid fa-xmark mr-1"></i> Tolak
                                </button>
                                
                                <button type="submit" name="action" value="setujui" 
                                        class="flex-1 bg-green-600 text-white py-2 px-4 rounded-lg font-bold text-sm hover:bg-green-700 shadow-md transition">
                                    <i class="fa-solid fa-check mr-1"></i> Terima & Serahkan
                                </button>
                            </div>
                        </form>
                    </div>
                </template>

            </div>
        </div>
        
        <div class="p-4 bg-gray-50 border-t text-right">
            <button @click="isMenungguDiambilModalOpen = false" type="button" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 text-sm font-medium hover:bg-gray-100">Tutup</button>
        </div>
    </div>
</div>