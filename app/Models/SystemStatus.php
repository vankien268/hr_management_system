<?php

namespace App\Models;

use App\Traits\SystemStatusTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SystemStatus extends BaseModel
{
    use SystemStatusTrait;
    protected $table = 'system_statuses';

    protected $casts = [
        'status' => 'bool'
    ];
    protected $fillable = [
        'name',
        'note',
        'type',
        'status'
    ];

    /**
     * Get all of the customers for the SystemStatus
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'status_id');
    }
        /**
     * Get all of the projects for the SystemStatus
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'status_id');
    }
        /**
     * Get all of the contracts for the SystemStatus
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class, 'status_id');
    }
    /**
     * Get all of the tasks for the SystemStatus
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'status_id');
    }
    /**
     * Get all of the acceptanceRecords for the SystemStatus
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function acceptanceRecords(): HasMany
    {
        return $this->hasMany(AcceptanceRecord::class, 'status_id');
    }
    /**
     * Get all of the deploymentRecords for the SystemStatus
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deploymentRecords(): HasMany
    {
        return $this->hasMany(DeploymentRecord::class, 'status_id');
    }
    /**
     * Get all of the deploymentSchedules for the SystemStatus
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deploymentSchedules(): HasMany
    {
        return $this->hasMany(DeploymentSchedule::class, 'status_id');
    }
    /**
     * Get all of the dispatches for the SystemStatus
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dispatches(): HasMany
    {
        return $this->hasMany(Dispatch::class, 'status_id');
    }
}
