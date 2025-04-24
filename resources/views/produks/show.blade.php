@extends('layout.template')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>Detail Produk</h3>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Kolom Kiri: Detail Produk --}}
                <div class="col-md-8">
                    <p><strong>Kode Produk:</strong> {{ $produk->KodeProduk }}</p>
                    <p><strong>Nama Produk:</strong> {{ $produk->NamaProduk }}</p>
                    <p><strong>Kategori:</strong> {{ $produk->kategori->Nama }}</p>
                    <p><strong>Unit:</strong> {{ $produk->unit->Nama }}</p>
                    <p><strong>Harga:</strong> Rp {{ number_format($produk->Harga, 0, ',', '.') }}</p>
                    <p><strong>Stok:</strong> {{ $produk->stok }}</p>
                    <a href="{{ route('produks.edit', $produk->ProdukId) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('produks.index') }}" class="btn btn-secondary">Kembali</a>
                </div>

                {{-- Kolom Kanan: Gambar Produk --}}
                <div class="col-md-4 text-center">
                    @if ($produk->GambarProduk)
                        <img src="{{ asset($produk->GambarProduk) }}" alt="Gambar Produk" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                    @else
                        <p><em>Tidak ada gambar.</em></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
