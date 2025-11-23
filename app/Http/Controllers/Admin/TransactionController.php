<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // mengambil semua akun pengguna untuk filter dopdown
        $users = User::orderBy('username', 'asc')->get();

        // query transaksi
        $query = Loan::with(['item', 'peminjam', 'pemilik'])
                     ->orderBy('created_at', 'desc');

        // filter id user
        $selectedUserId = $request->input('user_id');

        if ($selectedUserId) {
            // Jika ada user idnya maka akan memfilter transaksinya
            $query->where(function($q) use ($selectedUserId) {
                $q->where('peminjam_id', $selectedUserId)
                  ->orWhere('pemilik_id', $selectedUserId);
            });
        }
        
        // 
        $loans = $query->get();

        // tampil di halaman
        return view('rekab-transaksi-admin', [
            'loans' => $loans,
            'users' => $users,
            'selectedUserId' => $selectedUserId
        ]);
    }

    public function exportPdf(Request $request)
    {
        // fitur export juga bisa di filter
        $query = Loan::with(['item', 'peminjam', 'pemilik'])
                     ->orderBy('created_at', 'desc');

        $selectedUserId = $request->input('user_id');

        if ($selectedUserId) {
            $query->where(function($q) use ($selectedUserId) {
                $q->where('peminjam_id', $selectedUserId)
                  ->orWhere('pemilik_id', $selectedUserId);
            });
        }

        $loans = $query->get();

        // judul mengguna usernam atau semua
        $filterInfo = 'Semua Pengguna';
        if ($selectedUserId) {
            $user = User::find($selectedUserId);
            $filterInfo = $user ? $user->username : 'User Tidak Ditemukan';
        }

        // generate pdf dengan view
        $pdf = Pdf::loadView('pdf.rekap_transaksi', [
            'loans' => $loans,
            'filterInfo' => $filterInfo
        ]);

        // didownload
        return $pdf->download('laporan-rekap-transaksi.pdf');
    }
}