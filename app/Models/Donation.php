<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    // Chỉ định chính xác tên bảng trong Database
    protected $table = 'donations';

    // Cho phép lưu các cột này
    protected $fillable = [
        'campaign_id',
        'campaign_title',
        'amount_vnd',
    ];

    // Mối quan hệ: 1 Lượt quyên góp thuộc về 1 Chiến dịch (Campaign)
    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id', 'id');
    }
}