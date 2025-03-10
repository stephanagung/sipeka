<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SipekaPengguna;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        $user = SipekaPengguna::where('username', $username)
            ->where('password', $password)
            ->first();

        if ($user) {
            Session::put('user', $user); // Simpan user di sesi
            Session::put('user_departemen', $user->id_departemen); // Simpan ID Departemen di sesi


            if ($user->level === 'Admin') {
                return redirect()->route('dashboard.dashboard-qp-3');
            } elseif ($user->level === 'Atasan') {
                return redirect()->route('dashboard.atasan');
            }

        } else {
            return back()->withErrors(['msg' => 'Username atau password salah']);
        }
    }


    public function logout(Request $request)
    {
        $request->session()->flush(); // Menghapus semua data sesi
        $request->session()->regenerate(); // Regenerasi ID sesi untuk keamanan

        return redirect()->route('login'); // Redirect ke halaman login setelah logout
    }

}
