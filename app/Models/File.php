<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'path',
        'entry_id',
        'entry_type'
    ];
    // public function fileable()
    // {
    //     return $this->morphTo();
    // }

    public function fileable()
    {
        return $this->morphTo(null, 'entry_type', 'entry_id');
    }
}
