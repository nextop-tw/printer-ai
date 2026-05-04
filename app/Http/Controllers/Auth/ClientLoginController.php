<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientLoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, remember: true)) {
            $request->session()->regenerate();
            return redirect()->intended(route('orders.index'));
        }

        return back()->withErrors(['email' => '帳號或密碼錯誤'])->withInput();
    }
}
