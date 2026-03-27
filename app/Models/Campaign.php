<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    // Cho phép thêm dữ liệu vào các cột này
    protected $fillable = [
        'contract_address',
        'title',
        'goal_eth',
        'category',
        'description',
        'image_url',
        'start_date',
        'end_date',
        'status',
    ];
}