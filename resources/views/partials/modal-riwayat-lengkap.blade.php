<div
    x-show="isRiwayatModalOpen"
    style="display: none;"
    x-cloak
    @keydown.escape.window="isRiwayatModalOpen = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <div 
        @click="isRiwayatModalOpen = false" 
        class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
        x-show="isRiwayatModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
    </div>

        <div
        x-show="isRiwayatModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative bg-white w-full max-w-4xl rounded-lg shadow-xl"
        x-data="{ tab: 'saya_meminjam' }">
        
        <div class="flex flex-col sm:flex-row justify-between items-center p-4 sm:p-6 bg-gray-50 rounded-t-lg">
            
            <div class="relative bg-gray-200 rounded-full  p-1 flex">
                <div 
                    class="absolute top-1 left-1 w-1/2 h-[calc(100%-8px)] bg-white rounded-full shadow-md transition-transform duration-300 ease-in-out"
                    :class="{
                        'translate-x-0': tab === 'saya_meminjam',
                        'translate-x-full': tab === 'orang_lain'
                    }">
                </div>
                <button type="button" @click="tab = 'saya_meminjam'" :class="tab === 'saya_meminjam' ? 'text-gray-900' : 'text-gray-600'" class="relative z-10  py-1 px-8 text-center font-medium rounded-full transition-colors duration-300 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-arrow-up"></i> Saya Meminjam
                </button>
                <button type="button" @click="tab = 'orang_lain'" :class="tab === 'orang_lain' ? 'text-gray-900' : 'text-gray-600'" class="relative z-10  px-8 py-1 text-center font-medium rounded-full transition-colors duration-300 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-arrow-down"></i> Dipinjam Orang Lain
                </button>
            </div>

            <button type="button" class="w-full sm:w-auto mt-4 sm:mt-0 bg-blue-600 text-white py-2 px-4 rounded-lg text-sm font-medium hover:bg-blue-700">Download</button>
        </div>

        <div class="max-h-[70vh] overflow-y-auto">
            
            <div x-show="tab === 'saya_meminjam'" class="p-6">
                <h3 class="text-xl font-semibold mb-4">Barang yang Saya Pinjam</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pemilik</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Pinjam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Kembali</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dikembalikan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Proyektor Epson EB-X41</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2 unit</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rektorat</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">28/10/2025</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2/11/2025</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Kabel HDMI 5m</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3 unit</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Orbit</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">18/10/2025</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">22/10/2025</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-medium">21/10/2025</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div x-show="tab === 'orang_lain'" style="display: none;" class="p-6">
                <h3 class="text-xl font-semibold mb-4">Barang yang Dipinjam Orang Lain</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peminjam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Pinjam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Kembali</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dikembalikan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Tripod Manfrotto</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2 unit</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">BEM Fakultas Teknik</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">30/10/2025</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3/11/2025</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Whiteboard Portable</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2 unit</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Himpunan Mahasiswa...</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">20/10/2025</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">25/10/2025</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-medium">
                                    26/10/2025
                                    <span class="block text-xs">Terlambat 1 hari</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div> 
    </div> 
</div>