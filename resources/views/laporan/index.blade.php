@extends('layout.template')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center">Laporan Penjualan</h2>
    
    <form action="{{ route('laporan.index') }}" method="GET">
        @csrf
        <div class="form-group">
            <label for="tanggal_mulai">Tanggal Mulai:</label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required 
                value="{{ request('tanggal_mulai') }}">
        </div>

        <div class="form-group mt-2">
            <label for="tanggal_selesai">Tanggal Selesai:</label>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" required 
                value="{{ request('tanggal_selesai') }}">
        </div>

        <button type="submit" class="btn btn-secondary mt-3" name="lihat">Lihat Laporan</button>
        <a href="{{ route('laporan.cetak', ['tanggal_mulai' => request('tanggal_mulai'), 'tanggal_selesai' => request('tanggal_selesai')]) }}" 
            class="btn btn-primary mt-3">Cetak Laporan</a>
    </form>

    @if(isset($penjualans) && count($penjualans) > 0)
    <div class="mt-4">
        <h4 class="text-center">Laporan Penjualan</h4>
        <p class="text-center">Periode: {{ $tanggalMulai->format('d-m-Y') }} sampai {{ $tanggalSelesai->format('d-m-Y') }}</p>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                    <th>Total Harga</th>
                    <th>Metode Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $subTotal = 0;
                    $totalKeseluruhan = 0;
                @endphp
                @foreach($penjualans as $key => $penjualan)
                    @foreach($penjualan->details as $index => $detail)
                    <tr>
                        @if($index === 0)
                            <td rowspan="{{ count($penjualan->details) }}">{{ $key + 1 }}</td>
                            <td rowspan="{{ count($penjualan->details) }}">{{ $penjualan->TanggalPenjualan }}</td>
                            <td rowspan="{{ count($penjualan->details) }}">{{ $penjualan->pelanggan->NamaPelanggan ?? 'Umum' }}</td>
                        @endif
                        <td>{{ $detail->produk->NamaProduk ?? '-' }}</td>
                        <td>{{ $detail->JumlahProduk }}</td>
                        <td>Rp {{ number_format($detail->Harga, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($detail->SubTotal, 0, ',', '.') }}</td>
                        @if($index === 0)
                            <td rowspan="{{ count($penjualan->details) }}">Rp {{ number_format($penjualan->TotalHarga, 0, ',', '.') }}</td>
                            <td rowspan="{{ count($penjualan->details) }}">{{ $penjualan->pembayaran->MetodePembayaran ?? '-' }}</td>
                            
                        @endif
                    </tr>
                    @php $subTotal += $detail->SubTotal; @endphp
                    @endforeach
                    @php $totalKeseluruhan += $penjualan->TotalHarga; @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="7" class="text-right">Total Keseluruhan:</th>
                    <th colspan="2">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
    @elseif(request()->has('lihat'))
    <div class="mt-4">
        <h4 class="text-danger text-center">Tidak ada data penjualan pada rentang tanggal yang dipilih.</h4>
    </div>
    @endif
</div>
@endsection
