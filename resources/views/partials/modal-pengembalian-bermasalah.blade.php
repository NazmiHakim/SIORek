<div
    x-show="isPengembalianBermasalahModalOpen"
    style="display: none;"
    x-cloak
    @keydown.escape.window="isPengembalianBermasalahModalOpen = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <div 
        @click="isPengembalianBermasalahModalOpen = false" 
        class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
        x-show="isPengembalianBermasalahModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
    </div>

        <div
            x-show="isPengembalianBermasalahModalOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative bg-white w-full max-w-lg rounded-lg shadow-xl">
            
            <div class="p-6 overflow-auto max-h-[85vh] mt-4 sm:mt-0">
                <div class="mb-4">
                    <h2 class="text-xl font-bold text-red-600">Pengembalian Bermasalah</h2>
                    <p class="text-gray-600">Pemilik menandai pengembalian ini bermasalah.</p>
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
                        <span class="bg-danger-fill text-danger-stroke border border-danger-stroke text-sm font-medium px-3 py-1 rounded-full inline-block">
                            Bermasalah
                        </span>
                    </div>

                    {{-- Keterangan pemilik --}}
                    <div>
                        <h3 class="text-lg font-bold text-red-600 mb-2">Keterangan dari Pemilik</h3>
                        <p class="text-gray-700 bg-red-50 border border-red-200 p-3 rounded-lg" x-text="selectedLoan.keterangan_sanksi ? selectedLoan.keterangan_sanksi : 'Tidak ada keterangan.'"></p>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-bold text-biru-primary mb-3">Bukti Kondisi Barang</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm font-medium text-gray-700 block mb-1">Foto Kondisi Awal</span>
                                <a :href="'/storage/' + selectedLoan.foto_kondisi_awal" target="_blank" x-show="selectedLoan.foto_kondisi_awal">
                                    <img :src="'/storage/' + selectedLoan.foto_kondisi_awal" alt="Foto Kondisi Awal" class="w-full h-32 object-cover rounded-lg border border-gray-300">
                                </a>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700 block mb-1">Foto Kondisi Akhir</span>
                                <a :href="'/storage/' + selectedLoan.foto_kondisi_akhir" target="_blank" x-show="selectedLoan.foto_kondisi_akhir">
                                    <img :src="'/storage/' + selectedLoan.foto_kondisi_akhir" alt="Foto Kondisi Akhir" class="w-full h-32 object-cover rounded-lg border border-gray-300">
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="p-6 bg-gray-50 rounded-b-lg flex flex-col gap-3" x-show="selectedLoan">  
                <template x-if="selectedLoan.pemilik_id == {{ Auth::id() }}">
                    
                    <form :action="'/loan/selesaikan-masalah/' + selectedLoan.id" method="POST" class="w-full">
                        @csrf
                        <button type="submit" 
                            class="w-full px-6 py-3 bg-green-600 text-white rounded-lg font-bold hover:bg-green-700 shadow-md transition-colors"
                            onclick="return confirm('Apakah masalah sudah selesai (misal: ganti rugi diterima)? Transaksi akan ditutup.')">
                            <i class="fa-solid fa-check-circle mr-2"></i> Masalah Selesai & Tutup Transaksi
                        </button>
                        <p class="text-xs text-center text-gray-500 mt-2">Klik ini jika peminjam sudah bertanggung jawab.</p>
                    </form>
                </template>

                <template x-if="selectedLoan.peminjam_id == {{ Auth::id() }}">
                    <div class="w-full text-center p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-800 text-sm">
                        <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                        Silakan hubungi pemilik barang untuk menyelesaikan masalah/sanksi ini.
                    </div>
                </template>

                <button @click="isPengembalianBermasalahModalOpen = false" type="button" class="w-full px-6 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50">
                    Tutup
                </button>
            </div>
        </div>
</div>