<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeploymentSchedule extends BaseModel
{
    protected $fillable = [
        'code',
        'title',
        'contract_type_id',
        'project_id',
        'from_date',
        'to_date',
        'note',
        'status_id',
        'project_content'
    ];

    public function deploymentScheduleDetails()
    {
        return $this->hasMany(DeploymentScheduleDetail::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_implementers');
    }

    public function scopeStatus($query)
    {
        return $query->whereStatus(StatusEnum::USING);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function contractType()
    {
        return $this->belongsTo(ContractType::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(SystemStatus::class, 'status_id');
    }
}
