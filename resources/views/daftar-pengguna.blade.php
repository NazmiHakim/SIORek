@extends('layouts.app')

@section('title', 'Daftar Pengguna')
@section('subtitle', 'Lihat barang yang dimiliki pengguna lain')

@section('content')
@if ($errors->any())
    <div class="mb-4 rounded-lg bg-red-100 p-4 text-sm text-red-700">
        <p class="font-bold">Oops! Ada beberapa masalah dengan input Anda:</p>
        <ul class="mt-2 list-inside list-disc">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="mb-4 rounded-lg bg-green-100 p-4 text-sm text-green-700">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="mb-4 rounded-lg bg-red-100 p-4 text-sm text-red-700">
        {{ session('error') }}
    </div>
@endif

<div class="flex justify-between items-center mb-6">
    <div> 
        <h1 class="text-3xl font-bold text-biru-primary">@yield('title')</h1>
        <p class="text-biru-primary">@yield('subtitle')</p>
    </div>
</div>
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

        <aside class="lg:col-span-2 space-y-6">
            
            <div class="bg-white p-4 rounded-lg shadow-md max-h-[75vh] overflow-y-auto">
                <h2 class="text-xl font-semibold flex items-center gap-2 mb-8 text-biru-primary"><i class="fa-solid fa-users w-6 text-center"></i>Pengguna</h2>
                <div class="space-y-4">
                    @forelse ($users as $user)
                            <a href="#" class="flex items-center space-x-3 p-2 hover:bg-gray-100 rounded-lg">
                                {{-- avatar placeholder --}}
                                <img src="https://ui-avatars.com/api/?name={{ $user->username }}&background=random" alt="{{ $user->username }}" class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $user->username }}</h4>
                                    {{-- Kita bisa tampilkan role jika perlu --}}
                                    <p class="text-sm text-gray-500 capitalize">{{ $user->role }}</p>
                                </div>
                            </a>
                        @empty
                            <p class="text-sm text-gray-500 p-2">Tidak ada pengguna lain yang ditemukan.</p>
                    @endforelse
                </div>
            </div>
        </aside>

        <section class="lg:col-span-3 space-y-6">
            
            <div class="bg-white p-4 rounded-lg shadow-md max-h-[75vh] overflow-y-auto">
                <h2 class="text-xl font-semibold text-biru-primary flex items-center gap-2 mb-8"><i class="fa-solid fa-archive w-6 text-cente"></i>Semua Barang</h2>
                    <div x-data="{isPinjamModalOpen: false, selectedItem: null}" class="flex flex-wrap gap-8">                        
                        @forelse ($items as $item)
                                <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col justify-between">
                                    <div class="p-5">
                                        <div class="flex justify-between items-start mb-2">
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $item->nama_item }}</h3>
                                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-3 py-1 rounded-full border border-gray-300 flex-shrink-0">{{ $item->kategori ?? 'Lainnya' }}</span>
                                        </div>
                                        
                                        <p class="text-sm font-medium text-gray-700">{{ $item->user->username ?? '...' }}</p>
                                        <p class="text-sm text-gray-500 mb-4">{{ $item->deskripsi }}</p>
                                        
                                        <div>
                                            <span class="text-sm text-gray-500">Tersedia</span>
                                            <div class="flex justify-between items-center">
                                                {{-- tampilkan jumlah tersedia/total --}}
                                                <span class="text-lg font-bold"
                                                    :class="{
                                                        'text-green-500': {{ $item->jumlah_tersedia }} > 0,
                                                        'text-red-600': {{ $item->jumlah_tersedia }} <= 0
                                                    }">
                                                    {{ $item->jumlah_tersedia }} / {{ $item->jumlah_total }} unit
                                                </span>
                                                
                                                {{-- tampilkan status --}}
                                                @if ($item->jumlah_tersedia > 0)
                                                    <span class="bg-green-400 text-white text-xs font-semibold px-3 py-1 rounded-md">Tersedia</span>
                                                @else
                                                    <span class="bg-red-100 text-red-800 text-xs font-semibold px-3 py-1 rounded-full">Tidak Tersedia</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-gray-50 p-4">
                                        {{-- nonaktifkan tombol jika stok habis --}}
                                        @if ($item->jumlah_tersedia > 0)
                                            <button @click="isPinjamModalOpen = true; selectedItem = {{ $item->toJson() }}" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700">
                                                Pinjam
                                            </button>
                                        @else
                                            <button class="w-full bg-gray-300 text-gray-500 py-2 px-4 rounded-lg font-medium cursor-not-allowed" disabled>
                                                Pinjam
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">Belum ada barang yang tersedia dari pengguna lain.</p>
                            @endforelse

                        @include('partials.modal-pinjam-barang')  
                </div>
                
                </div>
        </section>
        
    </div>
@endsection