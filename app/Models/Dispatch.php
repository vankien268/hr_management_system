<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dispatch extends Model
{
    use HasFactory;
    protected $table = 'dispatches';
    protected $fillable = [
        'code',
        'number',
        'name',
        'type',
        'date',
        'project_id',
        'customer_id',
        'content',
        'sender',
        'receiver',
        'from_date',
        'to_date',
        'note',
        'status_id',
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the status that owns the Dispatch
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(SystemStatus::class, 'status_id');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable','entry_type', 'entry_id');
    }

}
