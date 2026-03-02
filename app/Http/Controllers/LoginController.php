<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // 1. HÀM NÀY ĐANG THIẾU - PHẢI CÓ ĐỂ HIỆN TRANG ĐĂNG NHẬP
    public function showLoginForm()
    {
        return view('login');
    }

    // 2. Hàm xử lý đăng nhập khi ấn nút
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            \App\Services\TelegramService::sendMessage(" <b>SHIELD-AI: CẢNH BÁO</b>\nLeader Thịnh vừa đăng nhập thành công!");
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Tài khoản hoặc mật khẩu không chính xác.',
        ]);
    }

    // 3. Hàm đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}