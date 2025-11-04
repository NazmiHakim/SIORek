@extends('layouts.app')

@section('title', 'Daftar Pengguna')
@section('subtitle', 'Lihat barang yang dimiliki pengguna lain')

@section('content')

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
                    
                    <div>
                        <h3 class="text-xs uppercase text-gray-500 font-semibold mb-2">Rektorat</h3>
                        <a href="#" class="flex items-center space-x-3 p-2 hover:bg-gray-100 rounded-lg">
                            <img src="{{ asset('images/logo-rektorat.png') }}" alt="Rektorat" class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <h4 class="font-semibold text-gray-900">Rektorat</h4>
                                <p class="text-sm text-gray-500">rektorat@university.ac.id</p>
                            </div>
                        </a>
                    </div>
                    
                    <div>
                        <h3 class="text-xs uppercase text-gray-500 font-semibold mb-2">Organisasi Mahasiswa</h3>
                        <div class="space-y-1">
                            <a href="#" class="flex items-center space-x-3 p-2 hover:bg-gray-100 rounded-lg">
                                <img src="{{ asset('images/logo-bem.png') }}" alt="BEM" class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <h4 class="font-semibold text-gray-900">BEM Fakultas Teknik</h4>
                                    <p class="text-sm text-gray-500">bemft@university.ac.id</p>
                                </div>
                            </a>
                            <a href="#" class="flex items-center space-x-3 p-2 hover:bg-gray-100 rounded-lg">
                                <img src="{{ asset('images/logo-kopma.png') }}" alt="Kopma" class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <h4 class="font-semibold text-gray-900">Koperasi Mahasiswa</h4>
                                    <p class="text-sm text-gray-500">kopma@university.ac.id</p>
                                </div>
                            </a>
                            <a href="#" class="flex items-center space-x-3 p-2 hover:bg-gray-100 rounded-lg">
                                <img src="{{ asset('images/logo-orbit.png') }}" alt="Orbit" class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <h4 class="font-semibold text-gray-900">Orbit</h4>
                                    <p class="text-sm text-gray-500">orbit@university.ac.id</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-xs uppercase text-gray-500 font-semibold mb-2">Himpunan Mahasiswa</h3>
                        <div class="space-y-1">

                            <a href="#" class="flex items-center space-x-3 p-2 hover:bg-gray-100 rounded-lg">
                                <img src="{{ asset('images/logo-hima-lain.png') }}" alt="Hima Lain" class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <h4 class="font-semibold text-gray-900">Himpunan Mahasiswa Teknik Mesin </h4>
                                    <p class="text-sm text-gray-500">hmtm@university.ac.id</p>
                                </div>
                            </a>
                            <a href="#" class="flex items-center space-x-3 p-2 hover:bg-gray-100 rounded-lg">
                                <img src="{{ asset('images/logo-hima-lain.png') }}" alt="Hima Lain" class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <h4 class="font-semibold text-gray-900">Himpunan Mahasiswa Teknik Kimia </h4>
                                    <p class="text-sm text-gray-500">himatekkim@university.ac.id</p>
                                </div>
                            </a>                            
                            <a href="#" class="flex items-center space-x-3 p-2 hover:bg-gray-100 rounded-lg">
                                <img src="{{ asset('images/logo-hima-lain.png') }}" alt="Hima Lain" class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <h4 class="font-semibold text-gray-900">Himpunan Mahasiswa Teknik Lingkungan </h4>
                                    <p class="text-sm text-gray-500">hmtl@university.ac.id</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </aside>

        <section class="lg:col-span-3 space-y-6">
            
            <div class="bg-white p-4 rounded-lg shadow-md max-h-[75vh] overflow-y-auto">
                <h2 class="text-xl font-semibold text-biru-primary flex items-center gap-2 mb-8"><i class="fa-solid fa-archive w-6 text-cente"></i>Semua Barang</h2>
                <div x-data="{isPinjamModalOpen: false}"" class="flex flex-wrap gap-8">
                        @for ($i = 0; $i < 10; $i++)
                        <div  class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col justify-between">
                            <div class="p-5">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-semibold text-gray-900">Proyektor Epson EB-X41</h3>
                                    <span class="bg-gray-100 text-gray-800 text-xs font-medium px-3 py-1 rounded-full border border-gray-300 flex-shrink-0">Elektronik</span>
                                </div>
                                
                                <p class="text-sm font-medium text-gray-700">Rektorat</p>
                                <p class="text-sm text-gray-500 mb-4">Proyektor WXGA 3600 lumens</p>
                                
                                <div>
                                    <span class="text-sm text-gray-500">Tersedia</span>
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-bold text-green-500">3/5 unit</span>
                                        <span class="bg-green-400 text-white  text-xs font-semibold px-3 py-1 rounded-md">Tersedia</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 p-4">
                                <button @click="isPinjamModalOpen = true" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700">
                                    Pinjam
                                </button>
                            </div>
                        </div>
        
                        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col justify-between">
                            <div class="p-5">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-semibold text-gray-900">Kamera Canon EOS 90D</h3>
                                    <span class="bg-gray-100 text-gray-800 text-xs font-medium px-3 py-1 rounded-full border border-gray-300 flex-shrink-0">Fotografi</span>
                                </div>
                                
                                <p class="text-sm font-medium text-gray-700">Rektorat</p>
                                <p class="text-sm text-gray-500 mb-4">DSLR camera 32.5MP with video 4K</p>
                                
                                <div>
                                    <span class="text-sm text-gray-500">Tersedia</span>
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-bold text-red-600">0/2 unit</span>
                                        <span class="bg-red-100 text-red-800 text-xs font-semibold px-3 py-1 rounded-full">Tidak Tersedia</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 p-4">
                                <button class="w-full bg-gray-300 text-gray-500 py-2 px-4 rounded-lg font-medium cursor-not-allowed" disabled>
                                    Pinjam
                                </button>
                            </div>
                        </div>
                        @endfor

                        @include('partials.modal-pinjam-barang')  
                </div>
                
                </div>
        </section>
        
    </div>
@endsection