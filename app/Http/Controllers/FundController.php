<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign; // Đã đổi từ Fund sang Campaign

class FundController extends Controller
{
    // Trang user
    public function index() {
        // Lấy tất cả chiến dịch đang chạy (status = 1)
        $campaigns = Campaign::where('status', 1)->get(); 
        return view('welcome', compact('campaigns'));
    }

    // Trang admin + dữ liệu chart
    public function admin() {
        // Lấy danh sách quỹ mới nhất xếp lên đầu
        $campaigns = Campaign::orderBy('created_at', 'desc')->get();

        // dữ liệu cho biểu đồ (Đã cập nhật tên cột mới)
        $labels = $campaigns->pluck('title'); 
        $data = $campaigns->pluck('goal_eth'); 

        // Truyền biến sang view (nhớ kiểm tra lại tên view của bạn là admin.dashboard hay admin.manage_funds nhé)
        return view('admin.dashboard', compact('campaigns', 'labels', 'data'));
    }

    // Trang chi tiết dự án
    public function detail($id) {
        // Tìm chiến dịch theo ID, nếu không thấy sẽ báo lỗi 404
        $campaign = Campaign::findOrFail($id); 
        
        // Truyền dữ liệu sang file detail.blade.php
        return view('detail', compact('campaign'));
    }

    // Thêm quỹ mới (Xử lý form ở Ảnh 1)
    public function store(Request $request) {

        // 1. Validate dữ liệu nhập vào
        $request->validate([
            'title' => 'required|string|max:255',
            'goal_eth' => 'required|numeric|min:0.01',
            'category' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Kiểm tra file ảnh
        ], [
            'title.required' => 'Vui lòng nhập tên quỹ',
            'goal_eth.required' => 'Vui lòng nhập mục tiêu ETH',
            'category.required' => 'Vui lòng chọn danh mục',
            'description.required' => 'Vui lòng nhập mô tả chi tiết'
        ]);

        // 2. Xử lý Upload Ảnh (Nếu người dùng có chọn ảnh)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            // Lưu ảnh vào thư mục public/uploads/campaigns
            $file->move(public_path('uploads/campaigns'), $fileName);
            $imagePath = 'uploads/campaigns/' . $fileName;
        }

        // 3. Lưu vào Database
        Campaign::create([
            'title' => $request->title,
            'goal_eth' => $request->goal_eth,
            'category' => $request->category,
            'description' => $request->description,
            'image_url' => $imagePath,       // Đường dẫn ảnh vừa upload
            'start_date' => now(),           // Mặc định ngày bắt đầu là lúc tạo
            'end_date' => now()->addMonths(3),// Mặc định chạy trong 3 tháng
            'status' => 1                    // 1: Đang hoạt động
        ]);

        // 4. Quay lại trang trước và báo thành công
        return redirect()->back()->with('success', 'Tạo chiến dịch thành công!');
    }

    // Xử lý Xóa chiến dịch
    public function delete($id) {
        // Tìm chiến dịch trong Database dựa vào ID
        $campaign = Campaign::find($id);
        
        if ($campaign) {
            // BƯỚC THÊM: Nếu quỹ này có ảnh bìa, ta xóa luôn file ảnh trong thư mục cho nhẹ ổ cứng
            if ($campaign->image_url && file_exists(public_path($campaign->image_url))) {
                unlink(public_path($campaign->image_url));
            }
            
            // Xóa dòng dữ liệu trong Database
            $campaign->delete();
            
            // Quay lại trang quản lý và báo thành công
            return redirect()->back()->with('success', 'Đã xóa chiến dịch thành công!');
        }

        // Nếu không tìm thấy (ví dụ ai đó gõ bậy ID trên thanh địa chỉ)
        return redirect()->back()->with('error', 'Không tìm thấy chiến dịch này!');
    }

    // Xử lý Cập nhật chiến dịch
    public function update(Request $request) {
        // Tìm chiến dịch dựa vào ID ẩn gửi từ form
        $campaign = Campaign::find($request->id);
        
        if ($campaign) {
            // Cập nhật các trường dữ liệu
            $campaign->title = $request->title;
            $campaign->goal_eth = $request->goal_eth;
            $campaign->category = $request->category;
            $campaign->status = $request->status;
            $campaign->description = $request->description;
            
            // Xử lý nếu người dùng có up ảnh mới
            if ($request->hasFile('image')) {
                // Xóa ảnh cũ (nếu có)
                if ($campaign->image_url && file_exists(public_path($campaign->image_url))) {
                    unlink(public_path($campaign->image_url));
                }
                // Lưu ảnh mới
                $file = $request->file('image');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/campaigns'), $fileName);
                $campaign->image_url = 'uploads/campaigns/' . $fileName;
            }
            
            // Lưu vào MySQL
            $campaign->save();
            
            return redirect()->back()->with('success', 'Cập nhật chiến dịch thành công!');
        }

        return redirect()->back()->with('error', 'Không tìm thấy chiến dịch!');
    }
}