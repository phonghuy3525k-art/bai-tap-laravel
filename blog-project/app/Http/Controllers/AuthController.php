<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // Khai báo Facade Log
use Illuminate\Support\Facades\Mail; // Khai báo Mail
use Illuminate\Support\Str; // Tạo chuỗi ngẫu nhiên cho mật khẩu mới
use App\Models\User;
use App\Mail\WelcomeMail; // Thư viện Mail chào mừng (nếu bạn dùng Mailable)

class AuthController extends Controller
{
    // Hiển thị form đăng ký
    public function showRegister()
    {
        return view('auth.register');
    }

    // Xử lý logic đăng ký tài khoản
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 1. GHI LOG: Thời gian đăng ký thành công
        Log::info('User registered successfully', [
            'email' => $user->email,
            'registered_at' => now(),
        ]);

        // 2. GỬI MAIL: Gửi email chào mừng sau khi đăng ký
        // (Nếu dùng Mailable class như WelcomeMail)
        // Mail::to($user->email)->send(new WelcomeMail($user));
        
        // Hoặc gửi mail thuần nhanh chóng:
        Mail::raw("Xin chào {$user->name}, cảm ơn bạn đã đăng ký tài khoản vào lúc " . now(), function ($message) use ($user) {
            $message->to($user->email)->subject('Chào mừng bạn đến với Blog!');
        });

        // Đăng nhập luôn sau khi đăng ký thành công
        Auth::login($user);

        // Ghi log thời gian đăng nhập ngay sau đăng ký
        Log::info('User logged in after registration', [
            'email' => $user->email,
            'login_at' => now(),
        ]);

        return redirect()->route('post.index')->with('success', 'Đăng ký tài khoản và gửi mail thành công!');
    }

    // Hiển thị form đăng nhập
    public function showLogin()
    {
        return view('auth.login');
    }

    // Xử lý logic đăng nhập
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Ghi log đăng nhập thành công kèm thời gian
            Log::info('Login success', [
                'user' => Auth::user()->email,
                'login_at' => now(),
            ]);

            return redirect()->intended(route('post.index'))->with('success', 'Đăng nhập thành công!');
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ])->onlyInput('email');
    }

    // --- TÍNH NĂNG QUÊN MẬT KHẨU ---

    // Hiển thị form quên mật khẩu
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    // Xử lý cấp lại mật khẩu mới và gửi mail
    public function sendResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        // Tạo mật khẩu mới ngẫu nhiên
        $newPassword = Str::random(8);
        $user->password = Hash::make($newPassword);
        $user->save();

        // 1. GHI LOG: Thời gian đổi/cấp lại mật khẩu
        Log::info('Password reset / changed', [
            'email' => $user->email,
            'reset_at' => now(),
        ]);

        // 2. GỬI MAIL: Gửi mật khẩu mới về email người dùng
        Mail::raw("Xin chào {$user->name}, mật khẩu mới của bạn là: {$newPassword}", function ($message) use ($user) {
            $message->to($user->email)->subject('Cấp lại mật khẩu mới - Blog');
        });

        return back()->with('success', 'Mật khẩu mới đã được gửi về email của bạn!');
    }

    // Xử lý đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Đã đăng xuất thành công!');
    }
}