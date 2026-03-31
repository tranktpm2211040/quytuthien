<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class DonationController extends Controller
{
    public function saveDonation(Request $request)
    {
        try {
            // Tìm tên chiến dịch
            $campaign = DB::table('campaigns')->where('id', $request->campaign_id)->first();
            $title = $campaign ? $campaign->title : 'Không xác định';

            // Lưu thẳng vào Database
            DB::table('donations')->insert([
                'campaign_id'    => $request->campaign_id,
                'campaign_title' => $title,
                'amount_vnd'     => $request->amount_vnd,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            return response()->json([
                'success' => true, 
                'message' => 'Lưu dữ liệu thành công!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => $e->getMessage()
            ], 500);
        }
    }
}