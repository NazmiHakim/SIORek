<div
    x-show="isTambahPenggunaModalOpen"
    style="display: none;"
    x-cloak
    @keydown.escape.window="isTambahPenggunaModalOpen = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <div 
        @click="isTambahPenggunaModalOpen = false" 
        class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
        x-show="isTambahPenggunaModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
    </div>

    <form
        method="POST" 
        action="/link-untuk-tambah-pengguna" 
        enctype="multipart/form-data"
        x-show="isTambahPenggunaModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative bg-white w-full max-w-lg rounded-lg shadow-xl"
    >
        <div class="max-h-[85vh] overflow-y-auto">
            
            <div class="flex items-start justify-between p-6 border-b">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Tambah Akun Baru</h2>
                    <p class="text-gray-600 mt-1">Masukkan Informasi untuk Akun Baru</p>
                </div>
                <button type="button" @click="isTambahPenggunaModalOpen = false" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-times fa-lg"></i>
                </button>
            </div>

            <div class="p-6 space-y-4">
                
                <div>
                    <label for="nama_organisasi" class="block text-sm font-medium text-gray-700">Nama Organisasi</label>
                    <input type="text" name="nama_organisasi" id="nama_organisasi" placeholder="Masukkan nama Organisasi" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                
                <div>
                    <label for="program_studi" class="block text-sm font-medium text-gray-700">Program Studi</label>
                    <input type="text" name="program_studi" id="program_studi" placeholder="Masukkan Nama Program Studi" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="fakultas" class="block text-sm font-medium text-gray-700">Fakultas</label>
                    <input type="text" name="fakultas" id="fakultas" placeholder="Contoh: Teknik, Kehutanan, dll" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="nama_pj" class="block text-sm font-medium text-gray-700">Nama Penanggung Jawab</label>
                    <input type="text" name="nama_pj" id="nama_pj" placeholder="Masukkan Nama Penanggung Jawab" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                
                <div>
                    <label for="nomor_pj" class="block text-sm font-medium text-gray-700">Nomor Penanggung Jawab</label>
                    <input type="tel" name="nomor_pj" id="nomor_pj" placeholder="Masukkan Nomor Penanggung Jawab" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                
                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="3" placeholder="Masukkan Alamat dari Lokasi Sekretariat Organisasi" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                </div>
                
                <div>
                    <label for="logo-upload" class="block text-sm font-medium text-gray-700">
                        Logo Organisasi
                    </label>
                    <label for="logo-upload" class="mt-2 flex justify-center w-full h-36 px-6 pt-5 pb-6 border-2 border-gray-300 bg-gray-100 p-2 border-dashed rounded-md cursor-pointer hover:border-blue-500">
                        <div class="space-y-1 text-center flex flex-col justify-center items-center">
                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400"></i>
                            <p class="text-sm text-gray-600">Klik untuk upload Logo Organisasi</p>
                        </div>
                    </label>
                    <input id="logo-upload" name="logo" type="file" class="hidden">
                </div>
            </div> 
        </div> 
        <div class="p-6 border-t rounded-b-lg">
            <button class="p-2 rounded-lg bg-biru-primary text-white font-bold w-full" type="submit" >Simpan Akun</button>
        </div>
    </form>
</div>