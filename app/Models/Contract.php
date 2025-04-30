<?php

namespace App\Models;

use App\Traits\ProjectPermission;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Contract extends BaseModel
{
    use ProjectPermission, LogsActivity;
    protected $table = 'contracts';
    protected $fillable = [
        'code',
        'signing_date',
        'project_id',
        'customer_id',
        'user_contractor_id',
        'user_charge_id',
        'customer_contractor',
        // 'customer_contractor_id',
        'contract_type_id',
        'contract_value',
        'start_date',
        'expiration_date',
        'hand_over_date',
        'number_payment',
        'warranty_time',
        'status_id',
        'note_contract',
        'updated_by'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }

    /**
     * Get the project that owns the Contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    /**
     * Get the customer that owns the Contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    /**
     * Get the contractType that owns the Contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contractType(): BelongsTo
    {
        return $this->belongsTo(ContractType::class);
    }
    /**
     * Get the status that owns the Contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(SystemStatus::class, 'status_id');
    }

    /**
     * Get the userContractor that owns the Contract
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userContractor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_contractor_id');
    }

    /**
     * Get the userCharge that owns the Contract
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCharge(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_charge_id');
    }

    /**
     * Get the customerContractor that owns the Contract
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    // public function customerContractor(): BelongsTo
    // {
    //     return $this->belongsTo(Contact::class, 'customer_contractor_id');
    // }

    /**
     * Get all of the contractModules for the Contract
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contractModules(): HasMany
    {
        return $this->hasMany(ContractModule::class);
    }

    /**
     * Get all of the annexContracts for the Contract
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function annexContracts(): HasMany
    {
        return $this->hasMany(AnnexContract::class);
    }

    /**
     * Get all of the paymentDetails for the Contract
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paymentDetails(): HasMany
    {
        return $this->hasMany(PaymentDetail::class);
    }

    /**
     * Get all of the contactContracts for the Contract
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // public function contactContracts(): HasMany
    // {
    //     return $this->hasMany(ContactContract::class);
    // }

        /**
     * Get all of the userContracts for the Contract
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // public function contractUsers(): HasMany
    // {
    //     return $this->hasMany(ContractUser::class);
    // }

    public function userCreate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
