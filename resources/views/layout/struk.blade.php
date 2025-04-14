<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran</title>
    <style>
        @media print {
            @page {
                size: 80mm auto;
                margin: 0;
            }

            body {
                margin: 0;
                font-family: monospace;
                font-size: 10pt;
                color: #000;
            }
        }

        body {
            font-family: monospace;
            font-size: 10pt;
            padding: 0;
            margin: 0;
        }

        .struk-container {
            width: 80mm;
            padding: 5mm;
            margin: auto;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .dashed { border-top: 1px dashed #000; margin: 6px 0; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td, th {
            padding: 2px 0;
        }

        .produk th { text-align: left; border-bottom: 1px solid #000; }
        .produk td { font-size: 9pt; }
    </style>
    @yield('style')
</head>
<body>
    @yield('content')

    <script>
        window.onload = function () {
            window.print();
            setTimeout(function () {
                window.close();
            }, 1000);
        };
    </script>
</body>
</html>
