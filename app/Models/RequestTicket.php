<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class RequestTicket extends Model
{
    use HasFactory;
    use Userstamps;


    CONST STATUS_NEW = 0;

    CONST STATUS_APPROVED = 1;

    CONST STATUS_REJECT = 2;
    CONST STATUS_CANCEL = 3;
    CONST STATUS_UPDATE = 4;

    const REQUEST_STATUSES = [
        self::STATUS_NEW => "Chờ duyệt",
        self::STATUS_APPROVED => "Đã duyệt",
        self::STATUS_REJECT => "Đã từ chối",
        self::STATUS_CANCEL => "Đã hủy",
    ];

    protected $fillable= [
        'request_title',
        'request_description',
        'start_date',
        'end_date',
        'number_leave_day',
        'approval_type',
        'workflow_id',
        'request_status',
        'valid'
    ];

    public function workflow()
    {
        return $this->belongsTo(workflow::class, 'workflow_id');
    }

}
