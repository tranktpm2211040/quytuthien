<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FundController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\DonationController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;

// =========================================================================
// 1. CÁC ROUTE ĐĂNG NHẬP / ĐĂNG XUẤT / CÁ NHÂN
// =========================================================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/profile', [AuthController::class, 'profile'])->name('profile');


// =========================================================================
// 2. ROUTE NGƯỜI DÙNG CHUNG (TRANG CHỦ, CHI TIẾT)
// =========================================================================
Route::get('/', [FundController::class, 'index'])->name('home');
Route::get('/detail/{id}', [FundController::class, 'detail'])->name('fund.detail');

// Route lưu quyên góp form cũ
Route::post('/save-donation', [FundController::class, 'saveDonation'])->name('donation.save');

// Route lưu quyên góp từ MetaMask (API gọi ngầm bằng Javascript)
Route::post('/api/chot-don-eth', [DonationController::class, 'saveDonation'])->name('donation.save.eth');

// Route để mở trang ví MetaMask
Route::get('/wallet', function () {
    return view('wallet'); // Laravel sẽ tự động tìm file resources/views/wallet.blade.php
})->name('wallet.show');

// =========================================================================
// 3. ROUTE THANH TOÁN (Cổng Checkout) - Phải để ngoài Admin
// =========================================================================
Route::get('/thanh-toan', function (Request $request) {
    // Lấy thông tin từ URL
    $amount = $request->query('amount', 50000); 
    $projectId = $request->query('project_id', 1);
    $projectName = "Giữ lại thị lực cho cậu bé Duy Khang"; 

    // Trả về file giao diện thanh-toan.blade.php
    return view('thanh-toan', compact('amount', 'projectId', 'projectName'));
})->name('payment.show');

// Xử lý tạo URL thanh toán MoMo
Route::post('/thanh-toan/momo', [PaymentController::class, 'processMoMo'])->name('payment.momo');

// Xử lý khi MoMo thanh toán xong trả kết quả về
Route::get('/thanh-toan/momo-return', [PaymentController::class, 'momoReturn'])->name('payment.momo_return');


// =========================================================================
// 4. ROUTE CỦA ADMIN (CHỈ DÀNH CHO QUẢN TRỊ VIÊN)
// =========================================================================
Route::prefix('admin')->name('admin.')->group(function () {

    // Trang chủ Admin (Đường dẫn: /admin)
    Route::get('/', [FundController::class, 'admin'])->name('dashboard');

    // Lưu dự án mới (Đường dẫn: /admin/fund/store)
    Route::post('/fund/store', [FundController::class, 'store'])->name('fund.store');

    // Cập nhật dự án (Đường dẫn: /admin/fund/update)
    Route::post('/fund/update', [FundController::class, 'update'])->name('fund.update');

    // Xóa dự án (Đường dẫn: /admin/fund/delete/{id})
    Route::get('/fund/delete/{id}', [FundController::class, 'delete'])->name('fund.delete');

    // Xem chi tiết dự án bên Admin (Đường dẫn: /admin/fund/detail/{id})
    Route::get('/fund/detail/{id}', [FundController::class, 'showDetail'])->name('fund.detail');
});