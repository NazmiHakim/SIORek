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
                        <strong>Error, gagal</strong>
                        <ul class="list-disc pl-5 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="p-6 space-y-4">                
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" id="username" placeholder="Masukkan username" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" required value="{{ old('username') }}">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" placeholder="Minimal 6 karakter" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                
            </div> 
        </div> 
        <div class="p-6 border-t rounded-b-lg">
            <button class="p-2 rounded-lg bg-biru-primary text-white font-bold w-full" type="submit" >Simpan Akun</button>
        </div>
    </form>
</div>