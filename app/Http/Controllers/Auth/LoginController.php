<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function handleLogin(Request $request)
    {
        $validated = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required'
            ],
            [
                'email.required' => 'Email is required',
                'email.email' => 'Email is not valid',
                'password.required' => 'Password is required',
            ]
        );
        if (Auth::attempt($validated)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        } else {
            return back()->withErrors([
                'email' => 'email atau password salah.',
            ])->onlyInput('email');
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
