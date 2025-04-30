<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class BaseModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;
    public function getTextStatus()
    {
        if($this->status){
            return trans('Đang sử dụng');
        }
        return trans('Ngừng sử dụng');
    }
}
