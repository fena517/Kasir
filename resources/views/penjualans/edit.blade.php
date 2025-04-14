@extends('layout.template')
@section('content')
<div class="container">
    <div class="container form-container mt-3"> 
        <div class="card">
            <div class="card-header py-3">
<h2>Edit Pelanggan</h2>
<form action="{{ route('penjualans.update', $penjualan->PenjualanId) }}" method="POST">
    @csrf
    @method('PUT')
    <div>
        <label for="TanggalPenjualan">Tanggal Penjualan</label>
        <input type="date" name="TanggalPenjualan" value="{{ $penjualan->TanggalPenjualan }}" required>
    </div>
    <div>
        <label for="TotalHarga">Total Harga</label>
        <input type="number" name="TotalHarga" step="0.01" value="{{ $penjualan->TotalHarga }}" required>
    </div>
    <label for="PelangganId" class="form-label">Nama Pelanggan</label>
    <select class="form-select @error('PelangganId') is-invalid @enderror" id="PelangganId" name="PelangganId" required>
        <option value =""> Pilih Pelanggan </option>
        @foreach ($pelanggans as $pelanggan)
            <option value="{{ $pelanggan->PelangganId }}" {{ old('PelangganId', $penjualan->PelangganId) == $pelanggan->PelangganId ? 'selected' : '' }}>
                {{ $pelanggan->NamaPelanggan }} 
            </option>
        @endforeach
    </select>
    <button type="submit">Simpan</button>
    <a href="{{ route('penjualans.index') }}">Batal</a>
</form>
</div>
</div>
</div>
@endsection
