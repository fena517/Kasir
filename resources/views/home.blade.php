@extends('layout.template')

@section('content')
<div class="container-fluid px-4">
    <!-- WELCOME CARD -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg p-4 d-flex flex-row align-items-center justify-content-between rounded-3">
                <div>
                    <h5 class="fw-bold mb-1">Selamat Datang Kembali, Admin!</h5>
                    <p class="text-muted mb-0">Semoga hari kerja Anda menyenangkan dan produktif.</p>
                </div>
                <!-- FOTO DIPERBESAR -->
                <img src="{{ asset('assets/img/dashboard.png') }}" alt="Welcome Image" class="img-fluid w-auto" style="max-width: 150px;">
            </div>
        </div>
    </div>

    <!-- PERINGATAN KADALUWARSA -->
    @if($produkKadaluarsa->count() > 0)
    <div class="row mt-3">
        <div class="col-12">
            <div class="alert alert-warning rounded-3">
                <strong>Peringatan!</strong> Produk berikut akan kedaluwarsa dalam 7 hari:
                <ul class="mb-0">
                    @foreach($produkKadaluarsa as $produk)
                    <li><strong>{{ $produk->produk->NamaProduk }}</strong> - <span class="text-danger">{{ \Carbon\Carbon::parse($produk->Kadaluarsa)->format('d M Y') }}</span></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <!-- STATISTIK KARTU -->
    <div class="row mt-3">
        @php
            $cards = [
                ['color' => 'primary', 'icon' => 'shopping-cart', 'title' => 'Total Penjualan', 'value' => 'Rp '.number_format($totalPenjualan, 0, ',', '.')],
                ['color' => 'success', 'icon' => 'wallet', 'title' => 'Pendapatan Bulan Ini', 'value' => 'Rp '.number_format($pendapatanBulanIni, 0, ',', '.')],
                ['color' => 'danger', 'icon' => 'receipt', 'title' => 'Transaksi Hari Ini', 'value' => $transaksiHariIni.' Transaksi'],
                ['color' => 'warning', 'icon' => 'exclamation-triangle', 'title' => 'Stok Hampir Habis', 'value' => $stokHampirHabis.' Item']
            ];
        @endphp
        
        @foreach($cards as $card)
        <div class="col-lg-3 col-md-6">
            <div class="card shadow-lg border-0 rounded-3 card-hover">
                <div class="card-body text-center">
                    <div class="text-{{ $card['color'] }} mb-2">
                        <i class="fas fa-{{ $card['icon'] }} fa-2x"></i>
                    </div>
                    <h6 class="text-muted mb-1">{{ $card['title'] }}</h6>
                    <h5 class="fw-bold">{{ $card['value'] }}</h5>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- PRODUK TERLARIS & GRAFIK -->
    <div class="row mt-3">
        <div class="col-lg-6">
            <div class="card shadow-lg border-0 rounded-3 card-hover">
                <div class="card-header text-white bg-dark fw-bold">
                    <i class="fas fa-star me-2"></i> Produk Terlaris
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover text-center align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Terjual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($produkTerlaris as $index => $produk)
                                <tr>
                                    <td class="fw-bold">{{ $index + 1 }}</td>
                                    <td class="text-start">
                                        <i class="fas fa-box-open text-primary me-2"></i>
                                        {{ $produk->nama }}
                                    </td>
                                    <td class="fw-bold text-success">{{ $produk->terjual }}x</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>        
        <div class="col-lg-6">
            <div class="card shadow-lg border-0 rounded-3 card-hover">
                <div class="card-header bg-light fw-bold">Grafik Penjualan</div>
                <div class="card-body">
                    <canvas id="chartPenjualan"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('chartPenjualan').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($tanggalPenjualan),
            datasets: [{
                label: 'Penjualan',
                data: @json($jumlahPenjualan),
                borderColor: '#007bff',
                borderWidth: 2,
                fill: false
            }]
        },
        options: {
            scales: {
                x: { title: { display: true, text: 'Tanggal' } },
                y: { title: { display: true, text: 'Jumlah Penjualan' }, beginAtZero: true }
            }
        }
    });
</script>

<!-- CSS HOVER -->
<style>
    .card-hover {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }
    .card-hover:hover {
        transform: scale(1.05);
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection
