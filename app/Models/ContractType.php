<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractType extends BaseModel
{
    protected $table = 'contract_types';
    protected $casts = [
        'status' => 'bool'
    ];
    protected $fillable = [
        'code',
        'name',
        'note',
        'status'
    ];

    /**
     * Get all of the contracts for the ContractType
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    public function scopeStatus($query)
    {
        return $query->whereStatus(StatusEnum::USING);
    }

    public function deploymentSchedules()
    {
        return $this->hasMany(DeploymentSchedule::class);
    }
}
