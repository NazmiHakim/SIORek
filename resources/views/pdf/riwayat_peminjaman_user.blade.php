<!DOCTYPE html>
<html>
<head>
    <title>Laporan Riwayat Peminjaman</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 16px; color: #2563EB; }
        .header p { margin: 5px 0; color: #555; font-size: 12px; }
        
        h3 { border-bottom: 2px solid #ddd; padding-bottom: 5px; margin-top: 30px; color: #444; font-size: 14px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; vertical-align: middle; }
        th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        td.center { text-align: center; }
        
        .status-selesai { color: green; font-weight: bold; }
        .status-bermasalah { color: red; font-weight: bold; }
        .status-dipinjam { color: blue; }

        .bukti-foto {
            width: 35px;
            height: 35px;
            object-fit: cover;
            border: 1px solid #999;
            display: inline-block;
        }
        .no-foto {
            color: #aaa;
            font-style: italic;
            font-size: 9px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Riwayat Peminjaman SIORek</h1>
        <p>Pengguna: <strong>{{ $user->username }}</strong> ({{ $user->nama_organisasi ?? 'Perorangan' }})</p>
        <p>Tanggal Cetak: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <h3>A. Riwayat Saya Meminjam</h3>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Barang</th>
                <th width="15%">Pemilik</th>
                <th width="10%">Foto Awal</th>
                <th width="10%">Foto Akhir</th>
                <th width="25%">Tanggal</th>
                <th width="15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pinjamanSaya as $loan)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>
                    <strong>{{ $loan->item->nama_item ?? 'Item Dihapus' }}</strong><br>
                    <span style="color: #666;">({{ $loan->jumlah }} unit)</span>
                </td>
                <td>{{ $loan->pemilik->username ?? 'User Dihapus' }}</td>

                <td class="center">
                    @if($loan->foto_kondisi_awal)
                        <img src="{{ public_path('storage/' . $loan->foto_kondisi_awal) }}" class="bukti-foto">
                    @else
                        <span class="no-foto">-</span>
                    @endif
                </td>

                <td class="center">
                    @if($loan->foto_kondisi_akhir)
                        <img src="{{ public_path('storage/' . $loan->foto_kondisi_akhir) }}" class="bukti-foto">
                    @else
                        <span class="no-foto">-</span>
                    @endif
                </td>

                <td>
                    {{ \Carbon\Carbon::parse($loan->tanggal_mulai)->format('d/m/y') }} - 
                    {{ \Carbon\Carbon::parse($loan->tanggal_selesai)->format('d/m/y') }}
                </td>
                <td class="center">
                    @if($loan->status == 'selesai')
                        <span class="status-selesai">Selesai</span>
                    @elseif($loan->status == 'bermasalah')
                        <span class="status-bermasalah">Bermasalah</span>
                    @else
                        <span class="status-dipinjam">{{ ucwords(str_replace('_', ' ', $loan->status)) }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="center">Tidak ada riwayat peminjaman.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3>B. Riwayat Barang Saya Dipinjam Orang Lain</h3>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Barang</th>
                <th width="15%">Peminjam</th>
                <th width="10%">Foto Awal</th>
                <th width="10%">Foto Akhir</th>
                <th width="25%">Tanggal</th>
                <th width="15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pinjamanOrangLain as $loan)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>
                    <strong>{{ $loan->item->nama_item ?? 'Item Dihapus' }}</strong><br>
                    <span style="color: #666;">({{ $loan->jumlah }} unit)</span>
                </td>
                <td>{{ $loan->peminjam->username ?? 'User Dihapus' }}</td>

                <td class="center">
                    @if($loan->foto_kondisi_awal)
                        <img src="{{ public_path('storage/' . $loan->foto_kondisi_awal) }}" class="bukti-foto">
                    @else
                        <span class="no-foto">-</span>
                    @endif
                </td>

                <td class="center">
                    @if($loan->foto_kondisi_akhir)
                        <img src="{{ public_path('storage/' . $loan->foto_kondisi_akhir) }}" class="bukti-foto">
                    @else
                        <span class="no-foto">-</span>
                    @endif
                </td>

                <td>
                    {{ \Carbon\Carbon::parse($loan->tanggal_mulai)->format('d/m/y') }} - 
                    {{ \Carbon\Carbon::parse($loan->tanggal_selesai)->format('d/m/y') }}
                </td>
                <td class="center">
                    @if($loan->status == 'selesai')
                        <span class="status-selesai">Selesai</span>
                    @elseif($loan->status == 'bermasalah')
                        <span class="status-bermasalah">Bermasalah</span>
                    @else
                        <span class="status-dipinjam">{{ ucwords(str_replace('_', ' ', $loan->status)) }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="center">Belum ada barang Anda yang dipinjam.</td></tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>