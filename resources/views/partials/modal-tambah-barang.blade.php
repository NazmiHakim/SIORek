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

        <div class="flex items-start justify-between p-6 bg-gray-50 rounded-t-lg border-b">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Tambah Barang Baru</h2>
                <p class="text-gray-600 mt-1">Tambahkan barang baru ke inventaris Anda</p>
            </div>
            <button type="button" @click="isTambahBarangModalOpen = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-times fa-lg"></i></button>
        </div>

        <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
            
            <div>
                <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang <span class="text-red-500">*</span></label>
                <input 
                    type="text"  
                    name="nama_item"  
                    id="nama_barang" 
                    maxlength="100"  
                    placeholder="Contoh: Kamera Canon EOS 5D" 
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                    required
                    x-on:blur="$el.value = $el.value.trim()"
                >
            </div>  
            
            <div>
                <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                <input type="text" name="kategori" id="kategori" maxlength="50" placeholder="Contoh: Elektronik, Logistik, P3K" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            
            <div>
                <label for="jumlah_barang" class="block text-sm font-medium text-gray-700">Jumlah Stok <span class="text-red-500">*</span></label>
                <input 
                    type="number" 
                    name="jumlah_total" 
                    id="jumlah_barang" 
                    value="1" 
                    min="1" 
                    max="10000" 
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                    required
                    onkeydown="return event.keyCode !== 69 && event.keyCode !== 189 && event.keyCode !== 109"
                    oninput="
                        if(this.value.length > 5) this.value = this.value.slice(0,5);
                        if(parseInt(this.value) > 10000) this.value = 10000; 
                        if(this.value < 1 && this.value !== '') this.value = 1;
                    " 
                >
            </div>
            
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="3" maxlength="500" placeholder="Deskripsikan kondisi atau spesifikasi barang (Max 500 karakter)" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
            </div>

            <div x-data="{ fileError: null }">
                <label for="foto_item" class="block text-sm font-medium text-gray-700">Foto Barang</label>
                <input 
                    type="file" 
                    name="foto_item" 
                    id="foto_item" 
                    accept="image/jpeg, image/png, image/jpg, image/webp" 
                    class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                    @change="
                        const file = $el.files[0];
                        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
                        const maxSize = 5 * 1024 * 1024; // 5MB
                        
                        if (file) {
                            if (!validTypes.includes(file.type)) {
                                fileError = 'Format file harus JPG, PNG, atau WEBP!';
                                $el.value = '';
                            } else if (file.size > maxSize) {
                                fileError = 'Ukuran gambar terlalu besar (Max 5MB)!';
                                $el.value = '';
                            } else {
                                fileError = null;
                            }
                        }
                    "
                >
                <p x-show="fileError" x-text="fileError" class="mt-1 text-sm text-red-600 font-medium"></p>
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WEBP. Maksimal: 5MB.</p>
            </div>
        </div>

        <div class="p-6 bg-gray-50 rounded-b-lg border-t">
            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                Simpan Barang
            </button>
        </div>
    </form>
</div>