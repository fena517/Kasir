<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #1A1A1A;
            background-image: url('{{ asset('assets/img/login.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .text-purple {
            color: #9B4D96;
        }

        .btn-purple {
            background-color: #9B4D96;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 25px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn-purple:hover {
            background-color: #7A3B78;
        }

        .card {
            border-radius: 30px;
            border: none;
            overflow: hidden;
        }

        .card-body {
            background-color: rgba(255, 255, 255, 0.85);
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            background-color: #f1f1f1;
            border: 1px solid #ccc;
            border-radius: 15px;
            padding: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #9B4D96;
            box-shadow: 0 0 8px rgba(155, 77, 150, 0.6);
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        .text-danger {
            font-size: 14px;
        }

        .footer-text {
            color: #fff;
            font-size: 14px;
            text-align: center;
            margin-top: 50px;
        }

        .footer-text a {
            color: #9B4D96;
            text-decoration: none;
        }
    </style>
</head>

<body class="bg-gradient-primary">
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg" style="width: 400px;">
            <div class="card-body text-center">
                <h3 class="text-purple">Login</h3>

                <!-- Menampilkan pesan sukses atau error -->
                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="mb-3">
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email" required value="{{ old('email') }}">
                        @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password" required>
                        @error('password')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-purple w-100">Login</button>
                </form>

                <p class="mt-3">Belum punya akun? <a href="{{ route('register') }}" class="text-purple">Daftar</a></p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
