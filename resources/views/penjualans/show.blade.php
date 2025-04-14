<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 16px;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 30px;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .table th {
            background-color: #f8f8f8;
            font-weight: bold;
        }
        .table .total {
            font-weight: bold;
            font-size: 18px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Detail Penjualan</h1>
        <a href="{{ route('penjualans.index') }}" class="btn">Kembali</a>
        <button class="btn btn-print" onclick="window.print()">Print Struk</button>

        <!-- Tanggal and Pelanggan Info -->
        <table class="table">
            <tr>
                <th>Tanggal Penjualan</th>
                <td class="text-right">{{ \Carbon\Carbon::parse($penjualan->TanggalPenjualan)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Nama Pelanggan</th>
                <td class="text-right">{{ $penjualan->pelanggan->NamaPelanggan ?? '-' }}</td>
            </tr>
        </table>

        <!-- Product Details -->
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach($penjualan->details as $detail)
                    @php
                        $subtotal = $detail->produk->Harga * $detail->JumlahProduk;
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detail->produk->NamaProduk ?? '-' }}</td>
                        <td class="text-right">Rp. {{ number_format($detail->produk->Harga, 0, ',', '.') }}</td>
                        <td class="text-right">{{ $detail->JumlahProduk }}</td>
                        <td class="text-right">Rp. {{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Grand Total -->
        <table class="table">
            <tr>
                <th>Total</th>
                <td class="text-right">Rp. {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
    <script>
        // JavaScript to trigger the print functionality
        function printStruk() {
            window.print();
        }
    </script>
</body>
</html>
