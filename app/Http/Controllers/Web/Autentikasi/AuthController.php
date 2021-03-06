<?php

namespace App\Http\Controllers\Web\Autentikasi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;


class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function loginsession(Request $request)
    {

        request()->validate(
            [
                // 'nomor_telepon' => 'required',
                'email' => 'required',
                'password' => 'required',
            ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            if (auth()->user()->role == 'Super Admin') {
                return redirect('/superadmin');
            } elseif (auth()->user()->role == 'Admin') {
                return redirect('/admin');
            } elseif (auth()->user()->role == 'Bendesa') {
                return redirect('/admin');
            } elseif (auth()->user()->role == 'Penyarikan') {
                return redirect('/admin');
            } elseif (auth()->user()->role == 'Panitia') {
                return redirect('/admin');
            } else {
                return redirect('/krama');
            }
        }

        return redirect('/login') ->withInput()
                                  ->withErrors(['login_gagal' => 'Username atau Password tidak cocok!']);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return Redirect('/login');
    }
}
