<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends Model
{
    protected $table = 'modules';
    protected $fillable = [
        'name'
    ];

    /**
     * Get all of the contractModules for the Module
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contractModules(): HasMany
    {
        return $this->hasMany(ContractModule::class);
    }
}
