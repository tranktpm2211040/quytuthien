<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Hàm hiển thị trang checkout
    public function showPayment(Request $request)
    {
        // Lấy số tiền và ID dự án từ URL (vd: /thanh-toan?amount=50000&project_id=1)
        $amount = $request->query('amount', 0);
        $projectId = $request->query('project_id', 1);

        // Trong thực tế, bạn sẽ dùng $projectId để query DB lấy tên dự án
        $projectName = "Giữ lại thị lực cho cậu bé Duy Khang"; 

        return view('thanh-toan', compact('amount', 'projectId', 'projectName'));
    }

    // Hàm xử lý thanh toán MoMo (Mô phỏng)
    public function processMoMo(Request $request)
    {
        $amount = $request->amount;
        $projectId = $request->project_id;

        // THỰC TẾ: Ở đây bạn sẽ gọi API của MoMo (truyền partnerCode, accessKey, secretKey...)
        // để lấy về một cái PayUrl.
        // DEMO ĐỒ ÁN: Tui giả lập việc chuyển hướng về trang thành công luôn.
        
        return redirect()->route('payment.momo_return', [
            'resultCode' => 0, // 0 là thành công của MoMo
            'amount' => $amount,
            'orderId' => 'MOMO' . time()
        ]);
    }

    // Hàm nhận kết quả từ MoMo trả về
    public function momoReturn(Request $request)
    {
        if ($request->resultCode == 0) {
            // Lưu giao dịch vào Database ở đây...
            return "<h1>Thanh toán MoMo thành công! Cảm ơn bạn.</h1><a href='/'>Về trang chủ</a>";
        } else {
            return "<h1>Thanh toán thất bại hoặc bị hủy!</h1><a href='/'>Thử lại</a>";
        }
    }
}