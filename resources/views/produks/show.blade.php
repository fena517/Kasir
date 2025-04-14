@extends('layout.template')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>Detail Produk</h3>
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $produk->NamaProduk }}</h5>
            <p><strong>Kode Produk:</strong> {{ $produk->KodeProduk }}</p>
            <p><strong>Kategori:</strong> {{ $produk->kategori->NamaKategori ?? '-' }}</p>
            <p><strong>Satuan:</strong> {{ $produk->unit->NamaUnit ?? '-' }}</p>
            <p><strong>Harga:</strong> Rp{{ number_format($produk->Harga, 0, ',', '.') }}</p>
            <p><strong>Stok:</strong> {{ $produk->stok }}</p>
            
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
            <a href="{{ route('produks.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
