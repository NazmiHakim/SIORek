<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // mengambil semua data peminjaman user ini, peminjam/pemilik
        $loans = Loan::where('peminjam_id', $userId)
                    ->orWhere('pemilik_id', $userId)
                    ->with(['item', 'peminjam', 'pemilik'])
                    ->orderBy('created_at', 'desc')
                    ->get();

        // data untuk "Saya Meminjam"
        $pinjamanSaya = $loans->where('peminjam_id', $userId);
        
        //data untuk "Dipinjam Orang Lain"
        $pinjamanOrangLain = $loans->where('pemilik_id', $userId);

        $calendarEvents = [];
        
        $activeLoans = $loans->filter(function ($loan) {
            return in_array($loan->status, [
                'disetujui', 
                'sedang_dipinjam', 
                'menunggu_konfirmasi_pengembalian', 
                'bermasalah', 
                'selesai',
                'menunggu_persetujuan'
            ]);
        });

        foreach ($activeLoans as $loan) {
            // ini type event
            $type = ($loan->peminjam_id == $userId) ? 'meminjam' : 'meminjamkan';
            
            // tema untuk type, biru untuk kita meminjam dan hijau untuk org lain yang meminjam
            if ($type == 'meminjam') {
                $theme = 'blue';
            } else {
                $theme = 'green';
            }
            
            // warna status
            if (in_array($loan->status, ['disetujui', 'menunggu_konfirmasi_pengembalian', 'menunggu_persetujuan'])) {
                $theme = 'yellow';
            }
            if ($loan->status == 'bermasalah') {
                $theme = 'red';
            }

            // CarbonPeriod untuk iterasi setiap hari dalam rentang
            $period = CarbonPeriod::create($loan->tanggal_mulai, $loan->tanggal_selesai);

            foreach ($period as $date) {
                $calendarEvents[] = [
                    'event_date'  => $date->format('D M d Y'), 
                    'event_title' => $loan->item->nama_item,
                    'event_theme' => $theme,
                    'peminjam'    => $loan->peminjam->username,
                    'pemilik'     => $loan->pemilik->username,
                    'status'      => ucwords(str_replace('_', ' ', $loan->status)),
                    'type'        => $type
                ];
            }
        }

        // mengirim data ke view, dikelompokkan berdasarkan status
        // where,status agar selalu jadi koleksi
        return view('dashboard', [
            // kalender
            'calendarEvents' => $calendarEvents,
            // data untuk barang yang saya pinjam
            'saya_menunggu_persetujuan' => $pinjamanSaya->where('status', 'menunggu_persetujuan'),
            'saya_siap_diambil' => $pinjamanSaya->where('status', 'disetujui'),
            'saya_sedang_meminjam' => $pinjamanSaya->where('status', 'sedang_dipinjam'),
            'saya_proses_pengembalian' => $pinjamanSaya->where('status', 'menunggu_konfirmasi_pengembalian'),
            'saya_bermasalah' => $pinjamanSaya->where('status', 'bermasalah'),

            // data untuk barang yang dipinjam org Lain
            'permintaan_masuk' => $pinjamanOrangLain->where('status', 'menunggu_persetujuan'),
            'menunggu_diambil_peminjam' => $pinjamanOrangLain->where('status', 'disetujui'),
            'sedang_dipinjam_orang' => $pinjamanOrangLain->where('status', 'sedang_dipinjam'),
            'permintaan_pengembalian' => $pinjamanOrangLain->where('status', 'menunggu_konfirmasi_pengembalian'),
            'dipinjam_bermasalah' => $pinjamanOrangLain->where('status', 'bermasalah'),
        ]);
    }
}