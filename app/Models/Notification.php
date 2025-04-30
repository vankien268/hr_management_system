<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $casts = [
        'id' => 'string'
    ];
    protected $fillable = [
        'id',
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at'
    ];

    protected $table="notifications";

    public function scopeNotifiableType($query, $model, $modelId)
    {
        return $query->where('notifiable_type', $model)->where('notifiable_id', $modelId);
    }

    public function scopeSearchDateInCreatedAt($query, $fromDateExpiration, $toDateExpiration)
    {
       return $query->whereBetween('created_at', [$fromDateExpiration, $toDateExpiration]);
    }

    public function scopeSearchReadAt($query, $isReadAt)
    {
        // Đã đọc true
        if($isReadAt == "true") {
            return $query->whereNotNull('read_at');
        }
        // Chưa đọc false
        return $query->whereNull('read_at');
    }

    // public function scopeSearchProject($query, $projectId)
    // {
    //     return $query->whereJsonContains('data->project->id', $projectId);
    // }

}
