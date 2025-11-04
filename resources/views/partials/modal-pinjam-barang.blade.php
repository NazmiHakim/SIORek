<div
    x-show="isPinjamModalOpen"
    style="display: none;"
    x-cloak
    @keydown.escape.window="isPinjamModalOpen = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4">
    
    <div 
        @click="isPinjamModalOpen = false"
        class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
        x-show="isPinjamModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
    </div>

        <form
            method="POST" 
            action="/link-untuk-ajukan-peminjaman" 
            enctype="multipart/form-data"
            x-show="isPinjamModalOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative bg-white w-full max-w-lg rounded-lg shadow-xl">
            
            <div class="flex items-start justify-between p-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Pinjam Barang</h2>
                    <p class="text-gray-600 mt-1">Isi detail peminjaman untuk Proyektor Epson EB-X41</p>
                </div>
                <button type="button" @click="isPinjamModalOpen = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-times fa-lg"></i></button>
            </div>

            <div class="px-6 space-y-5">
                <div x-data="{ count: 1, max: 3 }">
                    <label for="jumlah_unit" class="block text-sm font-medium text-gray-700">
                        Jumlah Unit <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-3 mt-1">
                        <input type="number" id="jumlah_unit" name="jumlah" min="1" :max="max" class="w-20 px-3 py-1 text-center rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>                    
                        <span class="text-sm text-gray-600">Tersedia: 3 unit</span>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                        <div class="relative mt-1">
                            <input type="date"  name="tanggal_mulai"  id="tanggal_mulai"  class="w-full px-3 py-1 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Pilih tanggal" required>
                        </div>
                    </div>
                    <div>
                        <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                        <div class="relative mt-1">
                            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="w-full px-3 py-1 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Pilih tanggal" required>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                        <i class="fa-regular fa-id-card mr-2"></i>Foto KTP <span class="text-red-500">*</span>
                    </label>
                    <label for="foto-ktp"  class="mt-1 flex justify-center w-full h-36 px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md cursor-pointer hover:border-blue-500">
                        <div class="space-y-1 text-center flex flex-col justify-center items-center">
                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400"></i> 
                            <p class="text-sm text-gray-600">Klik untuk upload foto KTP</p>
                        </div>
                    </label>
                    <input id="foto-ktp" name="foto_ktp" type="file" class="hidden" required>
                </div>
                
                <div>
                    <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                        <i class="fa-regular fa-file-lines mr-2"></i> Surat Peminjaman <span class="text-red-500">*</span>
                    </label>
                    <label for="surat-peminjaman"  class="mt-1 flex justify-center w-full h-36 px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md cursor-pointer hover:border-blue-500">
                        <div class="space-y-1 text-center flex flex-col justify-center items-center">
                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400"></i> 
                            <p class="text-sm text-gray-600">Klik untuk upload surat peminjaman</S>
                        </div>
                    </label>
                    <input id="surat-peminjaman" name="surat_peminjaman" type="file" class="hidden" required>
                </div>
            </div>

            <div class="p-6 bg-gray-50 rounded-b-lg">
                <button type="submit"  class="w-full bg-blue-600 text-white py-2.5 px-4 rounded-lg font-medium hover:bg-blue-700">Ajukan Peminjaman</button>
            </div>
        </form>
</div>