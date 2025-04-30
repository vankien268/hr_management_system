<?php

namespace App\Models;

use App\Enums\StatusEnum;
use App\Traits\ProjectPermission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends BaseModel
{
    use ProjectPermission;
    protected $table = 'contacts';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'position',
        'note',
        'customer_id'
    ];

    /**
     * Get the customer that owns the Contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'contact_project')->withPivot(['status', 'note', 'position']);
    }

    public function contactsInActive()
    {
        return $this->projects()->wherePivot('status', StatusEnum::USING);
    }
}
