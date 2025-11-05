<form
    method="POST" 
    action="/link-upload-anda" 
    enctype="multipart/form-data"
    x-show="isSiapDIambilModalOpen"
    style="display: none;"
    x-cloak
    @keydown.escape.window="isSiapDIambilModalOpen = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <div 
        @click="isSiapDIambilModalOpen = false" 
        class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
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
            class="relative bg-white w-full max-w-lg rounded-lg shadow-xl">

            <div class="sm:max-h-[85vh] max-h-[78vh] overflow-y-auto">
                <div class="p-6">
                    <div class="mb-4">
                        <h2 class="text-xl font-bold text-biru-primary">Siap Diambil</h2>
                        <p class="text-gray-600">Informasi lengkap peminjaman barang</p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <span class="text-sm text-gray-500 block">Nama Barang</span>
                            <span class="text-md font-semibold text-gray-800">Laptop Stand</span>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500 block">Jumlah Unit</span>
                            <span class="text-md font-semibold text-gray-800">1 unit</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm text-gray-500 block">Peminjam</span>
                                <span class="text-md font-semibold text-gray-800">Himpunan Mahasiswa Teknologi Informasi</span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 block">Pemilik</span>
                                <span class="text-md font-semibold text-gray-800">Rektorat</span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 block">Tanggal Mulai</span>
                                <span class="text-md font-semibold text-gray-800">Senin, 1 Desember 2025</span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 block">Tanggal Selesai</span>
                                <span class="text-md font-semibold text-gray-800">Minggu, 5 Desember 2025</span>
                            </div>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500 block mb-2">Status</span>
                            <span class="bg-caution-fill text-yellow-500 border-caution-stroke border text-sm font-medium px-3 py-1 rounded-full inline-block">Menunggu Pengambilan Barang Oleh Peminjam</span>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div>
                        <h3 class="text-lg font-bold text-biru-primary mb-3">Dokumen Peminjaman</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm font-medium text-gray-700 block mb-1">Foto KIM</span>
                                <div class="bg-gray-100 border border-gray-300 rounded-lg h-32 flex items-center justify-center">
                                    <span class="text-gray-500">Foto KIM tersimpan</span>
                                </div>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700 block mb-1">Surat Peminjaman</span>
                                <div class="bg-gray-100 border border-gray-300 rounded-lg h-32 flex items-center justify-center">
                                    <span class="text-gray-500">Surat tersimpan</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-bold text-biru-primary mb-3">Upload Foto Kondisi Awal</h3>
                        <div>
                            <label for="file-upload" class="mt-2 flex justify-center w-full h-48 px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md cursor-pointer hover:border-blue-500">
                                <div class="space-y-1 text-center flex flex-col justify-center items-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l-3 3m3-3l3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                                    </svg>
                                    <p class="text-sm text-gray-600">Klik untuk upload kondisi barang</p>
                                    <p class="text-xs text-gray-500">PNG, JPG atau JPEG</p>
                                </div>
                            </label>
                            <input id="file-upload" name="foto_barang" type="file" class="hidden">
                        </div>
                        <div class="bg-blue-50 border rounded-md border-blue-400 p-4 mt-4">
                            <p class="text-sm text-biru-primary ">
                                <strong>Informasi:</strong> Foto ini akan digunakan sebagai dokumentasi kondisi barang saat Anda menerima barang dari pemilik.
                            </p>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="p-6  rounded-b-lg flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3">
                <button @click="isSiapDIambilModalOpen = false" type="button" class="w-full flex-1 sm:w-auto mt-2 sm:mt-0 px-6 py-2 bg-white border border-black rounded-lg text-gray-700 font-medium hover:bg-gray-50">Tutup</button>
                <button type="submit" class="w-full flex-1 sm:w-auto bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700">Konfirmasi Pengambilan</button>
            </div>
        </div> 
</form> 