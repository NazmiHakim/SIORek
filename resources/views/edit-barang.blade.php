@extends('layouts.app')

@section('title', 'Edit Barang')
@section('subtitle', 'Perbarui detail untuk barang Anda')

@section('content')

<!-- form edit -->
<div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-xl mx-auto">
    <h2 class="text-xl font-bold text-gray-900 mb-6">Edit: {{ $item->nama_item }}</h2>

    <form method="POST" action="{{ route('barang.update', $item->id) }}">
        @csrf          
        @method('PUT')

        <div class="space-y-4">
            <div>
                <label for="nama_item" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                {{-- menampilkan data lama di value --}}
                <input type="text" name="nama_item" id="nama_item" value="{{ old('nama_item', $item->nama_item) }}" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
            </div>
            
            <div>
                <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                <input type="text" name="kategori" id="kategori" value="{{ old('kategori', $item->kategori) }}" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            
            <div>
                <label for="jumlah_total" class="block text-sm font-medium text-gray-700">Jumlah Barang</label>
                <input type="number" name="jumlah_total" id="jumlah_total" value="{{ old('jumlah_total', $item->jumlah_total) }}" min="1" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
            </div>
            
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="3" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('deskripsi', $item->deskripsi) }}</textarea>
            </div>
        </div>

        <div class="pt-6">
            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@endsection