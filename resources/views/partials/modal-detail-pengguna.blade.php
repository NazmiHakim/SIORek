<div
    x-show="isDetailPenggunaModalOpen"
    style="display: none;"
    x-cloak
    @keydown.escape.window="isDetailPenggunaModalOpen = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
>
    <div 
        @click="isDetailPenggunaModalOpen = false" 
        class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
        x-show="isDetailPenggunaModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
    </div>

        <div
            x-show="isDetailPenggunaModalOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative bg-white w-full max-w-lg rounded-lg shadow-xl">
            
            <div x-show="selectedUser" class="max-h-[85vh] overflow-y-auto">
                <div class="p-6">
                    <div class="mb-4">
                        <h2 class="text-xl font-bold text-biru-primary">Detail Akun Pengguna</h2>
                        <p class="text-gray-600">Informasi lengkap akun pengguna</p>
                    </div>

                    <div class="space-y-4">
                        
                        <div class="flex justify-between items-start space-x-4">
                            <div class="space-y-4 flex-1">
                                <div class="w-48">
                                    <span class="text-sm text-gray-500 block">Nama Organisasi</span>
                                    <span class="text-lg font-semibold text-gray-800" x-text="selectedUser.nama_organisasi || selectedUser.username"></span>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 block">Jenis</span>
                                    <span class="text-lg font-semibold text-gray-800" x-text="selectedUser.role"></span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <img x-show="selectedUser.logo" 
                                     :src="'/storage/' + selectedUser.logo" 
                                     alt="Logo" 
                                     class="w-32 h-32 rounded-full border-2 border-gray-200 object-cover">
                                <img x-show="!selectedUser.logo" 
                                     :src="'https://ui-avatars.com/api/?name=' + (selectedUser.nama_organisasi || selectedUser.username) + '&background=random&size=128'" 
                                     alt="Logo" 
                                     class="w-32 h-32 rounded-full border-2 border-gray-200 object-cover">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 pt-4">
                            <div>
                                <span class="text-sm text-gray-500 block">Fakultas</span>
                                <span class="text-md font-semibold text-gray-800" x-text="selectedUser.fakultas || 'Tidak ada data'"></span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 block">Program Studi</span>
                                <span class="text-md font-semibold text-gray-800" x-text="selectedUser.program_studi || 'Tidak ada data'"></span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 block">Nama Penanggung Jawab</span>
                                <span class="text-md font-semibold text-gray-800" x-text="selectedUser.nama_pj || 'Tidak ada data'"></span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 block">Nomor Penanggung Jawab</span>
                                <span class="text-md font-semibold text-gray-800" x-text="selectedUser.nomor_pj || 'Tidak ada data'"></span>
                            </div>
                            <div class="md:col-span-2">
                                <span class="text-sm text-gray-500 block">Alamat</span>
                                <span class="text-md font-semibold text-gray-800" x-text="selectedUser.alamat || 'Tidak ada data'"></span>
                            </div>
                        </div>
                    </div>
                </div> 
            </div> 
            <div class="p-6 bg-gray-50 border-t rounded-b-lg space-y-2">
            <!-- edit -->
            <button type="button" class="w-full px-6 py-2.5 bg-yellow-400 text-black rounded-lg text-sm font-medium hover:bg-yellow-500" disabled>Edit</button>
                <!-- button delete -->
                <button type="button" class="w-full px-6 py-2.5 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700"
                    @click.prevent="
                        if(confirm('Apakah Anda yakin ingin menghapus pengguna ' + selectedUser.username + '?')) {
                            document.getElementById('delete-user-form-' + selectedUser.id).submit();
                            isDetailPenggunaModalOpen = false;
                        }
                    ">
                    Hapus
                </button>
                
                <button @click="isDetailPenggunaModalOpen = false" type="button" class="w-full px-6 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 text-sm font-medium hover:bg-gray-50">Tutup</button>
            </div>
        </div> 
</div>