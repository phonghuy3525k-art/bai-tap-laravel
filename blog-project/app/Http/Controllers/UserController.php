<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credential = $request->only(['email', 'password']);

        if (Auth::attempt($credential)) {
            $request->session()->regenerate();

            // Ghi log đăng nhập thành công
            Log::info('login success', ['user' => Auth::user()]);

            return redirect()->route('post.index');
        }

        return back()->withErrors([
            'email' => 'Tài khoản hoặc mật khẩu không chính xác.',
        ])->onlyInput('email');
    }
}