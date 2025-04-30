<?php

namespace App\Models;

use App\Enums\CustomerEnum;
use App\Traits\CustomerTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Customer extends BaseModel
{
    use HasFactory, CustomerTrait, LogsActivity;
    protected $table = 'customers';
    protected $fillable = [
        'code',
        'name',
        'tax_code',
        'address',
        'city_id',
        'district_id',
        'ward_id',
        'representative_name',
        'representative_phone',
        'representative_email',
        'status_id',
        'bank_username',
        'bank_number',
        'bank_id',
        'note',
        'customer_type',
        'user_id'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }

    /**
     * Get the status that owns the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(SystemStatus::class, 'status_id');
    }
    /**
     * Get the city that owns the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
    /**
     * Get the district that owns the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }
    /**
     * Get the ward that owns the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class);
    }
    /**
     * Get the bank that owns the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }
    /**
     * Get all of the projects for the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
    /**
     * Get all of the contracts for the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }
    /**
     * Get the bank that owns the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */


    public function scopeWithoutVIPCustomer(Builder $query): void
    {
        $query->where('customer_type', CustomerEnum::CUSTOMER_NORMAL);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
