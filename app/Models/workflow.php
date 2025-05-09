<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class workflow extends Model
{
    use HasFactory;
    use Userstamps;

    const WORKFLOW_TYPES = [
    "annual_leave" => "Nghỉ phép năm",
    "regime_leave" => "Nghỉ chế độ",
    "business_travel" => "Đi công tác",
    "working_out_of_the_office" => "Làm việc ngoài văn phòng",
    "unpaid_leave" => "Nghỉ không lương",
    "arriving_late" => "Xin đi muộn",
    "leave_early" => "Xin về sớm",
    "forgot_timekeeping" => "Quên chấm công",
];


    protected $fillable= [
        'workflow_code',
        'workflow_name',
        'active',
        'settings',
        'description',
        'dept_ids',
        'valid',
//        'approval_method',
        'approver_type',
        'approver_ids',
        'workflow_type',
        'department_names',
    ];
}
