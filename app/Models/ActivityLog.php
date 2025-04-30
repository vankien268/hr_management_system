<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;

class ActivityLog extends Model
{
    use HasFactory;
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
    protected $table = 'activity_log';
    protected $casts = [
        'properties' => 'json',
    ];

    /**
     * Get the status that owns the ActivityLog
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'causer_id');
    }



    /**
     * Get the status that owns the ActivityLog
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'subject_id');
    }

    public function scopeForSubjects($query, Model $subject)
    {
        return $query
            ->where('subject_type', $subject->getMorphClass());
    }

    public function scopeForCausers($query, Model $subject)
    {
        return $query
            ->where('causer_type', $subject->getMorphClass());
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class, 'subject_id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'subject_id');
    }

    #payment_details_history
    public function paymentDetail(): BelongsTo
    {
        return $this->belongsTo(PaymentDetail::class, 'subject_id');
    }
    #annex_contracts
    public function annexContract(): BelongsTo
    {
        return $this->belongsTo(AnnexContract::class, 'subject_id');
    }
    #contract_modules
    public function contractModule(): BelongsTo
    {
        return $this->belongsTo(ContractModule::class, 'subject_id');
    }

    #city
    public function jsonNewCity()
    {
        return $this->belongsToJson(City::class, 'properties->attributes->city_id');
    }

    public function jsonOldCity()
    {
        return $this->belongsToJson(City::class, 'properties->old->city_id');
    }
    #District
    public function jsonNewDistrict()
    {
        return $this->belongsToJson(District::class, 'properties->attributes->district_id');
    }

    public function jsonOldDistrict()
    {
        return $this->belongsToJson(District::class, 'properties->old->district_id');
    }
    #Ward
    public function jsonNewWard()
    {
        return $this->belongsToJson(Ward::class, 'properties->attributes->ward_id');
    }

    public function jsonOldWard()
    {
        return $this->belongsToJson(Ward::class, 'properties->old->ward_id');
    }
    #Bank
    public function jsonNewBank()
    {
        return $this->belongsToJson(Bank::class, 'properties->attributes->bank_id');
    }

    public function jsonOldBank()
    {
        return $this->belongsToJson(Bank::class, 'properties->old->bank_id');
    }
    #Trạng thái
    public function jsonNewSystemStatus()
    {
        return $this->belongsToJson(SystemStatus::class, 'properties->attributes->status_id');
    }

    public function jsonOldSystemStatus()
    {
        return $this->belongsToJson(SystemStatus::class, 'properties->old->status_id');
    }
    # Khách hàng
    public function jsonNewCustomer()
    {
        return $this->belongsToJson(Customer::class, 'properties->attributes->customer_id');
    }

    public function jsonOldCustomer()
    {
        return $this->belongsToJson(Customer::class, 'properties->old->customer_id');
    }
    # Người dùng
    public function jsonNewUser()
    {
        return $this->belongsToJson(User::class, 'properties->attributes->user_id');
    }

    public function jsonOldUser()
    {
        return $this->belongsToJson(User::class, 'properties->old->user_id');
    }

    #Loại dự án
    public function jsonNewProjectType()
    {
        return $this->belongsToJson(ProjectType::class, 'properties->attributes->project_type_id');
    }

    public function jsonOldProjectType()
    {
        return $this->belongsToJson(ProjectType::class, 'properties->old->project_type_id');
    }

    # Người dùng trong ls dự án
    public function jsonNewUserWithHistoryProject()
    {
        return $this->belongsToJson(User::class, 'properties->attributes->user->user_id');
    }

    public function jsonOldUserWithHistoryProject()
    {
        return $this->belongsToJson(User::class, 'properties->old->user->user_id');
    }

    # Hợp đồng thuộc dự án
    public function jsonNewProject()
    {
        return $this->belongsToJson(Project::class, 'properties->attributes->project_id');
    }

    public function jsonOldProject()
    {
        return $this->belongsToJson(Project::class, 'properties->old->project_id');
    }

    # Đại diện ký(Phía công ty)
    public function jsonNewUserContractor()
    {
        return $this->belongsToJson(User::class, 'properties->attributes->user_contractor_id');
    }

    public function jsonOldUserContractor()
    {
        return $this->belongsToJson(User::class, 'properties->old->user_contractor_id');
    }

    # Người phụ trách
    public function jsonNewUserCharge()
    {
        return $this->belongsToJson(User::class, 'properties->attributes->user_charge_id');
    }

    public function jsonOldUserCharge()
    {
        return $this->belongsToJson(User::class, 'properties->old->user_charge_id');
    }

    # Người phụ trách khách hàng
    public function jsonNewUserChargeCustomer()
    {
        return $this->belongsToJson(User::class, 'properties->attributes->user_id');
    }

    public function jsonOldUserChargeCustomer()
    {
        return $this->belongsToJson(User::class, 'properties->old->user_id');
    }

     # Loại hợp đồng
     public function jsonNewContractType()
     {
         return $this->belongsToJson(ContractType::class, 'properties->attributes->contract_type_id');
     }

     public function jsonOldContractType()
     {
         return $this->belongsToJson(ContractType::class, 'properties->old->contract_type_id');
     }

     # Loại hợp đồng annex
     public function jsonNewContract()
     {
         return $this->belongsToJson(Contract::class, 'properties->attributes->contract_id');
     }

     public function jsonOldContract()
     {
         return $this->belongsToJson(Contract::class, 'properties->old->contract_id');
     }

     # Nhóm chức năng
     public function jsonNewModule()
     {
         return $this->belongsToJson(Module::class, 'properties->attributes->module_id');
     }

     public function jsonOldModule()
     {
         return $this->belongsToJson(Module::class, 'properties->old->module_id');
     }
}
