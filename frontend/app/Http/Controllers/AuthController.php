<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function showLoginPage(Request $request)
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = $request->username;
        $password = $request->password;

        $rememberToken = $request->has('remember_token') ? true : false;

        if ($request->remember_token) {
            Cookie::queue('cookie_username', $username, 5);
            Cookie::queue('cookie_pass', $password, 5);
        } else {
            Cookie::queue('cookie_username', $username, -1);
            Cookie::queue('cookie_pass', $password, -1);
        }


        if (Auth::attempt(['username' => $request->username, 'password' => $request->password], $rememberToken)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Login Success!');
        }

        return back()->with('error','Wrong username or password');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('warning','You have logged out');
    }
}
