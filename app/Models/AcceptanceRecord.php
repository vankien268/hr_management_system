<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcceptanceRecord extends Model
{
    use HasFactory;
    protected $table = 'acceptance_records';
    protected $fillable = [
        'code',
        'title',
        'project_id',
        'sent_date',
        'acceptance_date',
        'sender',
        'receiver',
        'warranty_period',
        'note',
        'status_id',
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
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
