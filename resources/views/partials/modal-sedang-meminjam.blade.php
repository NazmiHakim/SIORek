<div
    x-show="isSedangMeminjamModalOpen"
    style="display: none;"
    x-cloak
    @keydown.escape.window="isSedangMeminjamModalOpen = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <div @click="isSedangMeminjamModalOpen = false" class="fixed inset-0 bg-black bg-opacity-50" ...></div>

    <form
        method="POST" 
        {{-- Kita buat action-nya dinamis --}}
        :action="'/loan/ajukan-pengembalian/' + (selectedLoan ? selectedLoan.id : '')"
        enctype="multipart/form-data" {{-- Wajib untuk upload file --}}
        x-show="isSedangMeminjamModalOpen"
        x-transition:enter="ease-out duration-300" ...
        class="relative bg-white w-full max-w-lg rounded-lg shadow-xl">

        @csrf

        <div class="flex items-start justify-between p-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Ajukan Pengembalian Barang</h2>
                <p class="text-gray-600 mt-1">
                    Barang: <span class="font-semibold" x-text="selectedLoan ? selectedLoan.item.nama_item : '...' "></span>
                </p>
            </div>
            <button type="button" @click="isSedangMeminjamModalOpen = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-times fa-lg"></i></button>
        </div>

        <div class="px-6 space-y-4">
            <p class="text-sm text-gray-700">
                Untuk menyelesaikan peminjaman, silakan **upload foto kondisi akhir barang** yang akan Anda kembalikan.
            </p>
            <div>
                <label for="foto_kondisi_akhir" class="block text-sm font-medium text-gray-700">Foto Kondisi Akhir</label>
                <input type="file" name="foto_kondisi_akhir" id="foto_kondisi_akhir" 
                       class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" 
                       required>
            </div>

            {{-- Menampilkan foto kondisi awal sebagai perbandingan --}}
            <div x-show="selectedLoan && selectedLoan.foto_kondisi_awal">
                <span class="text-sm text-gray-500 block">Foto Kondisi Awal (Perbandingan)</span>
                <img :src="'/storage/' + selectedLoan.foto_kondisi_awal" alt="Foto Awal" class="mt-2 rounded-md border max-h-48">
            </div>
        </div>

        <div class="p-6 bg-gray-50 rounded-b-lg mt-6">
            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700">
                Ajukan Pengembalian
            </button>
        </div>
    </form>
</div>