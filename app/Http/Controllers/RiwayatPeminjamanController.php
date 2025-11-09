<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatPeminjamanController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $pinjamanSaya = Loan::where('peminjam_id', $userId)
                            ->with(['item', 'pemilik'])
                            ->orderBy('created_at', 'desc')
                            ->get();

        $pinjamanOrangLain = Loan::where('pemilik_id', $userId)
                                ->with(['item', 'peminjam'])
                                ->orderBy('created_at', 'desc')
                                ->get();

        $statusAktif = [
            'menunggu_persetujuan', 
            'disetujui', 
            'sedang_dipinjam', 
            'menunggu_konfirmasi_pengembalian'
        ];
        
        $totalSayaPinjam = $pinjamanSaya->count();
        $totalDipinjamOrang = $pinjamanOrangLain->count();
        
        $aktifSaya = $pinjamanSaya->whereIn('status', $statusAktif)->count();
        $aktifOrangLain = $pinjamanOrangLain->whereIn('status', $statusAktif)->count();
        $totalAktif = $aktifSaya + $aktifOrangLain;
        
        $totalSanksi = $pinjamanOrangLain->where('status', 'bermasalah')->count();

        // kirim semua data keview
        return view('riwayat-peminjaman', [
            'pinjamanSaya'       => $pinjamanSaya,
            'pinjamanOrangLain'  => $pinjamanOrangLain,
            'totalSayaPinjam'    => $totalSayaPinjam,
            'totalDipinjamOrang' => $totalDipinjamOrang,
            'totalAktif'         => $totalAktif,
            'totalSanksi'        => $totalSanksi,
        ]);
    }
}