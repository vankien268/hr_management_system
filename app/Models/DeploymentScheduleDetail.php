<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeploymentScheduleDetail extends BaseModel
{
    protected $table="deployment_schedule_details";
    protected $fillable = [
        'deployment_schedule_id',
        'day',
        'shift',
        'product_function',
        'description'
    ];

    public function deploymentSchedule()
    {
        return $this->belongsTo(DeploymentSchedule::class);
    }
}
