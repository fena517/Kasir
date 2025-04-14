<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Primago Travel - Register</title>
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

        .form-label {
            font-weight: bold;
            font-size: 14px;
            color: #333;
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
                <h3 class="text-purple">Registrasi</h3>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
                    </div>
                    <button type="submit" class="btn btn-purple w-100">Daftar</button>
                </form>
                <p class="mt-3">Sudah punya akun? <a href="{{ route('login') }}" class="text-purple">Login</a></p>
            </div>
        </div>
    </div>
</body>

</html>
