@extends('layouts.app')

@section('title', 'Daftar Pengguna')
@section('subtitle', 'Lihat barang yang dimiliki pengguna lain')

@section('content')

<div class="bg-white p-6 rounded-lg shadow-lg" 
     x-data="{ 
        isTambahPenggunaModalOpen: {{ $errors->any() ? 'true' : 'false' }},
        isDetailPenggunaModalOpen: false, 
        selectedUser: null 
     }">

    <div class="flex justify-between items-center mb-6 ">
        <div> 
            <h1 class="text-3xl font-bold text-biru-primary">@yield('title')</h1>
            <p class="text-biru-primary">@yield('subtitle')</p>
        </div>
    
        <button @click="isTambahPenggunaModalOpen = true" class="inline-flex items-center justify-center rounded-xl bg-biru-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-biru-tua focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">Tambah</button>
        @include('partials.modal-tambah-pengguna')
    </div>

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

    <div class="mt-8 grid grid-cols-1 gap-10 md:grid-cols-2 xl:grid-cols-3">
        <section>
            <h2 class="text-slate-900 font-semibold">Himpunan Mahasiswa</h2>
            <div class="mt-3 border-t border-slate-200"></div>
            @forelse ($himpunanUsers as $user)
                <div @click="selectedUser = {{ $user->toJson() }}; isDetailPenggunaModalOpen = true" class="border border-[#C6D2FF] bg-[#EEF2FF] rounded-lg p-3 mb-3 cursor-pointer hover:shadow-md transition-shadow">
                    <p class="font-semibold">{{ $user->nama_organisasi ?: $user->username }}</p>
                    <div class="mt-1 leading-5 text-sm text-gray-600">
                        <p>{{ $user->fakultas ?: 'Fakultas tidak terdaftar' }}</p>
                        <p>{{ $user->program_studi }}</p>
                    </div>
                    <form id="delete-user-form-{{ $user->id }}" 
                          action="{{ route('admin.pengguna.destroy', $user->id) }}" 
                          method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div> 
            @empty
                <p class="text-sm text-gray-400 p-3">Tidak ada Himpunan Mahasiswa.</p>
            @endforelse
        </section>

        <section>
            <h2 class="text-slate-900 font-semibold">Rektorat</h2>
            <div class="mt-3 border-t border-slate-200"></div>
            @forelse ($rektoratUsers as $user)
                <div @click="selectedUser = {{ $user->toJson() }}; isDetailPenggunaModalOpen = true" class="border border-[#C6D2FF] bg-[#EEF2FF] rounded-lg p-3 mb-3 cursor-pointer hover:shadow-md transition-shadow">
                    <p class="font-semibold">{{ $user->nama_organisasi ?: $user->username }}</p>
                    <div class="mt-1 leading-5 text-sm text-gray-600">
                        <p>{{ $user->fakultas ?: 'Universitas Lambung Mangkurat' }}</p>
                    </div>
                    <form id="delete-user-form-{{ $user->id }}" 
                          action="{{ route('admin.pengguna.destroy', $user->id) }}" 
                          method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            @empty
                <p class="text-sm text-gray-400 p-3">Tidak ada akun Rektorat.</p>
            @endforelse
        </section>

        <section>
            <h2 class="text-slate-900 font-semibold">Organisasi Mahasiswa</h2>
            <div class="mt-3 border-t border-slate-200"></div>
            @forelse ($organisasiUsers as $user)
                <div @click="selectedUser = {{ $user->toJson() }}; isDetailPenggunaModalOpen = true" class="border border-[#C6D2FF] bg-[#EEF2FF] rounded-lg p-3 mb-3 cursor-pointer hover:shadow-md transition-shadow">
                    <p class="font-semibold">{{ $user->nama_organisasi ?: $user->username }}</p>
                    <div class="mt-1 leading-5 text-sm text-gray-600">
                        <p>{{ $user->fakultas ?: 'Universitas Lambung Mangkurat' }}</p>
                    </div>
                    <form id="delete-user-form-{{ $user->id }}" 
                          action="{{ route('admin.pengguna.destroy', $user->id) }}" 
                          method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            @empty
                <p class="text-sm text-gray-400 p-3">Tidak ada Organisasi Mahasiswa.</p>
            @endforelse
        </section>
    </div>
    @include('partials.modal-detail-pengguna')
</div>
@endsection