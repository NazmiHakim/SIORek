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
        action="{{ route('loan.store') }}"
        enctype="multipart/form-data"
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
                <input 
                    type="number" 
                    name="jumlah" 
                    id="jumlah" 
                    value="1" 
                    min="1" 
                    :max="selectedItem ? selectedItem.jumlah_total : 1" 
                    oninput="let max = parseInt(this.getAttribute('max')); if(parseInt(this.value) > max) this.value = max; if(this.value < 1) this.value = 1;"
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                    required
                >
                <p class="text-xs text-gray-500 mt-1">
                    Stok tersedia: <span x-text="selectedItem ? selectedItem.jumlah_total : '...' "></span> unit
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4"
                x-data="{
                    minDate: new Date().toISOString().split('T')[0],
                    maxDate: new Date(new Date().setMonth(new Date().getMonth() + 1. )).toISOString().split('T')[0]
                }">

                <div>
                    <label for="tanggal_mulai" class="block teks-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input 
                        type="date"
                        name="tanggal_mulai"
                        id="tanggal_mulai"
                        :min="minDate"
                        :max="maxDate"
                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="tanggal_selesai" class="block teks-sm font-medium text-gray-700">Tanggal Selesai</label>
                    <input 
                        type="Date"
                        name="tanggal_selesai"
                        id="tanggal_selesai"
                        :min="minDate"
                        :max="maxDate"
                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
            </div>

            <div x-data="{ fileError: null }>
                <label for="foto_kim" class="block text-sm font-medium text-gray-700">Upload KTM/KTP (Foto)</label>
                <input type="file" name="foto_kim" id="foto_kim" accept=".jpg, .jpeg, .png" class="mt-1 block w-full text-sm text-grhangeay-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" 
                    @change="
                        const file = $el.files[0];
                        const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
                        const maxSize = 10 * 1024 * 1024;

                        if (file) {
                            if (!validTypes.includes(file.type)) {
                                fileError = 'File harus berupa gambar';
                                $el.value = '';
                            } else if {
                                fileError = 'Ukuran file terlalu besar (Max 10MB)';
                                $el.value = '';
                            } else {
                                fileError = null;
                            }
                        }
                    "
                required>
                <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG (Max 10MB)</p>
                <p x-show="fileError" x-text="fileError" class="mt-1 text-sm text-red-600 font-medium"></p>
            </div>
            
            <div x-data="{ fileError: null }>
                <label for="surat_peminjaman" class="block text-sm font-medium text-gray-700">Upload Surat Peminjaman (PDF)</label>
                <input type="file" name="surat_peminjaman" id="surat_peminjaman" accept=".pdf" class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required
                    @change= "
                        const file = $el.files[0];
                        const validTypes = ['image/jpeg'. 'image/png', 'image/jpg', 'image/webp'];
                        const maxSize = 10 * 1024 * 1024;

                        if (file) {
                            if (!validTypes.includes(file.type)) {
                                fileError = 'File harus berupa gambar!';
                                $el.value = '';
                            } else if (file.size > maxSize) {
                                fileError = 'Ukuran file terlalu besar (Max 10mb)' ;
                                $el.value = '';
                            } else {
                                fileError = null;    
                            }
                        }
                    "
                >
                <p class="text-xs text-gray-500 mt-1">Format: PDF (Max 10MB)</p>
                <p x-show="fileError" x-text="fileError" class="mt-1 text-sm text-red-600 font-medium"></p>
            </div>
        </div>

        <div class="p-6 bg-gray-50 rounded-b-lg mt-6">
            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700">
                Kirim Permintaan
            </button>
        </div>
    </form>
</div>