<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FundController;
use App\Http\Controllers\AuthController;

// --- CÁC ROUTE ĐĂNG NHẬP / ĐĂNG XUẤT ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
// ---------------------------------------

Route::get('/', function () {
    return view('welcome');
});

Route::post('/save-donation', [FundController::class, 'saveDonation'])->name('donation.save');

Route::prefix('admin')->name('admin.')->group(function () {
    
    // Trang chủ Admin (Đường dẫn: /admin)
    Route::get('/', [FundController::class, 'admin'])->name('dashboard');
    
    // Lưu dự án mới (Đường dẫn: /admin/fund/store)
    Route::post('/fund/store', [FundController::class, 'store'])->name('fund.store');
    
    // Xóa dự án (Đường dẫn: /admin/fund/delete/{id})
    Route::get('/fund/delete/{id}', [FundController::class, 'delete'])->name('fund.delete');
    
});
