@extends('layouts.app')

@section('title', 'Daftar Pengguna')
@section('subtitle', 'Kelola semua akun pengguna di sistem')

@section('content')

<div class="bg-white p-6 rounded-lg shadow-lg">
    <div x-data="{ isTambahPenggunaModalOpen: false }" class="flex justify-between items-center mb-6 ">
        <div> 
            <h1 class="text-3xl font-bold text-biru-primary">@yield('title')</h1>
            <p class="text-biru-primary">@yield('subtitle')</p>
        </div>
    
        <button @click="isTambahPenggunaModalOpen = true" class="inline-flex items-center justify-center rounded-xl bg-biru-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-biru-tua focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">Tambah Pengguna</button>
        @include('partials.modal-tambah-pengguna')
    </div>

    <!-- notif sukses/eror -->
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

    <div class="overflow-x-auto mt-8">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $user->username }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($user->role == 'Admin')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $user->role }}
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                {{ $user->role }}
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        
                        {{-- <button class="text-blue-600 hover:text-blue-900" x-data @click="">Edit</button> --}}
                        
                        <button class="text-red-600 hover:text-red-900 ml-4" x-data 
                            @click.prevent="if(confirm('Apakah Anda yakin ingin menghapus pengguna {{ $user->username }}?')) { 
                                document.getElementById('delete-user-form-{{ $user->id }}').submit(); 
                            }">
                            Hapus
                        </button>
                        
                        <form id="delete-user-form-{{ $user->id }}" 
                              action="{{ route('admin.pengguna.destroy', $user->id) }}" 
                              method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                        Tidak ada data pengguna.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@include('partials.modal-detail-pengguna')

@endsection