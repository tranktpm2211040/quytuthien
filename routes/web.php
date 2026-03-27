<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FundController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\DonationController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;



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




    //


   // ROUTE CỦA NGƯỜI DÙNG (TRANG CHỦ, THANH TOÁN) - ĐỂ NGOÀI ADMIN
// =========================================================================

// Route nhận kết quả quyên góp (MetaMask / Form lưu)
Route::post('/donations/save', [DonationController::class, 'saveDonation']);

// Route hiển thị trang thanh toán
Route::get('/thanh-toan', function (Request $request) {
    // Lấy số tiền từ URL, nếu không có thì mặc định là 50000
    $amount = $request->query('amount', 50000); 
    $projectId = $request->query('project_id', 1);

    // Trả về file giao diện thanh-toan.blade.php
    return view('thanh-toan', compact('amount', 'projectId'));
})->name('payment.show');

// Xử lý tạo URL thanh toán MoMo (Giả lập hoặc dùng API thật)
Route::post('/thanh-toan/momo', [PaymentController::class, 'processMoMo'])->name('payment.momo');

// Xử lý khi MoMo thanh toán xong trả kết quả về (Callback)
Route::get('/thanh-toan/momo-return', [PaymentController::class, 'momoReturn'])->name('payment.momo_return');



// =========================================================================
// ROUTE CỦA ADMIN (CHỈ DÀNH CHO QUẢN TRỊ VIÊN)
// =========================================================================
Route::prefix('admin')->name('admin.')->group(function () {

    // Trang chủ Admin (Đường dẫn: /admin)
    Route::get('/', [FundController::class, 'admin'])->name('dashboard');

    // Lưu dự án mới (Đường dẫn: /admin/fund/store)
    Route::post('/fund/store', [FundController::class, 'store'])->name('fund.store');

    // Xóa dự án (Đường dẫn: /admin/fund/delete/{id})
    Route::get('/fund/delete/{id}', [FundController::class, 'delete'])->name('fund.delete');

    // Route hiển thị trang thanh toán
Route::get('/thanh-toan', function (Illuminate\Http\Request $request) {
    // Lấy số tiền từ URL, nếu không có thì mặc định là 50000
    $amount = $request->query('amount', 50000); 
    $projectId = $request->query('project_id', 1);
    
    // Thêm dòng này để định nghĩa tên dự án
    $projectName = "Giữ lại thị lực cho cậu bé Duy Khang"; 

    // QUAN TRỌNG: Nhớ thêm chữ 'projectName' vào bên trong hàm compact()
    return view('thanh-toan', compact('amount', 'projectId', 'projectName'));
})->name('payment.show');

});

});
