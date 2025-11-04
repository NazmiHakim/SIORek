@extends('layouts.app')

@section('title', 'Barang Saya')
@section('subtitle', 'Selamat Datang di Halaman Barang')

@section('content')

<style>
    .fa-pen-to-square {
        color:goldenrod
    }
    .fa-trash {
        color:crimson 
    }
</style>

<div class="flex justify-between items-center mb-6">
    <div> 
        <h1 class="text-3xl font-bold text-biru-primary">@yield('title')</h1>
        <p class="text-biru-primary">@yield('subtitle')</p>
    </div>

    <div x-data="{isTambahBarangModalOpen: false}" class="flex justify-end mb-4">
        <a @click="isTambahBarangModalOpen = true" class="px-4 py-1.5 bg-biru-primary text-white rounded-md hover:bg-blue-700 transition cursor-pointer"><i class="fa-solid fa-plus"></i> Tambah Barang</a>
        @include('partials.modal-tambah-barang')
    </div>

</div>

<div class="flex flex-wrap gap-8 justify-center">
    @for ($i = 0; $i < 10; $i++)
    <div class="max-w-[300px] bg-white rounded-lg shadow-md overflow-hidden">
        <img src="https://picsum.photos/seed/picsum/200/300" alt="" class="h-[150px] w-full">
        <div class="p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Tripod Manfrotto</h2>
                
                <div class="flex space-x-3">
                    <a href=""><i class="fa-solid fa-pen-to-square"></i></a> 
                    <a href=""><i class="fa-solid fa-trash "></i></a>
                </div>
            </div>
        
            <div class="flex gap-2 mb-4">
                <span class="bg-gray-100 text-gray-800 text-xs font-medium px-3 py-1 rounded-full border border-gray-300">Fotografi</span>
                <span class="bg-green-500 text-white text-xs font-medium px-3 py-1 rounded-full">Tersedia</span>
            </div>
        
            <p class=" text-sm text-gray-600 mb-6">Tripod professional untuk kamera DSLR</p>
        
            <div class="grid grid-cols-3 gap-4 border-t border-gray-200 pt-4">
                <div>
                    <span class="text-sm text-gray-500 block">Jumlah Total</span>
                    <span class="text-lg font-bold text-gray-900">3 unit</span>
                </div>
                <div>
                    <span class="text-sm text-gray-500 block">Tersedia</span>
                    <span class="text-lg font-bold text-green-600">1 unit</span>
                </div>
                <div>
                    <span class="text-sm text-gray-500 block">Dipinjam</span>
                    <span class="text-lg font-bold text-blue-600">2 unit</span>
                </div>
            </div>
        </div>
    </div>
        
    @endfor
</div>

@endsection