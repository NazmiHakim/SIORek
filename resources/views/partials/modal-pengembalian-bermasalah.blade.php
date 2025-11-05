<div 
    x-show="isPengembalianBermasalahModalOpen"
    style="display: none;"
    x-cloak
    @keydown.escape.window="isPengembalianBermasalahModalOpen = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <div 
        @click="isPengembalianBermasalahModalOpen = false" 
        class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
        x-show="isPengembalianBermasalahModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
    </div>

        <div
            x-show="isPengembalianBermasalahModalOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative bg-white w-full max-w-lg rounded-lg shadow-xl">

            <div class="sm:max-h-[85vh] max-h-[78vh] mt-4 sm:mt-0 overflow-y-auto">
                <div class="p-6">
                    <div class="mb-4 flex justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-biru-primary">Pengembalian Bermasalah</h2>
                            <p class="text-gray-600">Informasi lengkap Pengembalian barang</p>
                        </div>
                    </div>


                    <div class="space-y-4">
                        <div>
                            <span class="text-sm text-gray-500 block">Nama Barang</span>
                            <span class="text-md font-semibold text-gray-800">Kamera Fujifilm XA-10</span>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500 block">Jumlah Unit</span>
                            <span class="text-md font-semibold text-gray-800">1 unit</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm text-gray-500 block">Peminjam</span>
                                <span class="text-md font-semibold text-gray-800">Kampung Seni Budaya </span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 block">Pemilik</span>
                                <span class="text-md font-semibold text-gray-800">Himpunan Mahasiswa Teknologi Informasi</span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 block">Tanggal Mulai</span>
                                <span class="text-md font-semibold text-gray-800">Senin, 1 November 2025</span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 block">Tanggal Selesai</span>
                                <span class="text-md font-semibold text-gray-800">Minggu, 5 November 2025</span>
                            </div>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500 block mb-2">Status</span>
                            <span class="bg-danger-fill text-danger-stroke border-danger-stroke border text-sm font-medium px-3 py-1 rounded-full inline-block">Mendapatkan Sanksi</span>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500 block mb-2">Sanksi</span>
                            <p class="text-sm">Membayarkan Denda sebesar Rp 20.000,00 akibat keterlambatan pengembalian selama 2 hari. Silahkan hubungi nomor 0823-5204-3533 untuk menyelesaikan sanksi</p>
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
                        <h3 class="text-lg font-bold text-biru-primary mb-3">Perbandingan Foto Kondisi</h3>
                        <div class="mb-3">
                            <span class="text-sm font-medium text-gray-700 block mb-1">Foto Kondisi Awal</span>
                            <div class="bg-gray-100 border border-gray-300 rounded-lg h-40 flex items-center justify-center">
                                <span class="text-gray-500">Foto awal tersimpan</span>
                            </div>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-700 block mb-1">Foto Kondisi Terakhir</span>
                            <div class="bg-gray-100 border border-gray-300 rounded-lg h-40 flex items-center justify-center">
                                <span class="text-gray-500">Foto akhir tersimpan</span>
                            </div>
                        </div>
                    </div>
                </div> 
            </div> 
            <div class="p-6 bg-gray-50 rounded-b-lg ">
                <button @click="isPengembalianBermasalahModalOpen = false" class="w-full py-2 px-3 rounded-lg text-sm font-medium border border-black">Tutup</button>
            </div>
        </div>
    </div>