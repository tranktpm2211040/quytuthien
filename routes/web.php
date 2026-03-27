<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FundController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\DonationController;


// --- CÁC ROUTE ĐĂNG NHẬP / ĐĂNG XUẤT ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
// ---------------------------------------

// --- ĐÃ SỬA DÒNG NÀY ---
Route::get('/', [FundController::class, 'index'])->name('home');


Route::post('/save-donation', [FundController::class, 'saveDonation'])->name('donation.save');

// Đường dẫn trang chi tiết (có nhận ID của quỹ)
Route::get('/detail/{id}', [FundController::class, 'detail'])->name('fund.detail');

// Route admin
Route::prefix('admin')->name('admin.')->group(function () {

    // Trang chủ Admin (Đường dẫn: /admin)
    Route::get('/', [FundController::class, 'admin'])->name('dashboard');

    // Lưu dự án mới (Đường dẫn: /admin/fund/store)
    Route::post('/fund/store', [FundController::class, 'store'])->name('fund.store');

    // Xóa dự án (Đường dẫn: /admin/fund/delete/{id})
    Route::get('/fund/delete/{id}', [FundController::class, 'delete'])->name('fund.delete');
    
    // --- ĐÃ SỬA DÒNG NÀY: Xóa chữ admin/ và admin. ---
    // Cập nhật dự án (Đường dẫn: /admin/fund/update)
    Route::post('/fund/update', [FundController::class, 'update'])->name('fund.update');
    // ---------------------------------------------------

    Route::post('/donations/save', [DonationController::class, 'saveDonation']);
});
