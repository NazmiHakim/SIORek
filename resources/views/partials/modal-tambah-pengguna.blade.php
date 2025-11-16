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
        action="{{ route('admin.pengguna.store') }}"
        enctype="multipart/form-data" {{-- Wajib untuk upload file --}}
        x-show="isTambahPenggunaModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative bg-white w-full max-w-lg rounded-lg shadow-xl"
    >
        @csrf
        <!-- untuk scroll -->
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

            @if ($errors->any())
                <div class="p-6">
                    <div class="rounded-lg bg-red-100 p-4 text-sm text-red-700">
                        <strong>Ada yang salah</strong>
                        <ul class="list-disc pl-5 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- data login akun -->
            <div class="p-6 space-y-4 border-b">
                <h3 class="text-lg font-medium text-gray-900">Data Login</h3>
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Username <span class="text-red-500">*</span></label>
                    <input type="text" name="username" id="username" placeholder="Masukkan username unik" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" required value="{{ old('username') }}">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" id="password" placeholder="Minimal 6 karakter" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Role <span class="text-red-500">*</span></label>
                    <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>

            <!-- profil akun -->
            <div class="p-6 space-y-4">
                <h3 class="text-lg font-medium text-gray-900">Data Profil</h3>
                
                <div>
                    <label for="nama_organisasi" class="block text-sm font-medium text-gray-700">Nama Organisasi</label>
                    <input type="text" name="nama_organisasi" id="nama_organisasi" placeholder="Masukkan nama Organisasi" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ old('nama_organisasi') }}">
                </div>
                
                <div>
                    <label for="program_studi" class="block text-sm font-medium text-gray-700">Program Studi</label>
                    <input type="text" name="program_studi" id="program_studi" placeholder="Masukkan Nama Program Studi" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ old('program_studi') }}">
                </div>
                
                <div>
                    <label for="fakultas" class="block text-sm font-medium text-gray-700">Fakultas</label>
                    <input type="text" name="fakultas" id="fakultas" placeholder="Contoh: Teknik, Kehutanan, dll" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ old('fakultas') }}">
                </div>
                
                <div>
                    <label for="nama_pj" class="block text-sm font-medium text-gray-700">Nama Penanggung Jawab</label>
                    <input type="text" name="nama_pj" id="nama_pj" placeholder="Masukkan Nama Penanggung Jawab" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ old('nama_pj') }}">
                </div>
                
                <div>
                    <label for="nomor_pj" class="block text-sm font-medium text-gray-700">Nomor Penanggung Jawab</label>
                    <input type="tel" name="nomor_pj" id="nomor_pj" placeholder="Masukkan Nomor Penanggung Jawab" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ old('nomor_pj') }}">
                </div>
                
                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="3" placeholder="Masukkan Alamat dari Lokasi Sekretariat Organisasi" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('alamat') }}</textarea>
                </div>
                
                <div>
                    <label for="logo" class="block text-sm font-medium text-gray-700">Logo Organisasi</label>
                    <input id="logo" name="logo" type="file" class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
            </div> 
        </div> 
        <div class="p-6 border-t rounded-b-lg">
            <button class="p-2 rounded-lg bg-biru-primary text-white font-bold w-full" type="submit" >Simpan Akun</button>
        </div>
    </form>
</div>