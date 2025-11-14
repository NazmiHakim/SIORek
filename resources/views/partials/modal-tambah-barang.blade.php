<div
    x-show="isTambahBarangModalOpen"
    style="display: none;"
    x-cloak
    @keydown.escape.window="isTambahBarangModalOpen = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <div 
        @click="isTambahBarangModalOpen = false" 
        class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
        x-show="isTambahBarangModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
    </div>

        <form
            method="POST" 
            action="{{ route('barang.store') }}"
            enctype="multipart/form-data"
            x-show="isTambahBarangModalOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative bg-white w-full max-w-lg rounded-lg shadow-xl">

            @csrf

            <div class="flex items-start justify-between p-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Tambah Barang Baru</h2>
                    <p class="text-gray-600 mt-1">Tambahkan barang baru ke inventaris Anda</p>
                </div>
                <button type="button" @click="isTambahBarangModalOpen = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-times fa-lg"></i></button>
            </div>

            <div class="px-6 space-y-4">
                <div>
                    <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                    <input type="text"  name="nama_item"  id="nama_barang"  placeholder="Masukkan nama barang" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                
                <div>
                    <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <input type="text"  name="kategori" id="kategori"  placeholder="Contoh: Elektronik, Fotografi, dll" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="jumlah_barang" class="block text-sm font-medium text-gray-700">Jumlah Barang</label>
                    <input  type="number"  name="jumlah_total"  id="jumlah_barang"  value="1" min="1" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea  id="deskripsi" name="deskripsi" rows="3" placeholder="Deskripsikan barang Anda" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                </div>
                <div>
                    <label for="foto_item" class="block text-sm font-medium text-gray-700">Foto Barang (Opsional)</label>
                    <input type="file" name="foto_item" id="foto_item" class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
            </div>

            <div class="p-6 bg-gray-50 rounded-b-lg">
                <button type="submit"  class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700"> Simpan Barang</button>
            </div>
        </form>
</div>