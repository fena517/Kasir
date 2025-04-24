<?php

namespace App\Http\Controllers;

use App\produk;
use App\kategori;
use App\unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::orderBy('NamaProduk', 'asc')->paginate(10);
        return view('produks.index', compact('produks'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        $units = Unit::all();
        return view('produks.create', compact('kategoris', 'units'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'KodeProduk'   => 'required|string|max:10|unique:produks,KodeProduk',
            'NamaProduk'   => 'required|string|max:100',
            'KategoriId'   => 'required|exists:kategoris,KategoriId',
            'UnitId'       => 'required|exists:units,UnitId',
            'Harga'        => 'required|numeric|min:0',
            'stok'         => 'required|integer|min:0',
            'GambarProduk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $harga = str_replace('.', '', $request->Harga);

        $produk = new Produk();
        $produk->KodeProduk = $request->KodeProduk;
        $produk->NamaProduk = $request->NamaProduk;
        $produk->KategoriId = $request->KategoriId;
        $produk->UnitId = $request->UnitId;
        $produk->Harga = $harga;
        $produk->stok = $request->stok;

        if ($request->hasFile('GambarProduk')) {
            $file = $request->file('GambarProduk');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/produk'), $filename);
            $produk->GambarProduk = 'images/produk/' . $filename;
        }

        $produk->save();

        return redirect()->route('produks.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produks.show', compact('produk'));
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategoris = Kategori::all();
        $units = Unit::all();
        return view('produks.edit', compact('produk', 'kategoris', 'units'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'KodeProduk'   => 'required|string|max:10|unique:produks,KodeProduk,' . $id . ',ProdukId',
            'NamaProduk'   => 'required|string|max:100',
            'KategoriId'   => 'required|exists:kategoris,KategoriId',
            'UnitId'       => 'required|exists:units,UnitId',
            'Harga'        => 'required|numeric|min:0',
            'stok'         => 'required|integer|min:0',
            'GambarProduk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $harga = str_replace('.', '', $request->Harga);

        $produk->KodeProduk = $request->KodeProduk;
        $produk->NamaProduk = $request->NamaProduk;
        $produk->KategoriId = $request->KategoriId;
        $produk->UnitId = $request->UnitId;
        $produk->Harga = $harga;
        $produk->stok = $request->stok;

        if ($request->hasFile('GambarProduk')) {
            // Hapus gambar lama jika ada
            if ($produk->GambarProduk && file_exists(public_path($produk->GambarProduk))) {
                unlink(public_path($produk->GambarProduk));
            }

            $file = $request->file('GambarProduk');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/produk'), $filename);
            $produk->GambarProduk = 'images/produk/' . $filename;
        }

        $produk->save();

        return redirect()->route('produks.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        // Hapus gambar jika ada
        if ($produk->GambarProduk && file_exists(public_path($produk->GambarProduk))) {
            unlink(public_path($produk->GambarProduk));
        }

        $produk->delete();

        return redirect()->route('produks.index')->with('success', 'Produk berhasil dihapus.');
    }
}
