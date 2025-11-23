<!DOCTYPE html>
<html>
<head>
    <title>Rekap Transaksi SIORek</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; color: #2563EB; }
        .header p { margin: 5px 0; color: #555; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        
        .status-selesai { color: green; font-weight: bold; }
        .status-bermasalah { color: red; font-weight: bold; }
        .status-dipinjam { color: blue; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Rekap Transaksi SIORek</h1>
        <p>Filter: {{ $filterInfo }}</p>
        <p>Tanggal Cetak: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>Peminjam</th>
                <th>Pemilik</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Selesai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loans as $loan)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $loan->item->nama_item ?? 'Barang Dihapus' }} ({{ $loan->jumlah }})</td>
                <td>{{ $loan->peminjam->username ?? 'User Dihapus' }}</td>
                <td>{{ $loan->pemilik->username ?? 'User Dihapus' }}</td>
                <td>{{ \Carbon\Carbon::parse($loan->tanggal_mulai)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($loan->tanggal_selesai)->format('d/m/Y') }}</td>
                <td>
                    {{ ucwords(str_replace('_', ' ', $loan->status)) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>