<!DOCTYPE html>
<html>
<head>
    <title>Rekap Transaksi SIORek</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 16px; color: #2563EB; }
        .header p { margin: 5px 0; color: #555; font-size: 12px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; table-layout: fixed; }
        th, td { border: 1px solid #ddd; padding: 5px; text-align: left; vertical-align: middle; }
        th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        td.center { text-align: center; }
        
        .wrap-text {
            word-wrap: break-word;
            word-break: break-word;
            white-space: normal;
        }

        .status-selesai { color: green; font-weight: bold; }
        .status-bermasalah { color: red; font-weight: bold; }
        .status-dipinjam { color: blue; }

        .bukti-foto { width: 35px; height: 35px; object-fit: cover; border: 1px solid #999; display: inline-block; }
        .ktm-foto { width: 40px; height: auto; border: 1px solid #999; }
        .no-foto { color: #aaa; font-style: italic; font-size: 9px; }

        a.link-surat { text-decoration: none; color: #2563EB; font-weight: bold; }
        a.link-surat:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Rekap Transaksi SIORek</h1>
        <p>Filter: {{ $filterInfo }}</p>
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="18%">Barang</th>
                <th width="12%">Peminjam</th>
                <th width="12%">Pemilik</th>
                <th width="8%">ID (KTM)</th>
                <th width="6%">Surat</th>
                <th width="10%">Foto Awal</th>
                <th width="10%">Foto Akhir</th>
                <th width="12%">Tanggal</th>
                <th width="8%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loans as $loan)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td class="wrap-text">
                    <strong>{{ $loan->item->nama_item ?? 'Item Dihapus' }}</strong><br>
                    <span style="color: #666;">({{ $loan->jumlah }} unit)</span>
                </td>
                <td class="wrap-text">{{ $loan->peminjam->username ?? '-' }}</td>
                <td class="wrap-text">{{ $loan->pemilik->username ?? '-' }}</td>
                
                <td class="center">
                    @if($loan->foto_kim)
                        <img src="{{ public_path('storage/' . $loan->foto_kim) }}" class="ktm-foto">
                    @else <span class="no-foto">-</span> @endif
                </td>

                <td class="center">
                    @if($loan->surat_peminjaman)
                        <a href="{{ asset('storage/' . $loan->surat_peminjaman) }}" target="_blank" class="link-surat">
                            Lihat
                        </a>
                    @else <span class="no-foto">-</span> @endif
                </td>

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
                    @else <span class="no-foto">-</span> @endif
                </td>

                <td>
                    Mulai: {{ \Carbon\Carbon::parse($loan->tanggal_mulai)->format('d/m/y') }}<br>
                    Selesai: {{ \Carbon\Carbon::parse($loan->tanggal_selesai)->format('d/m/y') }}
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
            @endforeach
        </tbody>
    </table>

</body>
</html>