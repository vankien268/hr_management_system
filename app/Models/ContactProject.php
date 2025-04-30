<?php

namespace App\Models;
class ContactProject extends BaseModel
{
    protected $table = 'contact_project';
    protected $fillable = [
        'project_id',
        'contact_id',
        'note',
        'status',
        'position'
    ];
}
