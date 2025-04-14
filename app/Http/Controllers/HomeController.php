<?php

namespace App\Http\Controllers;

use App\Penjualan;
use App\Produk;
use App\Pelanggan;
use App\StockIn;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
{
    $hariIni = Carbon::today();
    $batasKadaluarsa = $hariIni->addDays(7); // Notifikasi untuk produk yang akan kedaluwarsa dalam 7 hari

    $produkKadaluarsa = StockIn::where('Kadaluarsa', '<=', $batasKadaluarsa)
        ->with('produk') // Pastikan relasi produk ada di model
        ->orderBy('Kadaluarsa', 'asc')
        ->get();

    // Total penjualan (jumlahkan semua total harga)
    $totalPenjualan = (float) Penjualan::sum('TotalHarga'); 

    // Total produk
    $totalProduk = Produk::count();

    // Stok hampir habis (produk dengan stok kurang dari 5)
    $stokHampirHabis = Produk::where('stok', '<', 5)->count();

    // Transaksi hari ini
    $transaksiHariIni = Penjualan::whereDate('TanggalPenjualan', now()->toDateString())->count();

    // Pendapatan bulan ini
    $pendapatanBulanIni = (float) Penjualan::whereMonth('TanggalPenjualan', now()->month)
        ->sum('TotalHarga');

    // Penjualan terbaru (mengambil 5 transaksi terbaru)
    $penjualans = Penjualan::with(['pelanggan', 'produk'])->latest()->limit(5)->get();

    // Data untuk grafik penjualan (mengelompokkan berdasarkan tanggal)
    $grafikData = Penjualan::select(DB::raw("DATE(TanggalPenjualan) as tanggal"), DB::raw("COUNT(*) as total"))
        ->groupBy(DB::raw("DATE(TanggalPenjualan)"))
        ->orderBy('tanggal')
        ->get();

    $tanggalPenjualan = $grafikData->pluck('tanggal');
    $jumlahPenjualan = $grafikData->pluck('total');

    // Ambil produk terlaris dengan menghitung jumlah penjualan dari detail_penjualans
    $produkTerlaris = DB::table('produks')
        ->join('detail_penjualans', 'produks.ProdukId', '=', 'detail_penjualans.ProdukId')
        ->select('produks.NamaProduk as nama', DB::raw("SUM(detail_penjualans.JumlahProduk) as terjual"))
        ->groupBy('produks.ProdukId', 'produks.NamaProduk')
        ->orderBy('terjual', 'desc')
        ->limit(5)
        ->get();

    // RETURN VIEW HARUS DI PANGGIL PALING AKHIR
    return view('home', compact(
        'produkKadaluarsa',
        'totalPenjualan',
        'totalProduk',
        'stokHampirHabis',
        'transaksiHariIni',
        'pendapatanBulanIni',
        'penjualans',
        'tanggalPenjualan',
        'jumlahPenjualan',
        'produkTerlaris'
    ));
}
}
