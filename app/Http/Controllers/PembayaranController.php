<?php

namespace App\Http\Controllers;

use App\Pembayaran;
use App\Penjualan;
use App\DetailPenjualan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pembayarans = Pembayaran::with('penjualan')->get();
        return view('pembayarans.index', compact('pembayarans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $penjualan = Penjualan::with(['details.produk', 'pelanggan', 'pembayaran'])->findOrFail($id);
        return view('pembayarans.create', compact('penjualan'));        
    }

    public function store(Request $request)
    {
        $request->validate([
            'PenjualanId' => 'required|exists:penjualans,PenjualanId',
            'MetodePembayaran' => 'required|string',
            'TotalDibayar' => 'required|numeric|min:0',
        ]);

        $penjualan = Penjualan::findOrFail($request->PenjualanId);
        $kembalian = $request->TotalDibayar - $penjualan->TotalHarga;

        if ($kembalian < 0) {
            return redirect()->back()->with('error', 'Pembayaran kurang!');
        }

        // Simpan pembayaran dengan kode transaksi
        $pembayaran = Pembayaran::create([
            'PenjualanId' => $penjualan->PenjualanId,
            'MetodePembayaran' => $request->MetodePembayaran,
            'TotalDibayar' => $request->TotalDibayar,
            'Kembalian' => $kembalian,
            'KodeTransaksi' => 'TRX-' . strtoupper(Str::random(12)),
        ]);

        // Redirect ke halaman struk setelah pembayaran berhasil
        return redirect()->route('pembayaran.struk', ['id' => $pembayaran->PembayaranId]);
    }


    public function showStruk($id)
    {
        $pembayaran = Pembayaran::with('penjualan.details.produk', 'penjualan.pelanggan')->findOrFail($id);
    
        if (!$pembayaran->penjualan) {
            return redirect()->route('penjualan.index')->with('error', 'Data penjualan tidak ditemukan.');
        }
    
        return view('pembayarans.struk', [
            'penjualan' => $pembayaran->penjualan,
            'pembayaran' => $pembayaran
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pembayaran = Pembayaran::with(['penjualan.pelanggan', 'penjualan.details.produk'])->findOrFail($id);
        return view('pembayarans.show', compact('pembayaran'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $penjualans = Penjualan::all();
        return view('pembayaran.edit', compact('pembayaran', 'penjualans'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'JumlahDiberikan' => 'required|numeric|min:0',
            'MetodePembayaran' => 'required|in:Cash,Transfer,QRIS,Debit,Kredit',
        ]);

        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->JumlahDiberikan = $request->JumlahDiberikan;
        $pembayaran->Kembalian = $request->JumlahDiberikan - $pembayaran->TotalBayar;
        $pembayaran->MetodePembayaran = $request->MetodePembayaran;
        $pembayaran->Status = $request->JumlahDiberikan >= $pembayaran->TotalBayar ? 'Lunas' : 'Belum Lunas';

        $pembayaran->save();

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil dihapus.');
    }
}
