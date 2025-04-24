<?php

namespace App\Http\Controllers;

use App\StockIn;
use App\produk;
use App\supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stock_ins = StockIn::orderBy('Tgl', 'desc')->paginate(10);
        return view('stock_ins.index', compact('stock_ins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stock_ins = StockIn::all();
        $produks = Produk::all();
        $suppliers = Supplier::all();
        return view ('stock_ins.create', compact('stock_ins', 'suppliers', 'produks'));
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
            'ProdukId.*' => 'required|exists:produks,ProdukId',
            'SupplierId.*' => 'required|exists:suppliers,SupplierId',
            'Jumlah.*' => 'required|integer|min:1',
            'Harga.*' => 'required',
            'Tgl.*' => 'required|date',
            'Kadaluarsa.*' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $produkIds = $request->ProdukId;
        $jumlahs = $request->Jumlah;
        $hargas = $request->Harga;
        $tgls = $request->Tgl;
        $kadaluarsas = $request->Kadaluarsa;
        $supplierIds = $request->SupplierId;

        foreach ($produkIds as $index => $produkId) {
            $harga = (int) str_replace('.', '', $hargas[$index]);
        
            $stockIn = StockIn::create([
                'ProdukId' => $produkId,
                'SupplierId' => $supplierIds[$index],
                'Jumlah' => $jumlahs[$index],
                'Harga' => $harga,
                'Tgl' => $tgls[$index],
                'Kadaluarsa' => $kadaluarsas[$index],
            ]);
        
            // Update stok produk
            $produk = Produk::findOrFail($produkId);
            $produk->stok += $jumlahs[$index];
            $produk->save();
        }        

        session()->flash('success', 'Beberapa produk berhasil ditambahkan ke stok masuk!');
        return redirect()->route('stock_ins.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\stock_in  $stock_in
     * @return \Illuminate\Http\Response
     */
    public function show(stock_in $stock_in)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\stock_in  $stock_in
     * @return \Illuminate\Http\Response
     */
    public function edit(StockIn $stock_in)
    {
        $stock_in = StockIn::findOrFail($id);
        return view ('stock_ins.edit', compact('stock_in'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\stock_in  $stock_in
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StockIn $stock_in)
    {
        $request->validate([
            'ProdukId' => 'required|exists:produks,ProdukId',
            'SupplierId' => 'required|exists:suppliers,SupplierId',
            'Jumlah' => 'required|integer|min:1',
            'Harga' => 'required|numeric|min:0',
            'Tgl' => 'required|date',
            'Kadaluarsa' => 'required|date',
        ]);

        $stock_in = StockIn::findOrFail($id);
        $stock_in->update($request->all());
        return redirect()->route('stock_ins.index')->with('success', 'Pelanggan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\stock_in  $stock_in
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockIn $stock_in)
    {
        $stock_in = StockIn::findOrFail($id);
        $stock_in->delete();
        return redirect()->route('stock_ins.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
