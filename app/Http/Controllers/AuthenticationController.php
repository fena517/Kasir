<?php

namespace App\Http\Controllers;

use App\user;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function showFormLogin()
    {
        return view('authentication.login'); // Sesuaikan path view
    }

    // Proses login
    public function postLogin(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Cek kredensial
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('home')->with('success', 'Anda berhasil masuk.');
        }

        // Jika login gagal
        return back()->with('error', 'Email atau password salah.');
    }

    // Menampilkan form register
    public function showFormRegister()
    {
        return view('authentication.register'); // Sesuaikan path view
    }

    // Proses registrasi
    public function postRegister(Request $request)
    {
        // Validasi input registrasi
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed', // Validasi konfirmasi password
        ];

        $this->validate($request, $rules);

        // Membuat user baru dengan role default 'user'
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Login user setelah registrasi
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Registrasi berhasil dan Anda telah login sebagai User.');
    }

    // Proses logout
    public function logout()
    {
        // Logout dan hapus session
        Auth::logout();
        Session::flush();
        return redirect('/login')->with('success', 'Anda telah logout.');
    }
}
