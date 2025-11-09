@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')
@section('subtitle', 'Lihat semua transaksi peminjaman')

@section('content')

<div class="flex justify-between items-center mb-6">
    <div> 
        <h1 class="text-3xl font-bold text-biru-primary">@yield('title')</h1>
        <p class="text-biru-primary">@yield('subtitle')</p>
    </div>
</div>

<div x-data="{ tab: 'saya_meminjam' }" class="space-y-6">

<div class="relative w-full max-w-sm bg-gray-200 rounded-full p-1 flex">
    
    <div 
        class="absolute top-1 left-1 w-1/2 h-[calc(100%-8px)] bg-white rounded-full shadow-md transition-transform duration-300 ease-in-out"
        :class="{
            'translate-x-0': tab === 'saya_meminjam',
            'translate-x-full': tab === 'orang_lain'
        }"
    ></div>

    <button 
        type="button"
        @click="tab = 'saya_meminjam'"
        :class="tab === 'saya_meminjam' ? 'text-gray-900' : 'text-gray-600'"
        class="relative z-10 w-1/2 py-2 text-center font-medium rounded-full transition-colors duration-300"
    >
        Saya Meminjam
    </button>

    <button 
        type="button"
        @click="tab = 'orang_lain'"
        :class="tab === 'orang_lain' ? 'text-gray-900' : 'text-gray-600'"
        class="relative z-10 w-1/2 py-2 text-center font-medium rounded-full transition-colors duration-300"
    >
        Dipinjam Orang Lain
    </button>

</div>

    <div x-show="tab === 'saya_meminjam'" class="space-y-6">
        
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold mb-4">Barang yang saya pinjam</h3>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemilik</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dikembalikan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($pinjamanSaya as $loan)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $loan->item->nama_item }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $loan->jumlah }} unit
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $loan->pemilik->username }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($loan->tanggal_mulai)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($loan->tanggal_selesai)->format('d/m/Y') }}
                                </td>
                                {{-- Kolom Status (Menggantikan "Dikembalikan") --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($loan->status == 'selesai')
                                        <span class="text-green-600">Selesai</span>
                                    @elseif($loan->status == 'ditolak')
                                        <span class="text-red-600">Ditolak</span>
                                    @elseif($loan->status == 'bermasalah')
                                        <span class="text-red-600">Bermasalah</span>
                                    @else
                                        <span class="text-yellow-600 capitalize">{{ str_replace('_', ' ', $loan->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    Anda belum pernah meminjam barang.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div x-show="tab === 'orang_lain'" class="space-y-6" style="display: none;">
        
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold mb-4">Barang yang dipinjam orang Lain</h3>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dikembalikan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>                    
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($pinjamanOrangLain as $loan)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $loan->item->nama_item }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $loan->jumlah }} unit
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $loan->peminjam->username }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($loan->tanggal_mulai)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($loan->tanggal_selesai)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $loan->tanggal_pengembalian_aktual ? \Carbon\Carbon::parse($loan->tanggal_pengembalian_aktual)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($loan->status == 'selesai')
                                        <span class="text-green-600">Selesai</span>
                                    @elseif($loan->status == 'ditolak')
                                        <span class="text-red-600">Ditolak</span>
                                    @elseif($loan->status == 'bermasalah')
                                        <span class="text-red-600">Bermasalah</span>
                                    @else
                                        <span class="text-yellow-600 capitalize">{{ str_replace('_', ' ', $loan->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    Belum ada barang Anda yang dipinjam.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold mb-6 flex items-center gap-2 text-gray-800">
            <i class="fa-solid fa-calendar-check text-blue-600"></i>
            Rekap Bulanan
        </h3>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center md:text-left">
                <span class="text-sm text-gray-500 block">Total Saya Pinjam</span>
                <span class="text-4xl font-bold text-gray-900">{{ $totalSayaPinjam }}</span>
            </div>
            <div class="text-center md:text-left">
                <span class="text-sm text-gray-500 block">Dipinjam Orang Lain</span>
                <span class="text-4xl font-bold text-gray-900">{{ $totalDipinjamOrang }}</span>
            </div>
            <div class="text-center md:text-left">
                <span class="text-sm text-gray-500 block">Aktif Saat Ini</span>
                <span class="text-4xl font-bold text-blue-600">{{ $totalAktif }}</span>
            </div>
            <div class="text-center md:text-left">
                <span class="text-sm text-gray-500 block">Sanksi Diberikan</span>
                <span class="text-4xl font-bold text-red-600">{{ $totalSanksi }}</span>
            </div>
        </div>
    </div>

</div>
@endsection                                                             