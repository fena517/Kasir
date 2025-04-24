<?php

namespace App\Http\Controllers;

use App\Penjualan;
use App\Pelanggan;
use App\Produk;
use App\Pembayaran;
use App\DetailPenjualan;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penjualans = Penjualan::with('pelanggan')
        ->orderBy('TanggalPenjualan', 'desc') // Mengurutkan berdasarkan tanggal terbaru
        ->paginate(10);
        return view('penjualans.index', compact('penjualans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pelanggans = Pelanggan::all();
        $produks = Produk::all();
        $details = session('penjualan_details', []);
        return view('penjualans.create', compact('pelanggans', 'produks', 'details'));
    }


    public function addDetailToSession(Request $request)
    {
        $request->validate([
            'ProdukId' => 'required|exists:produks,ProdukId',
            'JumlahProduk' => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->ProdukId);
        $subTotal = $produk->Harga * $request->JumlahProduk;

        $details = session('penjualan_details', []);
        $details[] = [
            'ProdukId' => $request->ProdukId,
            'NamaProduk' => $produk->NamaProduk,
            'Harga' => $produk->Harga,
            'JumlahProduk' => $request->JumlahProduk,
            'SubTotal' => $subTotal,
        ];

        session(['penjualan_details' => $details]);

        return back()->with('success', 'Detail berhasil ditambahkan.');
    }

    public function clearDetailsSession()
    {
        session()->forget('penjualan_details');
        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $request->validate([
        'TanggalPenjualan' => 'required|date',
        'PelangganId' => 'nullable|exists:pelanggans,PelangganId',
        'ProdukId' => 'required|array|min:1',
        'ProdukId.*' => 'exists:produks,ProdukId',
        'JumlahProduk' => 'required|array',
        'JumlahProduk.*' => 'numeric|min:1',
    ]);

    \DB::beginTransaction();
    try {
        $penjualan = Penjualan::create([
            'TanggalPenjualan' => $request->TanggalPenjualan,
            'PelangganId' => $request->PelangganId, 
            'TotalHarga' => 0,
        ]);

        $totalHarga = 0;

        foreach ($request->ProdukId as $key => $produkId) {
            $produk = Produk::findOrFail($produkId);
            $jumlah = $request->JumlahProduk[$key];

            if ($produk->stok < $jumlah) {
                return redirect()->back()->with('error', "Stok {$produk->NamaProduk} tidak mencukupi! (Tersisa: {$produk->stok})");
            }

            $subtotal = $produk->Harga * $jumlah;
            $totalHarga += $subtotal;

            $produk->stok -= $jumlah;
            $produk->save();

            DetailPenjualan::create([
                'PenjualanId' => $penjualan->PenjualanId,
                'ProdukId' => $produkId,
                'Harga' => $produk->Harga,
                'JumlahProduk' => $jumlah,
                'SubTotal' => $subtotal,
            ]);
        }

        $penjualan->update(['TotalHarga' => $totalHarga]);
        \DB::commit();

        return redirect()->route('pembayarans.create', ['penjualanId' => $penjualan->PenjualanId])->with('success', 'Penjualan berhasil, lanjutkan ke pembayaran.');
    } catch (\Exception $e) {
        \DB::rollBack();
        return redirect()->back()->with('error', 'Terjadi kesalahan, silakan coba lagi.');
    }
}

    /**
     * Display the specified resource.
     *
     * @param  \App\penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
{
    $penjualan = Penjualan::with(['pelanggan', 'details.produk'])->findOrFail($id);
    return view('penjualans.show', compact('penjualan'));
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $pelanggans = Pelanggan::all();
        return view ('penjualans.edit', compact('penjualan', 'pelanggans'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'TanggalPenjualan' => 'required',
            'TotalHarga' => 'required|numeric|min:0',
            'PelangganId' => 'nullable|exists:pelanggans,PelangganId',
        ]);

        $penjualan = Penjualan::findOrFail($id);
        $penjualan->update($request->all());

        return redirect()->route('penjualans.show', $penjualan->PenjualanId)->with('success', 'Penjualan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    $penjualan = Penjualan::with('details.produk')->findOrFail($id);

        if ($penjualan->details->isNotEmpty()) {
            foreach ($penjualan->details as $detail) {
                $produk = $detail->produk;
                if ($produk) {
                    $jumlah = is_numeric($detail->Jumlah) ? (int) $detail->Jumlah : 0;
                    if ($jumlah > 0) {
                        $produk->stok = $produk->stok + $jumlah;
                        $produk->save();
                    }
                }
                $subtotal = is_numeric($detail->Subtotal) ? (int) $detail->Subtotal : 0;
                if ($subtotal > 0) {
                    $penjualan->decrement('TotalHarga', $subtotal);
                }
                $detail->delete();
            }
        }

        $penjualan->delete();
        return redirect()->route('penjualans.index')->with('success', 'Penjualan berhasil dihapus.');
}
}
