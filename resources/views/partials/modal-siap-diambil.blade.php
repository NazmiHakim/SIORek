<div
    x-show="isSiapDIambilModalOpen"
    style="display: none;"
    x-cloak
    @keydown.escape.window="isSiapDIambilModalOpen = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <div @click="isSiapDIambilModalOpen = false" class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
        x-show="isSiapDIambilModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
    </div>

    <div 
        x-show="isSiapDIambilModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative bg-white w-full max-w-lg rounded-lg shadow-xl"
    >
        <!-- headernya -->
        <div class="flex items-start justify-between p-6 border-b">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Status Pengambilan Barang</h2>
                <p class="text-gray-600 mt-1">
                    Barang: <span class="font-semibold" x-text="selectedLoan ? selectedLoan.item.nama_item : '...' "></span>
                </p>
            </div>
            <button type="button" @click="isSiapDIambilModalOpen = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-times fa-lg"></i></button>
        </div>

        <!-- bodinya -->
        <div class="p-6">
            {{-- status boleh upload foto --}}
            <template x-if="selectedLoan && selectedLoan.status == 'disetujui'">
                <form
                    method="POST" 
                    :action="'/loan/konfirmasi-pengambilan/' + (selectedLoan ? selectedLoan.id : '')"
                    enctype="multipart/form-data"
                    
                    {{-- js ajax --}}
                    x-data="{ 
                        isLoading: false, 
                        errors: {}, 
                        async submitForm() {
                            this.isLoading = true;
                            this.errors = {}; 
                            let formData = new FormData(this.$el); 
                            try {
                                let response = await fetch(this.$el.action, {
                                    method: 'POST',
                                    headers: {'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                                    body: formData
                                });
                                if (response.ok) { window.location.reload(); } 
                                else if (response.status === 422) {
                                    let data = await response.json();
                                    this.errors = data.errors;
                                } else { alert('Terjadi kesalahan.'); }
                            } catch (e) { alert('Gagal koneksi.'); } finally { this.isLoading = false; }
                        }
                    }"
                    @submit.prevent="submitForm"
                >
                    @csrf
                    
                    {{-- menampilkan pesan dari foto yang ditolak --}}
                    <div x-show="selectedLoan.foto_kondisi_awal" class="mb-4 bg-red-50 border border-red-200 p-3 rounded-lg text-red-700 text-sm">
                        <strong><i class="fa-solid fa-triangle-exclamation mr-1"></i> Foto Ditolak!</strong><br>
                        Pemilik menolak foto sebelumnya. Silakan upload ulang foto yang lebih jelas.
                    </div>

                    <div class="space-y-4">
                        <p class="text-sm text-gray-700">
                            Silakan upload foto kondisi awal barang untuk konfirmasi pengambilan.
                        </p>
                        <div x-data="{ fileError: null }">
                            <label for="foto_kondisi_awal" class="block text-sm font-medium text-gray-700">Foto Kondisi Awal</label>
                            <input type="file" name="foto_kondisi_awal" id="foto_kondisi_awal" 
                                class="mt-1 block w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                accept="image/png, image/jpeg, image/jpg" required
                                @change="
                                    const file = $el.files[0];
                                    const limit = 5 * 1024 * 1024;
                                    if(file) {
                                        if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
                                            fileError = 'File harus berupa gambar!'; $el.value = '';
                                        } else if (file.size > limit) {
                                            fileError = 'Maksimal 5MB!'; $el.value = '';
                                        } else { fileError = null; }
                                    }
                                "
                            >
                            <p x-show="fileError" x-text="fileError" class="mt-1 text-sm text-red-600 font-medium"></p>
                            <p x-show="errors.foto_kondisi_awal" x-text="errors.foto_kondisi_awal" class="text-red-500 text-xs mt-1"></p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700 flex justify-center items-center" :disabled="isLoading">
                            <span x-show="!isLoading">Upload & Konfirmasi</span>
                            <span x-show="isLoading">Mengupload...</span>
                        </button>
                    </div>
                </form>
            </template>

            {{-- tidak bisa upload karena menunggu konfirm pemilik --}}
            <template x-if="selectedLoan && selectedLoan.status == 'menunggu_konfirmasi_pemilik'">
                <div class="text-center py-8">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100 mb-4">
                        <i class="fa-solid fa-clock text-3xl text-yellow-600"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Menunggu Verifikasi Pemilik</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Anda sudah mengupload bukti foto. Mohon tunggu pemilik memverifikasi kondisi barang sebelum status berubah menjadi "Sedang Dipinjam".
                    </p>
                    
                    <div class="mt-6 border rounded-lg p-2">
                        <p class="text-xs text-left text-gray-400 mb-2">Foto yang Anda kirim:</p>
                        <img :src="'/storage/' + selectedLoan.foto_kondisi_awal" class="w-full h-48 object-cover rounded">
                    </div>
                </div>
            </template>

        </div>
    </div>
</div>