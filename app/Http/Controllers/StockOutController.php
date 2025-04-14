<?php

namespace App\Http\Controllers;

use App\stock_out;
use App\produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stock_outs = stock_out::orderBy('tgl', 'desc')->paginate(10);
        return view('stock_outs.index', compact('stock_outs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stock_outs = Stock_out::all();
        $produks = Produk::all();
        return view ('stock_outs.create', compact('stock_outs', 'produks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ProdukId' => 'required|exists:produks,ProdukId',
            'Jumlah' => 'required|integer|min:1',
            'Tgl' => 'required|date',
            'Alasan' => 'required',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $produk = Produk::findOrFail($request->ProdukId);

        // Cek apakah stok cukup sebelum melakukan stok keluar
        if ($produk->stok < $request->Jumlah) {
            return back()->with('error', 'Stok tidak cukup untuk dikeluarkan.');
        }

        // Simpan stok keluar
        $stock_out = Stock_out::create($request->all());

        // Kurangi stok produk
        $produk->stok -= $request->Jumlah;
        $produk->save(); 

        session()->flash('success', 'Barang keluar berhasil ditambahkan!');

        return redirect()->route('stock_outs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\stock_out  $stock_out
     * @return \Illuminate\Http\Response
     */
    public function show(stock_out $stock_out)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\stock_out  $stock_out
     * @return \Illuminate\Http\Response
     */
    public function edit(stock_out $stock_out)
    {
        $stock_out = Stock_out::findOrFail($id);
        return view ('stock_outs.edit', compact('stock_out'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\stock_out  $stock_out
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, stock_out $stock_out)
    {
        $request->validate([
            'ProdukId' => 'required|exists:produks,ProdukId',
            'Jumlah' => 'required|integer|min:1',
            'Tgl' => 'required|date',
            'Alasan' => 'required',
        ]);

        $stock_out = Stock_out::findOrFail($id);
        $stock_out->update($request->all());
        return redirect()->route('stock_outs.index')->with('success', 'Pelanggan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\stock_out  $stock_out
     * @return \Illuminate\Http\Response
     */
    public function destroy(stock_out $stock_out)
    {
        $stock_out = Stock_out::findOrFail($id);
        $stock_out->delete();
        return redirect()->route('stock_outs.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
