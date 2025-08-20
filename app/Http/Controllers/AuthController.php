<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /*لاگین*/
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /*ورود*/
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'))->with('success', 'ورود با موفقیت انجام شد.');
        }

        return back()->withErrors([
            'email' => 'ایمیل یا رمز عبور نادرست است.',
        ])->onlyInput('email');
    }

    /*فرم ثبت‌نام*/
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /*ثبت‌نام کاربر*/
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'customer',
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'ثبت‌نام با موفقیت انجام شد.');
    }

    /*خروج از سیستم*/
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
