<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactContract extends BaseModel
{
    protected $table = 'contact_contract';
    protected $fillable = [
        'contract_id',
        'contact_id',
        'note',
        'status',
    ];

    /**
     * Get the contract that owns the ContactContract
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }
    /**
     * Get the contact that owns the ContactContract
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}
