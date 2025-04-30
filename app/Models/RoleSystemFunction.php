<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoleSystemFunction extends BaseModel
{
    protected $table = 'role_system_functions';
    protected $fillable = [
        'system_function_id',
        'role_id',
    ];
    /**
     * Get the systemFunction that owns the RoleSystemFunction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function systemFunction(): BelongsTo
    {
        return $this->belongsTo(SystemFunction::class);
    }
    /**
     * Get the role that owns the RoleSystemFunction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
