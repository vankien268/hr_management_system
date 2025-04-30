<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ContractModule extends BaseModel
{
    use LogsActivity;
    protected $table = 'contract_module';
    protected $fillable = [
        'module_id',
        'contract_id',
        'value',
        'note_module',
        'status'
    ];
    protected $with = ['module'];

    /**
     * Get the module that owns the ContractModule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class,'contract_id');
    }
}
