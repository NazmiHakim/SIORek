@extends('layouts.app')

@section('title', 'Edit Barang')
@section('subtitle', 'Perbarui detail untuk barang Anda')

@section('content')

<div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-900">Edit: {{ $item->nama_item }}</h2>
        <a href="{{ route('barang') }}" class="text-sm text-gray-500 hover:text-gray-700">Kembali</a>
    </div>

    <form method="POST" action="{{ route('barang.update', $item->id) }}" enctype="multipart/form-data">
        @csrf          
        @method('PUT')

        <div class="space-y-5">
            
            <div>
                <label for="nama_item" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                <input 
                    type="text" 
                    name="nama_item" 
                    id="nama_item" 
                    value="{{ old('nama_item', $item->nama_item) }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                    required
                    {{-- UX: Auto trim --}}
                    onblur="this.value = this.value.trim()"
                >
                @error('nama_item')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                <input 
                    type="text" 
                    name="kategori" 
                    id="kategori" 
                    value="{{ old('kategori', $item->kategori) }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
                @error('kategori')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="jumlah_total" class="block text-sm font-medium text-gray-700">Jumlah Total Barang</label>
                
                @php
                    $minStok = (isset($jumlahDipinjam) && $jumlahDipinjam > 1) ? $jumlahDipinjam : 1;
                @endphp

                <input 
                    type="number" 
                    name="jumlah_total" 
                    id="jumlah_total" 
                    value="{{ old('jumlah_total', $item->jumlah_total) }}" 
                    min="{{ $minStok }}" 
                    max="10000"
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                    required
                    {{-- Prevent invalid chars --}}
                    onkeydown="return event.keyCode !== 69 && event.keyCode !== 189 && event.keyCode !== 109"
                    {{-- Prevent value lower than minimum logic --}}
                    oninput="
                        if(parseInt(this.value) > 10000) this.value = 10000;
                        if(this.value !== '' && parseInt(this.value) < { $minStok }) {
                            // Opsional: alert user or just force value
                            // this.value = {{ $minStok }}; 
                        }
                    "
                >
                
                @if(isset($jumlahDipinjam) && $jumlahDipinjam > 0)
                    <div class="mt-2 p-2 bg-yellow-50 border border-yellow-200 rounded text-xs text-yellow-800 flex items-start">
                        <i class="fa-solid fa-circle-info mt-0.5 mr-2"></i>
                        <span>
                            <strong>Perhatian:</strong> Saat ini ada <strong>{{ $jumlahDipinjam }}</strong> unit yang sedang dipinjam/aktif. 
                            Anda tidak dapat mengurangi total stok di bawah jumlah tersebut.
                        </span>
                    </div>
                @endif
            </div>
            
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea 
                    id="deskripsi" 
                    name="deskripsi" 
                    rows="3" 
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >{{ old('deskripsi', $item->deskripsi) }}</textarea>
            </div>

            <div x-data="{ fileError: null }">
                <label for="foto_item" class="block text-sm font-medium text-gray-700">Ganti Foto (Opsional)</label>
                
                @if($item->foto_item)
                    <div class="mb-2 mt-2">
                        <p class="text-xs text-gray-500 mb-1">Foto saat ini:</p>
                        <img src="{{ asset('storage/' . $item->foto_item) }}" alt="Foto Barang" class="h-20 w-20 object-cover rounded border">
                    </div>
                @endif

                <input 
                    type="file" 
                    name="foto_item" 
                    id="foto_item" 
                    accept="image/jpeg, image/png, image/jpg, image/webp"
                    class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                    @change="
                        const file = $el.files[0];
                        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
                        const maxSize = 5 * 1024 * 1024;

                        if (file) {
                            if (!validTypes.includes(file.type)) {
                                fileError = 'Format file harus JPG, PNG, atau WEBP';
                                $el.value = '';
                            } else if (file.size > maxSize) {
                                fileError = 'Ukuran file terlalu besar (Max 5MB)';
                                $el.value = ''; 
                            } else {
                                fileError = null;    
                            }
                        }
                    "
                >
                <p x-show="fileError" x-text="fileError" class="mt-1 text-sm text-red-600 font-medium"></p>
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WEBP. Maksimal: 5MB.</p>
            </div>
        </div>

        <div class="pt-6 border-t mt-4">
            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-bold hover:bg-blue-700 transition-colors shadow-md">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@endsection