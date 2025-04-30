<?php

namespace App\Models;

use App\Enums\StatusEnum;
use App\Enums\StatusTypeEnum;
use App\Traits\ProjectPermission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends BaseModel
{
    use ProjectPermission;
    // LogsActivity
    protected $table = 'projects';
    protected $fillable = [
        'code',
        'name',
        'city_id',
        'project_type_id',
        'customer_id',
        'status_id',
        'description',
        'note'
    ];

    // public function getActivitylogOptions(): LogOptions
    // {
    //     return LogOptions::defaults()
    //     ->logOnly(['*'])
    //     ->logOnlyDirty();
    //     // Chain fluent methods for configuration options
    // }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user')->withPivot(['note']);
    }

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'contact_project')->withPivot(['status', 'note', 'position'])
        ->orderByPivot('status', 'DESC')->orderByPivot('position', 'ASC');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function projectType()
    {
        return $this->belongsTo(ProjectType::class, 'project_type_id');
    }

    public function statusProject()
    {
        return $this->belongsTo(SystemStatus::class, 'status_id')->where('type', StatusTypeEnum::PROJECT);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function deploymentSchedules()
    {
        return $this->hasMany(DeploymentSchedule::class);
    }
    /**
     * Get all of the quotes for the Project
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    public function projectFunctionUsers()
    {
        return $this->belongsToMany(SystemFunction::class, 'project_function_user')
        ->withPivot(['project_id', 'system_function_id', 'user_id']);
    }

    public function functionProjectHasUsers()
    {
        return $this->belongsToMany(User::class, 'project_function_user')
        ->withPivot(['project_id', 'system_function_id', 'user_id']);
    }

    public function functionProjectHasUsersByPermission()
    {
        return $this->belongsToMany(User::class, 'project_function_user')
        ->withPivot(['project_id', 'system_function_id', 'user_id'])->wherePivot('system_function_id', 30);
    }

    public function userPermissionViewPaymentDetailContract()
    {
        return $this->belongsToMany(User::class, 'project_function_user')
        ->withPivot(['project_id', 'system_function_id', 'user_id'])->wherePivot('system_function_id', 34);
    }

    public function projectFunctions()
    {
        return $this->hasMany(ProjectFunctionUser::class, 'project_id');
    }

    public function userCreateProject()
    {
        return $this->belongsTo(Project::class, 'created_by');
    }

    public function scopeWithAndWhereHas($query, $relation, $constraint)
    {
        return $query->whereHas($relation, $constraint)
                    ->with([$relation => $constraint]);
    }

    public function acceptanceRecords()
    {
        return $this->hasMany(AcceptanceRecord::class);
    }

    public function dispatches()
    {
        return $this->hasMany(Dispatch::class);
    }


}
