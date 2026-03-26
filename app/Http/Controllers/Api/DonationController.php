<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Campaign;
use App\Models\Transaction;
use Exception;

class DonationController extends Controller
{
    public function saveDonation(Request $request)
    {
        // 1. Validate dữ liệu gửi lên
        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'wallet_address' => 'required|string',
            'amount' => 'required|numeric|min:0.0001',
            'tx_hash' => 'required|string|unique:transactions,tx_hash',
        ]);

        // Dùng DB Transaction để đảm bảo tính toàn vẹn dữ liệu
        DB::beginTransaction();
        try {
            // 2. Lưu vào bảng Lịch sử (transactions)
            Transaction::create([
                'campaign_id' => $validated['campaign_id'],
                'wallet_address' => $validated['wallet_address'],
                'amount' => $validated['amount'],
                'tx_hash' => $validated['tx_hash'],
                'status' => 'success'
            ]);

            // 3. Cập nhật tổng số tiền đã nhận của Quỹ (campaigns)
            $campaign = Campaign::findOrFail($validated['campaign_id']);
            $campaign->raised_amount += $validated['amount'];
            
            // Cập nhật trạng thái nếu đã đạt mục tiêu
            if ($campaign->raised_amount >= $campaign->target_amount) {
                $campaign->status = 'completed';
            }
            $campaign->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Đã lưu lịch sử quyên góp thành công!'
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage()
            ], 500);
        }
    }
}