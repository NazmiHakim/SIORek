@extends('layouts.app')

@section('title', 'Daftar Pengguna')
@section('subtitle', 'Lihat barang yang dimiliki pengguna lain')

@section('content')

<div class="bg-white p-6 rounded-lg shadow-lg">
    <div x-data="{ isTambahPenggunaModalOpen: false }" class="flex justify-between items-center mb-6 ">
        <div> 
            <h1 class="text-3xl font-bold text-biru-primary">@yield('title')</h1>
            <p class="text-biru-primary">@yield('subtitle')</p>
        </div>
    
        {{-- Tombol Tambah --}}
        <button @click="isTambahPenggunaModalOpen = true" class="inline-flex items-center justify-center rounded-xl bg-biru-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-biru-tua focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">Tambah</button>
        @include('partials.modal-tambah-pengguna')
    </div>
    <div class="mt-8 grid grid-cols-1 gap-10 md:grid-cols-2 xl:grid-cols-3">
            <section x-data="{ isDetailPenggunaModalOpen: false }">
                <h2 class="text-slate-900 font-semibold">Himpunan Mahasiswa</h2>
                <div class="mt-3 border-t border-slate-200"></div>
                
                @for ($i = 0; $i < 4; $i++)
                    <div @click="isDetailPenggunaModalOpen = true" class="border border-[#C6D2FF] bg-[#EEF2FF] rounded-lg p-3 mb-3">
                        <p class="font-semibold">Himpunan Mahasiswa Teknologi Informasi</p>
                        <div class="mt-1 leading-5 ">
                            <p>Fakultas Teknik</p>
                            <p>Program Studi Teknologi Informasi</p>
                        </div>
                    </div>   
                @endfor
                @include('partials.modal-detail-pengguna')
            </section>
            <section>
                <h2 class="text-slate-900 font-semibold">Rektorat</h2>
                <div class="mt-3 border-t border-slate-200"></div>

                <div class="border border-[#C6D2FF] bg-[#EEF2FF] rounded-lg p-3 mb-3">
                    <p class="font-semibold">Rektorat</p>
                    <div class="mt-1 leading-5 ">
                        <p>Universitas Lambung Mangkurat</p>
                    </div>
                </div>
            </section>
            <section>
                <h2 class="text-slate-900 font-semibold">Organisasi Mahasiswa</h2>
                <div class="mt-3 border-t border-slate-200"></div>

                <div class="border border-[#C6D2FF] bg-[#EEF2FF] rounded-lg p-3 mb-3">
                    <p class="font-semibold">Artpedia</p>
                    <div class="mt-1 leading-5 ">
                        <p>Fakultas Teknik</p>
                        <p>Universitas Lambung Mangkurat</p>
                    </div>
                </div>
            </section>
    </div>
</div>

@endsection
