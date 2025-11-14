<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;

class TransactionController extends Controller
{
    // transaksi admin
    public function index()
    {
        // mengambil semua data peminjaman
        $loans = Loan::with(['item', 'peminjam', 'pemilik'])
                     ->orderBy('created_at', 'desc')
                     ->get();

        // mengirim keview
        return view('rekab-transaksi-admin', [
            'loans' => $loans
        ]);
    }
}