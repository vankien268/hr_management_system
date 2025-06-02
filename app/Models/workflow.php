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

    const WORKFLOW_CODE_CONTRACT = 'contract';
    const WORKFLOW_CODE_REQUEST_TICKET = 'request_ticket';

    const TYPE_TEXTAREA     = 'textarea';
    const TYPE_TEXTINPUT    = 'textinput';
    const TYPE_FILE         = 'file';

    CONST APPROVE_TYPE_USER = 'user';
    CONST APPROVE_TYPE_DEPT = 'dept';

    CONST WORKFLOW_TYPE_LEAVE_EARLY = 'leave_early';                    # Xin về sớm
    CONST WORKFLOW_TYPE_ARRIVING_LATE = 'arriving_late';                # Xin đi muộn
    CONST WORKFLOW_TYPE_FORGOT_TIMEKEEPING = 'forgot_timekeeping';      # Quên chấm công
    CONST WORKFLOW_TYPE_UNPAID_LEAVE = 'unpaid_leave';                  # Nghỉ không lương
    CONST WORKFLOW_TYPE_ANNUAL_LEAVE = 'annual_leave';                  # Nghỉ phép năm


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
