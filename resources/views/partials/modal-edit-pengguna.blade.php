<div
    x-show="isEditPenggunaModalOpen"
    style="display: none;"
    x-cloak
    @keydown.escape.window="isEditPenggunaModalOpen = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <div 
        @click="isEditPenggunaModalOpen = false" 
        class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
        x-show="isEditPenggunaModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
    </div>

    {{-- Form Edit Standar (Tanpa AJAX) --}}
    <form
        method="POST" 
        :action="selectedUser ? '{{ route('admin.pengguna.update', '') }}/' + selectedUser.id : '#'"
        enctype="multipart/form-data"
        x-show="isEditPenggunaModalOpen"
        {{-- 
            1. INISIALISASI STATE ALPINE DI FORM
            Kita butuh state ini di level form agar bisa diakses oleh Input Password DAN Tombol Submit
        --}}
        x-data="{ 
            passwordInput: '', 
            get isPasswordInvalid() { 
                // Invalid jika: ada isinya DAN panjangnya kurang dari 6
                return this.passwordInput.length > 0 && this.passwordInput.length < 6;
            }
        }"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative bg-white w-full max-w-lg rounded-lg shadow-xl"
    >
        @csrf
        @method('PUT')

        <div class="max-h-[85vh] overflow-y-auto" x-show="selectedUser">
            
            <div class="flex items-start justify-between p-6 border-b">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Edit Akun</h2>
                    <p class="text-gray-600 mt-1">Perbarui informasi akun pengguna.</p>
                </div>
                <button type="button" @click="isEditPenggunaModalOpen = false" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-times fa-lg"></i>
                </button>
            </div>

            @if ($errors->any())
                <div class="p-6 pb-0">
                    <div class="rounded-lg bg-red-100 p-4 text-sm text-red-700">
                        <strong>Oops! Ada yang salah:</strong>
                        <ul class="list-disc pl-5 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="p-6 space-y-4 border-b">
                <h3 class="text-lg font-medium text-gray-900">Data Login</h3>
                <div>
                    <label for="edit_username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" id="edit_username" 
                           class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                           :value="selectedUser ? selectedUser.username : ''" required>
                </div>
                
                <div>
                    <label for="edit_password" class="block text-sm font-medium text-gray-700">Password Baru (Opsional)</label>
                    <input type="password" 
                           name="password" 
                           id="edit_password" 
                           x-model="passwordInput" {{-- Hubungkan input dengan state Alpine --}}
                           placeholder="Isi hanya jika ingin mengganti password" 
                           class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors"
                           {{-- Ubah warna border jadi merah jika invalid --}}
                           :class="{'border-red-500 focus:border-red-500 focus:ring-red-500': isPasswordInvalid}">
                    
                    <p x-show="isPasswordInvalid" x-transition class="text-red-600 text-xs mt-1 font-medium">
                        <i class="fa-solid fa-circle-exclamation mr-1"></i>Password minimal harus 6 karakter.
                    </p>
                    <p x-show="!isPasswordInvalid && passwordInput.length === 0" class="text-xs text-gray-500 mt-1">
                        Kosongkan jika tidak ingin mengganti password.
                    </p>
                </div>
                
                <div>
                    <label for="edit_role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select id="edit_role" name="role" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="user" :selected="selectedUser && selectedUser.role === 'user'">User</option>
                        <option value="admin" :selected="selectedUser && selectedUser.role === 'admin'">Admin</option>
                    </select>
                </div>
            </div>

            <div class="p-6 space-y-4">
                <h3 class="text-lg font-medium text-gray-900">Data Profil</h3>
                
                <div>
                    <label for="edit_nama_organisasi" class="block text-sm font-medium text-gray-700">Nama Organisasi</label>
                    <input type="text" name="nama_organisasi" id="edit_nama_organisasi" :value="selectedUser ? selectedUser.nama_organisasi : ''" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="edit_program_studi" class="block text-sm font-medium text-gray-700">Program Studi</label>
                    <input type="text" name="program_studi" id="edit_program_studi" :value="selectedUser ? selectedUser.program_studi : ''" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="edit_fakultas" class="block text-sm font-medium text-gray-700">Fakultas</label>
                    <input type="text" name="fakultas" id="edit_fakultas" :value="selectedUser ? selectedUser.fakultas : ''" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="edit_nama_pj" class="block text-sm font-medium text-gray-700">Nama Penanggung Jawab</label>
                    <input type="text" name="nama_pj" id="edit_nama_pj" :value="selectedUser ? selectedUser.nama_pj : ''" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="edit_nomor_pj" class="block text-sm font-medium text-gray-700">Nomor Penanggung Jawab</label>
                    <input type="tel" name="nomor_pj" id="edit_nomor_pj" :value="selectedUser ? selectedUser.nomor_pj : ''" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="edit_alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea id="edit_alamat" name="alamat" rows="3" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" x-text="selectedUser ? selectedUser.alamat : ''"></textarea>
                </div>
                
                <div>
                    <label for="edit_logo" class="block text-sm font-medium text-gray-700">Ganti Logo (Opsional)</label>
                    
                    <!-- logo lama -->
                    <template x-if="selectedUser && selectedUser.logo">
                        <div class="mb-2 mt-1">
                            <p class="text-xs text-gray-500 mb-1">Logo Saat Ini:</p>
                            <img :src="'/storage/' + selectedUser.logo" class="w-16 h-16 rounded-full object-cover border">
                        </div>
                    </template>

                    <input id="edit_logo" name="logo" type="file" accept="image/* "class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG/WEBP, Maksimal: 2MB</p>
                </div>
            </div> 
        </div> 
        
        <!-- tombol simpan -->
        <div class="p-6 border-t rounded-b-lg">
            <button type="submit" 
                    {{-- Kunci tombol jika password invalid --}}
                    :disabled="isPasswordInvalid"
                    {{-- Ubah warna jadi abu-abu jika terkunci, kuning jika aktif --}}
                    :class="isPasswordInvalid ? 'bg-gray-300 cursor-not-allowed text-gray-500' : 'bg-yellow-400 hover:bg-yellow-500 text-black'"
                    class="p-2 rounded-lg font-bold w-full transition-colors">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>