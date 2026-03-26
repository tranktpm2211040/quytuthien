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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/save-donation', [FundController::class, 'saveDonation'])->name('donation.save');

// Route test tĩnh
Route::get('/detail', function () {
    return view('detail');
});

//admin
Route::prefix('admin')->name('admin.')->group(function () {

    // Trang chủ Admin (Đường dẫn: /admin)
    Route::get('/', [FundController::class, 'admin'])->name('dashboard');

    // Lưu dự án mới (Đường dẫn: /admin/fund/store)
    Route::post('/fund/store', [FundController::class, 'store'])->name('fund.store');

    // Xóa dự án (Đường dẫn: /admin/fund/delete/{id})
    Route::get('/fund/delete/{id}', [FundController::class, 'delete'])->name('fund.delete');



    Route::post('/donations/save', [DonationController::class, 'saveDonation']);
});
