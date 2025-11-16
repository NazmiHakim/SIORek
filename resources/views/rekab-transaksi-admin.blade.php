@extends('layouts.app')

@section('title', 'Rekap Transaksi')
@section('subtitle', 'Lihat semua riwayat transaksi disistem')

@section('content')

<div class="bg-white p-6 rounded-lg shadow-lg">
    <div class="flex justify-between items-center mb-6">
        <div> 
            <h1 class="text-3xl font-bold text-biru-primary">@yield('title')</h1>
            <p class="text-biru-primary">@yield('subtitle')</p>
        </div>
    </div>

    <!-- filter transaksi -->
    <form action="{{ route('rekabTransaksiAdmin') }}" method="GET" class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
        <div class="flex flex-col md:flex-row gap-4 items-end">
            
            <!-- dropdown akun -->
            <div class="flex-1 w-full">
                <label for="user_id" class="block text-sm font-medium text-gray-700">Filter berdasarkan pengguna</label>
                <select name="user_id" id="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Semua Transaksi</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" 
                            {{-- Buat dropdown "mengingat" pilihan filter --}}
                            {{ $selectedUserId == $user->id ? 'selected' : '' }}>
                            {{ $user->username }} ({{ $user->role }})
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- reset -->
            <button type="submit" class="w-full md:w-auto px-5 py-2.5 bg-biru-primary text-white rounded-lg font-semibold hover:bg-biru-tua transition-colors">Filter</button>
            <a href="{{ route('rekabTransaksiAdmin') }}" class="w-full md:w-auto px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 text-center">Reset</a>
        </div>
    </form>


    <!-- notif -->
    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-100 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto mt-8">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemilik</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Pinjam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Selesai</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                
                @forelse($loans as $loan)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                        {{ $loan->item->nama_item ?? 'Barang Dihapus' }} ({{ $loan->jumlah }} unit)
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $loan->peminjam->username ?? 'User Dihapus' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $loan->pemilik->username ?? 'User Dihapus' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($loan->tanggal_mulai)->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($loan->tanggal_selesai)->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($loan->status == 'selesai')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Selesai
                            </span>
                        @elseif($loan->status == 'bermasalah' || $loan->status == 'ditolak')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                {{ $loan->status == 'bermasalah' ? 'Bermasalah' : 'Ditolak' }}
                            </span>
                        @elseif($loan->status == 'sedang_dipinjam')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                Dipinjam
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                {{ ucwords(str_replace('_', ' ', $loan->status)) }}
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                        @if($selectedUserId)
                            Tidak ada transaksi yang ditemukan untuk pengguna ini.
                        @else
                            Belum ada transaksi di sistem.
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection