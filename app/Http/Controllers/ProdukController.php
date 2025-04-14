<?php

namespace App\Http\Controllers;

use App\produk;
use App\kategori;
use App\unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produks = Produk::orderBy('NamaProduk', 'asc')->paginate(10);
        return view('produks.index', compact('produks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategoris = Kategori::all();
        $units = Unit::all();
        return view ('produks.create', compact('kategoris', 'units'));
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
        'KodeProduk' => 'required|string|max:10',
        'NamaProduk' => 'required|string|max:50',
        'KategoriId' => 'required|exists:kategoris,KategoriId',
        'UnitId' => 'required|exists:units,UnitId',
        'Harga' => 'required|numeric|min:0',
        'stok' => 'required|numeric|min:0',
    ]);
    
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Hapus titik sebelum disimpan ke database
    $harga = str_replace('.', '', $request->Harga);
    
    Produk::create([
        'KodeProduk' => $request->KodeProduk,
        'NamaProduk' => $request->NamaProduk,
        'KategoriId' => $request->KategoriId,
        'UnitId' => $request->UnitId,
        'Harga' => $harga,
        'stok' => $request->stok,
    ]);

    session()->flash('success', 'Produk berhasil ditambahkan!');
    return redirect()->route('produks.index');
}


    /**
     * Display the specified resource.
     *
     * @param  \App\produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produks.show', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategoris = Kategori::all();
        $units = Unit::all();
        
        return view('produks.edit', compact('produk', 'kategoris', 'units'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'KodeProduk' => 'required|string|max:10',
        'NamaProduk' => 'required|string|max:50',
        'KategoriId' => 'required|exists:kategoris,KategoriId',
        'UnitId' => 'required|exists:units,UnitId',
        'Harga' => 'required|numeric|min:0',
        'stok' => 'required|numeric|min:0',
    ]);

    $harga = str_replace('.', '', $request->Harga);

    $produk = Produk::findOrFail($id);
    $produk->update([
        'KodeProduk' => $request->KodeProduk,
        'NamaProduk' => $request->NamaProduk,
        'KategoriId' => $request->KategoriId,
        'UnitId' => $request->UnitId,
        'Harga' => $harga,
        'stok' => $request->stok,
    ]);

    return redirect()->route('produks.index')->with('success', 'Produk berhasil diperbarui');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        return redirect()->route('produks.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
