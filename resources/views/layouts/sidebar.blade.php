<aside class="fixed inset-y-0 left-0 z-20 w-64 bg-white shadow-md transform transition-transform duration-300 ease-in-out" :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    <div class="px-6 pt-2">
        <a href="#" class="flex items-center space-x-2 text-blue-600">
            <img src="{{asset('images/siorek.png')}}" alt="" class="w-44">
        </a>
    </div>

    <nav class="mt-4 px-4">
        <h3 class="text-xs uppercase text-gray-500 font-semibold mb-2">Menu</h3>
        <ul class="space-y-2">
            @if(Auth::user()->role == 'admin')
                <!-- ini admin -->
                <li>
                    <a href="{{route('daftarPenggunaAdmin')}}" 
                    @class([
                        'flex items-center space-x-3 px-4 py-3 rounded-lg',
                        'bg-blue-600 text-white shadow-lg' => Route::is('daftarPenggunaAdmin'),
                        'text-gray-700 hover:bg-gray-100' => !Route::is('daftarPenggunaAdmin')
                    ])>
                        <i class="fa-solid fa-users w-6 text-center"></i>
                        <span class="font-medium">Daftar Pengguna</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{route('rekabTransaksiAdmin')}}" 
                    @class([
                        'flex items-center space-x-3 px-4 py-3 rounded-lg',
                        'bg-blue-600 text-white shadow-lg' => Route::is('rekabTransaksiAdmin'),
                        'text-gray-700 hover:bg-gray-100' => !Route::is('rekabTransaksiAdmin')
                    ])>
                        <i class="fa-solid fa-clock-rotate-left w-6 text-center"></i>
                        <span class="font-medium">Rekap Transaksi</span>
                    </a>
                </li>

            @else 
            <!-- ini user -->
                <li>
                    <a href="{{route('dashboard')}}" 
                    @class([
                        'flex items-center space-x-3 px-4 py-3 rounded-lg',
                        'bg-blue-600 text-white shadow-lg' => Route::is('dashboard'),
                        'text-gray-700 hover:bg-gray-100' => !Route::is('dashboard')
                    ])>
                        <i class="fa-solid fa-table-columns w-6 text-center"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{route('barang')}}" 
                    @class([
                        'flex items-center space-x-3 px-4 py-3 rounded-lg',
                        'bg-blue-600 text-white shadow-lg' => Route::is('barang'),
                        'text-gray-700 hover:bg-gray-100' => !Route::is('barang')
                    ])>
                        <i class="fa-solid fa-archive w-6 text-center"></i>
                        <span class="font-medium">Barang Saya</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{route('daftar-pengguna')}}" 
                    @class([
                        'flex items-center space-x-3 px-4 py-3 rounded-lg',
                        'bg-blue-600 text-white shadow-lg' => Route::is('daftar-pengguna'),
                        'text-gray-700 hover:bg-gray-100' => !Route::is('daftar-pengguna')
                    ])>
                        <i class="fa-solid fa-users w-6 text-center"></i>
                        <span class="font-medium">Daftar Pengguna</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{route('riwayat-peminjaman')}}" 
                    @class([
                        'flex items-center space-x-3 px-4 py-3 rounded-lg',
                        'bg-blue-600 text-white shadow-lg' => Route::is('riwayat-peminjaman'),
                        'text-gray-700 hover:bg-gray-100' => !Route::is('riwayat-peminjaman')
                    ])>
                        <i class="fa-solid fa-clock-rotate-left w-6 text-center"></i>
                        <span class="font-medium">Riwayat Peminjaman</span>
                    </a>
                </li>

            @endif
        </ul>
    </nav>
</aside>