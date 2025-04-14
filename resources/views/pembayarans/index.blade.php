@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Pembayaran</h2>
    @if(session('success'))
        <div id="flash-message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Penjualan ID</th>
                <th>Metode Pembayaran</th>
                <th>Total Dibayar</th>
                <th>Kembalian</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pembayarans->sortByDesc('PembayaranId') as $pembayaran)
            <tr>
                <td>{{ $pembayaran->PembayaranId }}</td>
                <td>{{ $pembayaran->PenjualanId }}</td>
                <td>{{ $pembayaran->MetodePembayaran }}</td>
                <td>Rp {{ number_format($pembayaran->TotalDibayar, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($pembayaran->Kembalian, 0, ',', '.') }}</td>
                <td>{{ $pembayaran->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    setTimeout(function() {
        var message = document.getElementById('flash-message');
        if (message) {
            message.style.display = 'none';
                }
            }, 5000);
</script>
@endsection
