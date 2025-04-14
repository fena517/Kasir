<?php

namespace App\Http\Controllers;

use App\Penjualan;
use App\DetailPenjualan;
use PDF;
use Illuminate\Support\Facades\Route;   
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanPenjualanController extends Controller
{
    public function index(Request $request)
{
    $penjualans = [];
    $totalKeseluruhan = 0;

    if ($request->has('tanggal_mulai') && $request->has('tanggal_selesai')) {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $tanggalMulai = Carbon::parse($request->tanggal_mulai)->startOfDay();
        $tanggalSelesai = Carbon::parse($request->tanggal_selesai)->endOfDay();

        $penjualans = Penjualan::whereBetween('TanggalPenjualan', [$tanggalMulai, $tanggalSelesai])
            ->with(['pelanggan', 'details.produk', 'pembayaran'])
            ->get();
        
        foreach ($penjualans as $penjualan) {
            $totalKeseluruhan += $penjualan->TotalHarga;
        }
        $totalKeseluruhan = $penjualans->sum('TotalHarga');
        return view('laporan.index', compact('penjualans', 'tanggalMulai', 'tanggalSelesai', 'totalKeseluruhan'));
    }

    return view('laporan.index');
}

    public function cetakLaporan(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $tanggalMulai = Carbon::parse($request->tanggal_mulai)->startOfDay();
        $tanggalSelesai = Carbon::parse($request->tanggal_selesai)->endOfDay();

        $penjualans = Penjualan::whereBetween('TanggalPenjualan', [$tanggalMulai, $tanggalSelesai])
            ->with(['pelanggan', 'details.produk', 'pembayaran'])
            ->get();

        $totalKeseluruhan = $penjualans->sum('TotalHarga');

        $pdf = PDF::loadView('laporan.cetak', compact('penjualans', 'tanggalMulai', 'tanggalSelesai', 'totalKeseluruhan'));
        return $pdf->download('laporan-penjualan.pdf');
    }

    public function lihatLaporan()
    {
        $penjualans = Penjualan::with(['pelanggan', 'details.produk', 'pembayaran'])->get();
        return view('laporan.lihat', compact('penjualans'));
    }
}
