<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginFormShow()
    {
        return view('admin.login');
    }
    public function loginCheck(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|min:3|max:30'
        ], [
            'email.exists' => 'This email is not exists on admins table',
        ]);
        $creds = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($creds)) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('admin.login')->with('fail', 'Incorrect credentials');
        }
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
