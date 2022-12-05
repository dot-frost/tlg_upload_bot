<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDO;

class AuthController extends Controller
{
    public function loginView()
    {
        return \view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only(['email', 'password']);

        if (\auth()->attempt($credentials)) {
            return \redirect()->route('dashboard');
        }

        return \redirect()->back()->withErrors([
            'email' => 'Credentials invalid'
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/login');
    }
}
