<!DOCTYPE html>
<html>
<head>
    <title>Laporan Riwayat Peminjaman</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; color: #2563EB; }
        .header p { margin: 5px 0; color: #555; }
        
        h3 { border-bottom: 2px solid #ddd; padding-bottom: 5px; margin-top: 30px; color: #444; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        
        .status-selesai { color: green; }
        .status-bermasalah { color: red; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Riwayat Peminjaman SIOREK</h1>
        <p>Pengguna: <strong>{{ $user->username }}</strong> ({{ $user->nama_organisasi ?? 'Perorangan' }})</p>
        <p>Tanggal Cetak: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <h3>Riwayat Saya Meminjam</h3>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Barang</th>
                <th width="20%">Pemilik</th>
                <th width="25%">Tanggal</th>
                <th width="25%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pinjamanSaya as $loan)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $loan->item->nama_item ?? 'Item Dihapus' }} ({{ $loan->jumlah }})</td>
                <td>{{ $loan->pemilik->username ?? 'User Dihapus' }}</td>
                <td>{{ \Carbon\Carbon::parse($loan->tanggal_mulai)->format('d/m/y') }} - {{ \Carbon\Carbon::parse($loan->tanggal_selesai)->format('d/m/y') }}</td>
                <td>
                    @if($loan->status == 'bermasalah') <span class="status-bermasalah">Bermasalah</span>
                    @elseif($loan->status == 'selesai') <span class="status-selesai">Selesai</span>
                    @else {{ ucwords(str_replace('_', ' ', $loan->status)) }}
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align: center;">Tidak ada riwayat peminjaman.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3>Riwayat Barang Saya Dipinjam Orang Lain</h3>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Barang</th>
                <th width="20%">Peminjam</th>
                <th width="25%">Tanggal</th>
                <th width="25%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pinjamanOrangLain as $loan)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $loan->item->nama_item ?? 'Item Dihapus' }} ({{ $loan->jumlah }})</td>
                <td>{{ $loan->peminjam->username ?? 'User Dihapus' }}</td>
                <td>{{ \Carbon\Carbon::parse($loan->tanggal_mulai)->format('d/m/y') }} - {{ \Carbon\Carbon::parse($loan->tanggal_selesai)->format('d/m/y') }}</td>
                <td>
                    @if($loan->status == 'bermasalah') <span class="status-bermasalah">Bermasalah</span>
                    @elseif($loan->status == 'selesai') <span class="status-selesai">Selesai</span>
                    @else {{ ucwords(str_replace('_', ' ', $loan->status)) }}
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align: center;">Belum ada barang Anda yang dipinjam.</td></tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>