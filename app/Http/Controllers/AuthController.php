<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLogin()
    {
        return view('login');
    }

    // Xử lý khi bấm nút Đăng nhập
    public function processLogin(Request $request)
    {
        // 1. Kiểm tra dữ liệu nhập vào
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Vui lòng nhập Email',
            'password.required' => 'Vui lòng nhập Mật khẩu'
        ]);

        // 2. Tìm trong bảng ADMINS trước
        $admin = DB::table('admins')->where('email', $request->email)->first();
        if ($admin && Hash::check($request->password, $admin->password)) {
            // Lưu phiên làm việc (Session) cho Admin
            session(['logged_in' => true, 'role' => 'admin', 'email' => $admin->email, 'name' => $admin->full_name]);
            return redirect('/admin'); // Chuyển hướng vào trang admin
        }

        // 3. Nếu không phải Admin, tìm tiếp trong bảng USERS
        $user = DB::table('users')->where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            // Lưu phiên làm việc (Session) cho User
            session(['logged_in' => true, 'role' => 'user', 'email' => $user->email, 'wallet' => $user->wallet_address]);
            return redirect('/'); // Chuyển hướng ra trang chủ người dùng
        }

        // 4. Nếu sai hết thì báo lỗi và quay lại trang đăng nhập
        return back()->with('error', 'Email hoặc mật khẩu không chính xác!');
    }

    // Xử lý Đăng xuất
    public function logout()
    {
        session()->flush(); // Xóa sạch thông tin đăng nhập
        return redirect('/login');
    }
}