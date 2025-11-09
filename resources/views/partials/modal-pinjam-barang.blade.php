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
        action="{{ route('loan.store') }}" {{-- Kita akan buat rute ini nanti --}}
        enctype="multipart/form-data" {{-- Wajib untuk upload file --}}
        x-show="isPinjamModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative bg-white w-full max-w-lg rounded-lg shadow-xl max-h-[90vh] overflow-y-auto">

        @csrf

        <div class="flex items-start justify-between p-6 sticky top-0 bg-white z-10">
            <div>
                <h2 class="text-xl font-bold text-gray-900">
                    Pinjam Barang: <span x-text="selectedItem ? selectedItem.nama_item : '...' "></span>
                </h2>
                <p class="text-gray-600 mt-1">
                    Pemilik: <span x-text="selectedItem ? selectedItem.user.username : '...' "></span>
                </p>
            </div>
            <button type="button" @click="isPinjamModalOpen = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-times fa-lg"></i></button>
        </div>

        <div class="px-6 space-y-4">
            
            <input type="hidden" name="item_id" :value="selectedItem ? selectedItem.id : ''">

            <div>
                <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah yang Dipinjam</label>
                {{-- batasi jumlah pinjam berdasarkan stok --}}
                <input type="number" name="jumlah" id="jumlah" value="1" min="1" :max="selectedItem ? selectedItem.jumlah_total : 1" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                <p class="text-xs text-gray-500 mt-1">
                    Stok tersedia: <span x-text="selectedItem ? selectedItem.jumlah_total : '...' "></span> unit
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <div>
                    <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai</glabel>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
            </div>

            <div>
                <label for="foto_kim" class="block text-sm font-medium text-gray-700">Upload KTM/KTP (Foto)</label>
                <input type="file" name="foto_kim" id="foto_kim" class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
            </div>
            
            <div>
                <label for="surat_peminjaman" class="block text-sm font-medium text-gray-700">Upload Surat Peminjaman (PDF)</label>
                <input type="file" name="surat_peminjaman" id="surat_peminjaman" accept="application/pdf" class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
            </div>
        </div>

        <div class="p-6 bg-gray-50 rounded-b-lg mt-6">
            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700">
                Kirim Permintaan
            </button>
        </div>
    </form>
</div>