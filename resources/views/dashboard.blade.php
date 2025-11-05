@extends('layouts.app')

@section('title', 'Dashboard')
@section('subtitle', 'Selamat Datang di Halaman Peminjaman dan Pengembalian Barang')

@section('content')

<div class="flex justify-between items-center mb-6">
    <div> 
        <h1 class="text-3xl font-bold text-biru-primary">@yield('title')</h1>
        <p class="text-biru-primary">@yield('subtitle')</p>
    </div>
</div>

<div>
    <div class="bg-white p-6 rounded-lg shadow-lg xl:flex justify-between gap-10">
        <div class=" flex-1">
            <h2 class="text-xl font-bold mb-4 text-blue-600 "><i class="fa-solid fa-calendar-days"></i> Kalender Peminjaman</h2>
            <p class="text-sm text-gray-600 mb-4">Lihat tanggal untuk melihat barang yang dipinjam pada hari tersebut.</p>
            
            <div class="bg-gray-200 h-64 rounded-md flex items-center justify-center">
                <p class="text-gray-500">[Placeholder untuk Kalender Interaktif]</p>
            </div>
        </div>

        <div class="mt-10 flex-1">
            <h2 class="text-lg font-semibold mb-4">Barang yang dipinjam pada 1 November 2025</h2>
            
            <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
                <h3 class="font-semibold">Kabel Roll 4 Meter (2 unit)</h3>
                <p class="text-sm text-gray-600">Oleh: BEM Fakultas Teknik</p>
            </div>
        </div>
    </div>

    <div class=" mt-8 xl:flex gap-6">

        <div class="bg-white p-6 rounded-lg shadow-lg flex-1">
            <h2 class="text-xl font-bold text-blue-600 mb-4"><i class="fa-solid fa-box"></i> Barang yang Saya Pinjam</h2>
            
            <div class="space-y-4">
                <div >
                    <h1 class="font-semibold mb-4 text-[#FF9D00]">Menunggu Persetujuan:</h1>
                    <div x-data="{ isMenungguDiambilModalOpen: false }" class="flex flex-col gap-4 max-h-80 overflow-y-auto" >
                        {{-- Card Menunggu Persetujuan Pemilik --}}
                        <div @click="isMenungguDiambilModalOpen = true" class="bg-warning-fill border-2 border-warning-stroke  p-4 rounded-lg cursor-pointer transition hover:shadow-lg">
                            <h3 class="font-semibold">Wireless Mouse Logitech (1 unit)</h3>
                            <p class="text-sm text-gray-600">dari Rektorat</p>
                            <p class="text-sm text-gray-500">1/12/2025 - 7/12/2025</p>
                        </div>
                        @include('partials.modal-menunggu-persetujuan')
                    </div>
                </div>

                <div>
                    <h1 class="font-semibold mb-4 text-[#EACD00]">Siap Diambil:</h1>
                    <div x-data="{ isSiapDIambilModalOpen: false }" class="flex flex-col gap-4 max-h-80 overflow-y-auto" >
                        {{-- Card Pengambilan Barang dari Pemilik --}}
                        <div @click="isSiapDIambilModalOpen = true" class="bg-caution-fill border-2 border-caution-stroke p-4 rounded-lg cursor-pointer  transition hover:shadow-lg">
                            <h3 class="font-semibold">Laptop Stand (1 unit)</h3>
                            <p class="text-sm text-gray-600">dari Rektorat</p>
                            <p class="text-sm text-gray-500">1/12/2025 - 5/12/2025</p>
                        </div>
                        @include('partials.modal-siap-diambil')
                    </div>
                </div>
                
                <div>
                    <h1 class="font-semibold mb-4 text-[#0095FF]">Sedang Dipinjam:</h1>
                    <div x-data="{ isSedangMeminjamModalOpen: false}" class="flex flex-col gap-4 max-h-80 overflow-y-auto" >
                        {{-- Card Barang yang Dipinjam dari Pemilik --}}
                        <div @click="isSedangMeminjamModalOpen = true" class="bg-white border-2 border-notice-stroke p-4 rounded-lg cursor-pointer transition hover:shadow-lg">
                            <h3 class="font-semibold">Proyektor Epson EB-X4 (2 unit)</h3>
                            <p class="text-sm text-gray-600">dari Rektorat</p>
                            <p class="text-sm text-gray-500">25/10/2025 - 2/11/2025</p>
                        </div>
                        @include('partials.modal-sedang-meminjam')
                    </div>
                </div>

                <div>
                    <h1 class="font-semibold mb-4 text-[#0095FF]">Proses Pengembalian:</h1>
                    <div x-data="{ isProsesPengembalianModalOpen: false}" class="flex flex-col gap-4 max-h-80 overflow-y-auto" >
                        {{-- Card Menunggu Konfirmasi Pengembalian dari Pemilik --}}
                        <div @click="isProsesPengembalianModalOpen = true" class="bg-white border-2 border-notice-stroke p-4 rounded-lg cursor-pointer transition hover:shadow-lg">
                            <h3 class="font-semibold">Kamera Canon EOS 90D (1 unit)</h3>
                            <p class="text-sm text-gray-600">dari Kampung Seni Budaya</p>
                            <p class="text-sm text-gray-500">1/11/2025 - 5/11/2025</p>
                        </div>
                        @include('partials.modal-proses-pengembalian')
                    </div>
                </div>

                <div>
                    <h1 class="font-semibold mb-4 text-danger-stroke">Pengembalian Bermasalah:</h1>
                    <div x-data="{ isPengembalianBermasalahModalOpen: false}" class="flex flex-col gap-4 max-h-80 overflow-y-auto" >
                        {{-- Card Menunggu Konfirmasi Pengembalian dari Pemilik --}}
                        <div @click="isPengembalianBermasalahModalOpen = true" class="bg-danger-fill border-2 border-danger-stroke p-4 rounded-lg cursor-pointer transition hover:shadow-lg">
                            <h3 class="font-semibold">Proyektor Epson EB-X4 (2 unit)</h3>
                            <p class="text-sm text-gray-600">dari Rektorat</p>
                            <p class="text-sm text-gray-500">1/12/2025 - 7/12/2025</p>
                        </div>
                        @include('partials.modal-pengembalian-bermasalah')
                    </div>
                </div>
            </div>
        </div>    

        <div class="bg-white p-6 rounded-lg shadow-lg flex-1">
            <h2 class="text-xl font-bold text-blue-600 mb-4"><i class="fa-solid fa-arrow-down"></i> Barang yang Dipinjam Orang Lain</h2>
            <div class="space-y-4">
                <div>
                    <h1 class="font-semibold mb-4 text-[#FF9D00]">Permintaan Peminjaman:</h1>
                    <div x-data="{isPermintaanPeminjamanModalOpen: false}" class="flex flex-col gap-4 max-h-80 overflow-y-auto" >
                        {{-- Card Permintaan Peminjaman Barang Oleh Peminjam--}}
                        <div @click="isPermintaanPeminjamanModalOpen = true" class="bg-warning-fill border-2 border-warning-stroke p-4 rounded-lg cursor-pointer transition hover:shadow-lg">
                            <h3 class="font-semibold">Tripod Manfrotto (2 unit)</h3>
                            <p class="text-sm text-gray-600">Oleh: Kampung Seni Budaya</p>
                            <p class="text-sm text-gray-500">30/10/2025 - 3/11/2025</p>
                        </div>
                        @include('partials.modal-permintaan-peminjaman')
                    </div>
                </div>

                <div>
                    <h1 class="font-semibold mb-4 text-[#EACD00]">Permintaan Pengembalian:</h1>
                    <div x-data="{isPermintaanPengembalianModalOpen: false}" class="flex flex-col gap-4 max-h-80 overflow-y-auto" >
                        {{-- Card Permintaan Pengembalian Barang Dari Peminjam--}}
                        <div @click='isPermintaanPengembalianModalOpen = true' class="bg-caution-fill border-2 border-caution-stroke p-4 rounded-lg cursor-pointer transition hover:shadow-lg">
                            <h3 class="font-semibold">Microphone USB (3 unit)</h3>
                            <p class="text-sm text-gray-600">Oleh: Koperasi Mahasiswa</p>
                            <p class="text-sm text-gray-500">28/11/2025 - 2/12/2025</p>
                        </div>
                        @include('partials.modal-permintaan-pengembalian')
                    </div>
                </div>

                <div>
                    <h1 class="font-semibold mb-4 text-[#EACD00]">Menunggu diambil:</h1>
                    <div x-data="{isMenungguDiambilModalOpen: false}" class="flex flex-col gap-4 max-h-80 overflow-y-auto" >
                        {{-- Card Menunggu Pengambilan Barang Oleh Peminjam--}}
                        <div @click='isMenungguDiambilModalOpen = true' class="bg-caution-fill border-2 border-caution-stroke p-4 rounded-lg cursor-pointer transition hover:shadow-lg">
                            <h3 class="font-semibold">Kabel HDMI (3 unit)</h3>
                            <p class="text-sm text-gray-600">Oleh: Koperasi Mahasiswa</p>
                            <p class="text-sm text-gray-500">28/11/2025 - 2/12/2025</p>
                        </div>
                        @include('partials.modal-menunggu-diambil')
                    </div>
                </div>

                <div>
                    <h1 class="font-semibold mb-4 text-[#0095FF]">Sedang Dipinjam:</h1>
                    <div x-data="{isSedangDipinjamModalOpen: false}" class="flex flex-col gap-4 max-h-80 overflow-y-auto" >
                        {{-- Card Barang yang Sedang Dipinjam Orang Lain--}}
                        <div @click="isSedangDipinjamModalOpen = true" class="bg-white border-2 border-notice-stroke p-4 rounded-lg cursor-pointer transition hover:shadow-lg">
                            <h3 class="font-semibold">Gimbal Stabilizer (1 unit)</h3>
                            <p class="text-sm text-gray-600">Oleh: Kampung Seni Budaya</p>
                            <p class="text-sm text-gray-500">28/11/2025 - 2/12/2025</p>
                        </div>
                        @include('partials.modal-sedang-dipinjam')
                    </div>
                </div>
            
                <div>
                    <h1 class="font-semibold mb-4 text-danger-stroke">Pengembalian Bermasalah:</h1>
                    <div x-data="{isDetailDipinjamModalOpen: false}" class="flex flex-col gap-4 max-h-80 overflow-y-auto" >
                        {{-- Card Barang yang Sedang Dipinjam Orang Lain--}}
                        <div @click="isDetailDipinjamModalOpen = true" class="bg-danger-fill border-2 border-danger-stroke p-4 rounded-lg cursor-pointer transition hover:shadow-lg">
                            <h3 class="font-semibold">Flashdisk USB (3 unit)</h3>
                            <p class="text-sm text-gray-600">Oleh: Himpunan Mahasiswa...</p>
                            <p class="text-sm text-gray-500">1/12/2025 - 7/12/2025</p>
                        </div>
                        @include('partials.modal-sedang-dipinjam')
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection