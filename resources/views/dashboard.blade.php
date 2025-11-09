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
    <div class="bg-white p-6 rounded-lg shadow-lg xl:flex justify-between gap-10" x-data="app()" x-init="[initDate(), getNoOfDays()]">
        <div class=" flex-1">
            <h2 class="text-xl font-bold mb-4 text-blue-600 "><i class="fa-solid fa-calendar-days"></i> Kalender Peminjaman</h2>
            <p class="text-sm text-gray-600 mb-4">Tanggal untuk melihat agenda peminjaman barang.</p>
            <!-- Kalender -->
            <div class="antialiased sans-serif flex-1">
                <div class="container mx-auto">
                    <div class="bg-white rounded-lg shadow overflow-hidden">

                        {{-- Header Kalender (Bulan/Tahun dan Tombol Navigasi) --}}
                        <div class="flex items-center justify-between py-2 px-6">
                            <div>
                                <span x-text="MONTH_NAMES[month]" class="text-lg font-bold text-gray-800"></span>
                                <span x-text="year" class="ml-1 text-lg text-gray-600 font-normal"></span>
                            </div>
                            <div class="border rounded-lg px-1" style="padding-top: 2px;">
                                <button 
                                    type="button"
                                    class="leading-none rounded-lg transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 items-center" 
                                    :class="{'cursor-not-allowed opacity-25': month == 0 && year == new Date().getFullYear()}" 
                                    :disabled="month == 0 && year == new Date().getFullYear() ? true : false"
                                    @click="month--; getNoOfDays()">
                                    <i class="fa-solid fa-chevron-left fa-sm"></i>
                                </button>
                                <div class="border-r inline-flex h-6"></div>		
                                <button 
                                    type="button"
                                    class="leading-none rounded-lg transition ease-in-out duration-100 inline-flex items-center cursor-pointer hover:bg-gray-200 p-1" 
                                    @click="month++; getNoOfDays()">
                                    <i class="fa-solid fa-chevron-right fa-sm"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Grid Hari (Sen, Sel, Rab...) --}}
                        <div class="-mx-1 -mb-1">
                            <div class="flex flex-wrap" style="margin-bottom: -40px;">
                                <template x-for="(day, index) in days" :key="index">	
                                    <div style="width: 14.26%" class="px-2 py-2">
                                        <div x-text="day" class="text-gray-600 text-sm uppercase font-bold text-center"></div>
                                    </div>
                                </template>
                            </div>

                            {{-- Grid Tanggal (1, 2, 3...) --}}
                            <div class="flex flex-wrap border-t border-l">
                                {{-- Kotak kosong sebelum tanggal 1 --}}
                                <template x-for="blankday in blankdays">
                                    <div style="width: 14.28%; height: 6rem;" class="text-center border-r border-b px-4 pt-2"></div>
                                </template>	
                                {{-- Tanggal --}}
                                <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">	
                                    <div style="width: 14.28%; height: 6rem;" class="px-2 pt-2 border-r border-b relative cursor-pointer"
                                        :class="{'bg-blue-50': isToday(date) == true, 'text-gray-700 hover:bg-blue-100': isToday(date) == false }"
                                        @click="showEvents(date)">
                                        
                                        <div x-text="date" class="inline-flex items-center justify-center w-6 h-6 rounded-full text-center"
                                            :class="{'bg-blue-600 text-white': isToday(date) == true, 'text-gray-700': isToday(date) == false }"></div>
                                        
                                        {{-- Titik event (jika ada) --}}
                                        <div style="height: 1rem;" class="overflow-y-hidden mt-1">
                                            <div class="absolute bottom-2 left-2 flex -mx-1">
                                                <template x-for="event in events.filter(e => new Date(e.event_date).toDateString() === new Date(year, month, date).toDateString())">
                                                    <div class="h-2 w-2 rounded-full mx-1" :class="themes[event.event_theme] || themes['blue']"></div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10 flex-1">
            {{-- Judul dinamis --}}
            <h2 class="text-lg font-semibold mb-4">
                Agenda peminjaman barang pada <span x-text="selected_date"></span>
            </h2>
            
            {{-- Looping untuk event --}}
            <div class="space-y-3">
                {{-- Gunakan event.type sebagai 'key' unik --}}
                <template x-for="event in events_on_selected_date" :key="event.event_title + event.type">
                    
                    {{-- 
                      Ubah warna kartu berdasarkan TIPE 
                      Biru = Saya Meminjam
                      Hijau = Saya Meminjamkan
                    --}}
                    <div class="p-4 rounded-lg border" 
                         :class="{
                            'bg-blue-50 border-blue-200': event.type === 'meminjam',
                            'bg-green-50 border-green-200': event.type === 'meminjamkan',
                            'bg-yellow-50 border-yellow-200': event.event_theme === 'yellow',
                            'bg-red-50 border-red-200': event.event_theme === 'red'
                         }">
                        
                        <h3 class="font-semibold" x-text="event.event_title"></h3>
                        
                        {{-- Tampilkan info yang relevan berdasarkan 'type' --}}
                        <template x-if="event.type === 'meminjam'">
                            <p class="text-sm text-gray-600">Dipinjam dari: <span x-text="event.pemilik"></span></p>
                        </template>
                        <template x-if="event.type === 'meminjamkan'">
                            <p class="text-sm text-gray-600">Dipinjam oleh: <span x-text="event.peminjam"></span></p>
                        </template>
                        
                        <p class="text-sm text-gray-500">Status: <span x-text="event.status"></span></p>
                    </div>

                </template>
                
                {{-- Tampilan jika tidak ada event --}}
                <template x-if="events_on_selected_date.length === 0">
                    <p class="text-sm text-gray-500">Tidak ada agenda peminjaman pada tanggal ini.</p>
                </template>
            </div>
        </div>
    </div>

    <div class=" mt-8 xl:flex gap-6">

        <div class="bg-white p-6 rounded-lg shadow-lg flex-1">
            <h2 class="text-xl font-bold text-blue-600 mb-4"><i class="fa-solid fa-box"></i> Barang yang Saya Pinjam</h2>
            
            <div class="space-y-4">
                <div >
                    <h1 class="font-semibold mb-4 text-[#FF9D00]">Menunggu Persetujuan:</h1>
                    {{-- 
                      Perbaikan x-data: 'isMenungguPersetujuanModalOpen'
                      dan tambahkan 'selectedLoan'
                    --}}
                    <div x-data="{ isMenungguPersetujuanModalOpen: false, selectedLoan: null }" class="flex flex-col gap-4 max-h-80 overflow-y-auto" >                        
                        {{-- Ganti kartu statis dengan looping @forelse --}}
                        @forelse ($saya_menunggu_persetujuan as $loan)
                            <div @click="isMenungguPersetujuanModalOpen = true; selectedLoan = {{ $loan->toJson() }}"
                                 class="bg-warning-fill border-2 border-warning-stroke  p-4 rounded-lg cursor-pointer transition hover:shadow-lg">
                                
                                <h3 class="font-semibold">{{ $loan->item->nama_item }} ({{ $loan->jumlah }} unit)</h3>
                                <p class="text-sm text-gray-600">dari: {{ $loan->pemilik->username }}</p>
                                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($loan->tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($loan->tanggal_selesai)->format('d/m/Y') }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">Tidak ada barang yang menunggu persetujuan.</p>
                        @endforelse
                        @include('partials.modal-menunggu-persetujuan')
                    </div>
                </div>

                <div>
                    <h1 class="font-semibold mb-4 text-[#EACD00]">Siap Diambil:</h1>
                    <div x-data="{ isSiapDIambilModalOpen: false, selectedLoan: null }" class="flex flex-col gap-4 max-h-80 overflow-y-auto" >
                        {{-- Card Pengambilan Barang dari Pemilik --}}
                        @forelse ($saya_siap_diambil as $loan)
                            <div @click="isSiapDIambilModalOpen = true; selectedLoan = {{ $loan->toJson() }}"
                                class="bg-caution-fill border-2 border-caution-stroke p-4 rounded-lg cursor-pointer transition hover:shadow-lg">

                                <h3 class="font-semibold">{{ $loan->item->nama_item }} ({{ $loan->jumlah }} unit)</h3>
                                <p class="text-sm text-gray-600">dari: {{ $loan->pemilik->username }}</p>
                                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($loan->tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($loan->tanggal_selesai)->format('d/m/Y') }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">Belum ada barang yang siap diambil.</p>
                        @endforelse
                        @include('partials.modal-siap-diambil')
                    </div>
                </div>
                
                <div>
                    <h1 class="font-semibold mb-4 text-[#0095FF]">Sedang Dipinjam:</h1>
                    <div x-data="{ isSedangMeminjamModalOpen: false, selectedLoan: null }" class="flex flex-col gap-4 max-h-80 overflow-y-auto" >
                        {{-- Card Barang yang Dipinjam dari Pemilik --}}
                        @forelse ($saya_sedang_meminjam as $loan)
                            <div @click="isSedangMeminjamModalOpen = true; selectedLoan = {{ $loan->toJson() }}"
                                 class="bg-white border-2 border-notice-stroke p-4 rounded-lg cursor-pointer transition hover:shadow-lg">
                                
                                <h3 class="font-semibold">{{ $loan->item->nama_item }} ({{ $loan->jumlah }} unit)</h3>
                                <p class="text-sm text-gray-600">dari: {{ $loan->pemilik->username }}</p>
                                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($loan->tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($loan->tanggal_selesai)->format('d/m/Y') }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">Tidak ada barang yang sedang Anda pinjam.</p>
                        @endforelse
                        @include('partials.modal-sedang-meminjam')
                    </div>
                </div>

                <div>
                    <h1 class="font-semibold mb-4 text-[#0095FF]">Proses Pengembalian:</h1>
                    {{-- Kita buat x-data "pintar" dengan 'selectedLoan' --}}
                    <div x-data="{ isProsesPengembalianModalOpen: false, selectedLoan: null }" class="flex flex-col gap-4 max-h-80 overflow-y-auto" >
                        
                        {{-- Ganti kartu statis dengan looping @forelse --}}
                        @forelse ($saya_proses_pengembalian as $loan)
                            {{-- 
                                Modal 'modal-proses-pengembalian' ini sepertinya
                                hanya untuk melihat detail, jadi kita buat bisa diklik.
                            --}}
                            <div @click="isProsesPengembalianModalOpen = true; selectedLoan = {{ $loan->toJson() }}"
                                 class="bg-white border-2 border-notice-stroke p-4 rounded-lg cursor-pointer transition hover:shadow-lg">
                                
                                <h3 class="font-semibold">{{ $loan->item->nama_item }} ({{ $loan->jumlah }} unit)</h3>
                                <p class="text-sm text-gray-600">dari: {{ $loan->pemilik->username }}</p>
                                <p class="text-sm text-gray-500 font-medium text-blue-600">Menunggu konfirmasi pemilik...</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">Tidak ada pengembalian yang sedang diproses.</p>
                        @endforelse

                        @include('partials.modal-proses-pengembalian')
                    </div>
                </div>

                <div>
                    <h1 class="font-semibold mb-4 text-danger-stroke">Pengembalian Bermasalah:</h1>
                    {{-- Kita buat x-data "pintar" dengan 'selectedLoan' --}}
                    <div x-data="{ isPengembalianBermasalahModalOpen: false, selectedLoan: null }" class="flex flex-col gap-4 max-h-80 overflow-y-auto" >
                        
                        {{-- Ganti kartu statis dengan looping @forelse --}}
                        @forelse ($saya_bermasalah as $loan)
                            <div @click="isPengembalianBermasalahModalOpen = true; selectedLoan = {{ $loan->toJson() }}"
                                 class="bg-danger-fill border-2 border-danger-stroke p-4 rounded-lg cursor-pointer transition hover:shadow-lg">
                                
                                <h3 class="font-semibold">{{ $loan->item->nama_item }} ({{ $loan->jumlah }} unit)</h3>
                                <p class="text-sm text-gray-600">dari: {{ $loan->pemilik->username }}</p>
                                <p class="text-sm text-red-700 font-medium">Masalah: {{ $loan->keterangan_sanksi ?? 'Silakan hubungi pemilik.' }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">Tidak ada pengembalian yang bermasalah.</p>
                        @endforelse

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
                    <div x-data="{isPermintaanPeminjamanModalOpen: false, selectedLoan: null}" class="flex flex-col gap-4 max-h-80 overflow-y-auto" >
                        {{-- Card Permintaan Peminjaman Barang Oleh Peminjam--}}
                        @forelse ($permintaan_masuk as $loan)
                            <div @click="isPermintaanPeminjamanModalOpen = true; selectedLoan = {{ $loan->toJson() }}" 
                                class="bg-warning-fill border-2 border-warning-stroke p-4 rounded-lg cursor-pointer transition hover:shadow-lg">

                                <h3 class="font-semibold">{{ $loan->item->nama_item }} ({{ $loan->jumlah }} unit)</h3>
                                <p class="text-sm text-gray-600">Oleh: {{ $loan->peminjam->username }}</p>
                                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($loan->tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($loan->tanggal_selesai)->format('d/m/Y') }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">Belum ada permintaan peminjaman baru.</p>
                        @endforelse
                        @include('partials.modal-permintaan-peminjaman')
                    </div>
                </div>

                <div>
                    <h1 class="font-semibold mb-4 text-[#EACD00]">Permintaan Pengembalian:</h1>
                    <div x-data="{isPermintaanPengembalianModalOpen: false, selectedLoan: null}" class="flex flex-col gap-4 max-h-80 overflow-y-auto" >
                        {{-- Card Permintaan Pengembalian Barang Dari Peminjam--}}
                        @forelse ($permintaan_pengembalian as $loan)
                            <div @click="isPermintaanPengembalianModalOpen = true; selectedLoan = {{ $loan->toJson() }}"
                                class="bg-caution-fill border-2 border-caution-stroke p-4 rounded-lg cursor-pointer transition hover:shadow-lg">

                                <h3 class="font-semibold">{{ $loan->item->nama_item }} ({{ $loan->jumlah }} unit)</h3>
                                <p class="text-sm text-gray-600">Oleh: {{ $loan->peminjam->username }}</p>
                                <p class="text-sm text-gray-500">Diajukan: {{ \Carbon\Carbon::parse($loan->tanggal_pengembalian_aktual)->format('d/m/Y H:i') }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">Belum ada permintaan pengembalian.</p>
                        @endforelse
                        @include('partials.modal-permintaan-pengembalian')
                    </div>
                </div>

                <div>
                    <h1 class="font-semibold mb-4 text-[#EACD00]">Menunggu diambil:</h1>
                    <div x-data="{isMenungguDiambilModalOpen: false, selectedLoan: null}" class="flex flex-col gap-4 max-h-80 overflow-y-auto" >
                        {{-- Card Menunggu Pengambilan Barang Oleh Peminjam--}}
                        @forelse ($menunggu_diambil_peminjam as $loan)
                            {{-- Kita juga buat @click-nya pintar --}}
                            <div @click="isMenungguDiambilModalOpen = true; selectedLoan = {{ $loan->toJson() }}" 
                                class="bg-caution-fill border-2 border-caution-stroke p-4 rounded-lg cursor-pointer transition hover:shadow-lg">

                                <h3 class="font-semibold">{{ $loan->item->nama_item }} ({{ $loan->jumlah }} unit)</h3>
                                <p class="text-sm text-gray-600">Oleh: {{ $loan->peminjam->username }}</p>
                                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($loan->tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($loan->tanggal_selesai)->format('d/m/Y') }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">Belum ada barang yang menunggu diambil.</p>
                        @endforelse
                        @include('partials.modal-menunggu-diambil')
                    </div>
                </div>

                <div>
                    <h1 class="font-semibold mb-4 text-[#0095FF]">Sedang Dipinjam:</h1>
                    <div x-data="{isSedangDipinjamModalOpen: false, selectedLoan: null }" class="flex flex-col gap-4 max-h-80 overflow-y-auto" >                        {{-- Card Barang yang Sedang Dipinjam Orang Lain--}}
                        @forelse ($sedang_dipinjam_orang as $loan)
                            <div @click="isSedangDipinjamModalOpen = true; selectedLoan = {{ $loan->toJson() }}"
                                 class="bg-white border-2 border-notice-stroke p-4 rounded-lg cursor-pointer transition hover:shadow-lg">
                                
                                <h3 class="font-semibold">{{ $loan->item->nama_item }} ({{ $loan->jumlah }} unit)</h3>
                                <p class="text-sm text-gray-600">Oleh: {{ $loan->peminjam->username }}</p>
                                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($loan->tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($loan->tanggal_selesai)->format('d/m/Y') }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">Tidak ada barang Anda yang sedang dipinjam.</p>
                        @endforelse
                        @include('partials.modal-sedang-dipinjam')
                    </div>
                </div>
            
                <div>
                    <h1 class="font-semibold mb-4 text-danger-stroke">Pengembalian Bermasalah:</h1>
                    {{-- 
                      Perbaikan x-data: 'isSedangDipinjamModalOpen'
                      (Modal 'modal-sedang-dipinjam' mungkin digunakan lagi di sini)
                      dan tambahkan 'selectedLoan'
                    --}}
                    <div x-data="{isSedangDipinjamModalOpen: false, selectedLoan: null}" class="flex flex-col gap-4 max-h-80 overflow-y-auto" >
                        
                        {{-- Ganti kartu statis dengan looping @forelse --}}
                        @forelse ($dipinjam_bermasalah as $loan)
                            <div @click="isSedangDipinjamModalOpen = true; selectedLoan = {{ $loan->toJson() }}" 
                                 class="bg-danger-fill border-2 border-danger-stroke p-4 rounded-lg cursor-pointer transition hover:shadow-lg">
                                
                                <h3 class="font-semibold">{{ $loan->item->nama_item }} ({{ $loan->jumlah }} unit)</h3>
                                <p class="text-sm text-gray-600">Oleh: {{ $loan->peminjam->username }}</p>
                                <p class="text-sm text-red-700 font-medium">Masalah: {{ $loan->keterangan_sanksi ?? 'Hubungi peminjam.' }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">Tidak ada barang bermasalah.</p>
                        @endforelse

                        {{-- 
                          Ini mungkin perlu diubah ke modal 'modal-bermasalah-detail'
                          tapi untuk sekarang kita gunakan modal 'sedang-dipinjam'
                        --}}
                        @include('partials.modal-sedang-dipinjam')
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    function app() {
        return {
            MONTH_NAMES: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            month: '',
            year: '',
            no_of_days: [],
            blankdays: [],
            days: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],

            // eventsnya akan diisi oleh controller
            events: @json($calendarEvents ?? []), 
            
            // variabel untuk menampilkan data di bagian kanan
            event_title: '',
            event_date: '',
            selected_date: '',
            events_on_selected_date: [],

            themes: {
                "blue": "bg-blue-500",
                "red": "bg-red-500",
                "yellow": "bg-yellow-500",
                "green": "bg-green-500",
            },

            initDate() {
                let today = new Date();
                this.month = today.getMonth();
                this.year = today.getFullYear();
                this.selected_date = new Date(this.year, this.month, today.getDate()).toDateString();
            },

            isToday(date) {
                const today = new Date();
                const d = new Date(this.year, this.month, date);
                return today.toDateString() === d.toDateString();
            },

            // fungsi untuk menampilkan event dibagian kanan
            showEvents(date) {
                let selected = new Date(this.year, this.month, date);
                this.selected_date = selected.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
                
                let selectedDateString = selected.toDateString();
                
                // memfilter event berdasarkan tanggal yang diklik
                this.events_on_selected_date = this.events.filter(event => {
                    let eventDate = new Date(event.event_date);
                    return eventDate.toDateString() === selectedDateString;
                });
            },

            // fungsi untuk mengecek apakah ada event ditanggal yang dipilih
            hasEvent(date) {
                let d = new Date(this.year, this.month, date);
                let dateString = d.toDateString();
                
                return this.events.find(event => {
                    let eventDate = new Date(event.event_date);
                    return eventDate.toDateString() === dateString;
                });
            },
            
            // fungsi untuk mengambil tema/warna event
            getEventTheme(date) {
                let event = this.hasEvent(date);
                if (event) {
                    return this.themes[event.event_theme] || this.themes['blue'];
                }
                return '';
            },

            getNoOfDays() {
                let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
                let dayOfWeek = new Date(this.year, this.month).getDay();
                let blankdaysArray = [];
                for (var i = 1; i <= dayOfWeek; i++) {
                    blankdaysArray.push(i);
                }

                let daysArray = [];
                for (var i = 1; i <= daysInMonth; i++) {
                    daysArray.push(i);
                }

                this.blankdays = blankdaysArray;
                this.no_of_days = daysArray;

                // langsung menampilkan event untuk hari ini saat load
                this.showEvents(new Date().getDate());
            }
        }
    }
</script>
@endpush