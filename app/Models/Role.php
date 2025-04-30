<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends BaseModel
{
    protected $table = 'roles';
    protected $fillable = [
        'name',
        'status',
    ];

    /**
     * Get all of the roleSystemFunctions for the Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roleSystemFunctions(): HasMany
    {
        return $this->hasMany(RoleSystemFunction::class);
    }

    /**
     * Get all of the roleUsers for the Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roleUsers(): HasMany
    {
        return $this->hasMany(RoleUser::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_users');
    }
}
