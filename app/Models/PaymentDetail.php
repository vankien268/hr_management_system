<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PaymentDetail extends BaseModel
{
    use LogsActivity;
    protected $table = 'payment_details';
    protected $fillable = [
        'contract_id',
        'payment_times',
        'amount',
        'actual_amount',
        'expected_payment_date',
        'payment_date',
        'note'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }

    /**
     * Get the contract that owns the PaymentDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class,'contract_id');
    }
}
