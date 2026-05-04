<?php

namespace App\Http\Controllers\Printer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrinterAuthController extends Controller
{
    public function showLogin()
    {
        return view('printer.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('printer')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('printer.orders.index');
        }

        return back()->withErrors(['email' => '帳號或密碼錯誤']);
    }

    public function logout(Request $request)
    {
        Auth::guard('printer')->logout();
        $request->session()->invalidate();
        return redirect()->route('printer.login');
    }
}
