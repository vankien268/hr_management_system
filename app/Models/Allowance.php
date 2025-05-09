<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    use HasFactory;

    public const FIXED_TYPE = 1;       # Loại cố định
    public const WORKED_DAYS_TYPE = 2; # Loại tỉ lệ theo ngày công
    public const MANUAL_TYPE = 3;      # Loại nhập tay

    const ALLOWANCE_HAVE_LAUNCH_DEFAULT = 1;  # Phụ cấp ăn trưa
    const ALLOWANCE_GAS_DEFAULT = 2;  # Phụ cấp xăng xe
    const ALLOWANCE_CHILD_CARE_DEFAULT = 3;  # Phụ cấp nuôi con nhỏ

    const ALLOWANCE_ATTENDANCE_DEFAULT = 4;  # Phụ cấp chuyên cần


    protected $fillable= [
        'allowance_name',
        'allowance_type',
        'allowed_number_days',
        'allowance_amount',
        'description',
        'status'
    ];
}
