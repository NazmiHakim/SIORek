<div
    x-show="isSiapDIambilModalOpen"
    style="display: none;"
    x-cloak
    @keydown.escape.window="isSiapDIambilModalOpen = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <div @click="isSiapDIambilModalOpen = false" class="fixed inset-0 bg-black bg-opacity-50" ...></div>

    <form
        method="POST" 
        {{-- Kita buat action-nya dinamis --}}
        :action="'/loan/konfirmasi-pengambilan/' + (selectedLoan ? selectedLoan.id : '')"
        enctype="multipart/form-data" {{-- Wajib untuk upload file --}}
        x-show="isSiapDIambilModalOpen"
        x-transition:enter="ease-out duration-300" ...
        class="relative bg-white w-full max-w-lg rounded-lg shadow-xl">

        @csrf

        <div class="flex items-start justify-between p-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Konfirmasi Pengambilan Barang</h2>
                <p class="text-gray-600 mt-1">
                    Ambil barang: <span class="font-semibold" x-text="selectedLoan ? selectedLoan.item.nama_item : '...' "></span>
                </p>
            </div>
            <button type="button" @click="isSiapDIambilModalOpen = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-times fa-lg"></i></button>
        </div>

        <div class="px-6 space-y-4">
            <p class="text-sm text-gray-700">
                Sebagai bukti serah terima, silakan upload foto kondisi awal barang yang Anda terima dari pemilik.
            </p>
            
            <div x-data="{ fileError: null }">
                <label for="foto_kondisi_awal" class="block text-sm font-medium text-gray-700">Foto Kondisi Awal</label>
                
                <input type="file" 
                       name="foto_kondisi_awal" 
                       id="foto_kondisi_awal" 
                       class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                       accept="image/png, image/jpeg" 
                       required
                       @change="
                           const file = $el.files[0];
                           const limit = 10 * 1024 * 1024; 
                           
                           if(file && file.size > limit) {
                               fileError = 'Ukuran Gambar Melebihi Batas Maksimal!';
                               $el.value = ''; 
                           } else {
                               fileError = null; 
                           }
                       "
                >

                <p x-show="fileError" 
                   x-text="fileError" 
                   class="mt-1 text-sm text-red-600 font-medium">
                </p>
                
                <p class="mt-1 text-xs text-gray-500">
                    Format: PNG/JPG, Maksimal: 5MB
                </p>
            </div>
        </div>

        <div class="p-6 bg-gray-50 rounded-b-lg mt-6">
            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700">
                Konfirmasi Telah Diambil
            </button>
        </div>
    </form>
</div>