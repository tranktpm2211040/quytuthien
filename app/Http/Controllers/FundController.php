<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fund;

class FundController extends Controller
{
    // Trang user
    public function index() {
        $funds = Fund::all();
        return view('user.home', compact('funds'));
    }

    // Trang admin + dữ liệu chart
    public function admin() {
        $funds = Fund::all();

        // dữ liệu cho biểu đồ
        $labels = $funds->pluck('name');
        $data = $funds->pluck('goal_amount');

        return view('admin.dashboard', compact('funds', 'labels', 'data'));
    }

    // Thêm quỹ
    public function store(Request $request) {

        // validate (tránh lỗi + ăn điểm)
        $request->validate([
            'name' => 'required',
            'goal_amount' => 'required|numeric|min:1'
        ]);

        Fund::create([
            'name' => $request->name,
            'goal_amount' => $request->goal_amount
        ]);

        return redirect('/admin')->with('success', 'Tạo quỹ thành công!');
    }
}
