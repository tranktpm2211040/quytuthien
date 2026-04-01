<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign; 

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

        // dữ liệu cho biểu đồ 
        $labels = $campaigns->pluck('title'); 
        $data = $campaigns->pluck('goal_eth'); 

        return view('admin.dashboard', compact('campaigns', 'labels', 'data'));
    }

    // Trang chi tiết dự án
    public function detail($id) {
        // Tìm chiến dịch theo ID, nếu không thấy sẽ báo lỗi 404
        $campaign = Campaign::findOrFail($id); 
        
        // Truyền dữ liệu sang file detail.blade.php
        return view('detail', compact('campaign'));
    }

    // Thêm quỹ mới 
    public function store(Request $request) {

        // 1. Validate dữ liệu nhập vào (ĐÃ THÊM receiver_wallet)
        $request->validate([
            'title' => 'required|string|max:255',
            'goal_eth' => 'required|numeric|min:0.01',
            'receiver_wallet' => 'required|string|max:42', // Bắt buộc nhập địa chỉ ví
            'category' => 'required|string',
            'end_date' => 'required|date',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' 
        ], [
            'title.required' => 'Vui lòng nhập tên quỹ',
            'goal_eth.required' => 'Vui lòng nhập mục tiêu ETH',
            'receiver_wallet.required' => 'Vui lòng nhập địa chỉ ví người thụ hưởng',
            'category.required' => 'Vui lòng chọn danh mục',
            'end_date.required' => 'Vui lòng chọn ngày kết thúc',
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

        // 3. Lưu vào Database (ĐÃ THÊM receiver_wallet)
        Campaign::create([
            'title' => $request->title,
            'goal_eth' => $request->goal_eth,
            'receiver_wallet' => $request->receiver_wallet, // Lấy dữ liệu ví từ form
            'category' => $request->category,
            'description' => $request->description,
            'image_url' => $imagePath,       
            'start_date' => now(),           
            'end_date' => $request->end_date,
            'status' => 1                    
        ]);

        // 4. Quay lại trang trước và báo thành công
        return redirect()->back()->with('success', 'Tạo chiến dịch thành công!');
    }

    // Xử lý Xóa chiến dịch
    public function delete($id) {
        $campaign = Campaign::find($id);
        
        if ($campaign) {
            // Nếu quỹ này có ảnh bìa, xóa file ảnh trong thư mục cho nhẹ ổ cứng
            if ($campaign->image_url && file_exists(public_path($campaign->image_url))) {
                unlink(public_path($campaign->image_url));
            }
            
            $campaign->delete();
            return redirect()->back()->with('success', 'Đã xóa chiến dịch thành công!');
        }

        return redirect()->back()->with('error', 'Không tìm thấy chiến dịch này!');
    }

    // Xử lý Cập nhật chiến dịch
    public function update(Request $request) {
        // Tìm chiến dịch dựa vào ID ẩn gửi từ form
        $campaign = Campaign::find($request->id);
        
        if ($campaign) {
            // Cập nhật các trường dữ liệu (ĐÃ THÊM receiver_wallet)
            $campaign->title = $request->title;
            $campaign->goal_eth = $request->goal_eth;
            $campaign->receiver_wallet = $request->receiver_wallet; // Nhận ví mới khi sửa
            $campaign->category = $request->category;
            $campaign->status = $request->status;
            $campaign->description = $request->description;
            $campaign->end_date = $request->end_date;
            
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

    // Trang chi tiết dự án (dành cho Admin)
    public function showDetail($id) {
        $campaign = Campaign::findOrFail($id);
        
        // Trả về file detail_fund.blade.php nằm trong thư mục resources/views/admin/
        return view('admin.detail_fund', compact('campaign'));
    }
}