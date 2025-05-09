<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrmContact extends Model
{
    use HasFactory;
    protected $table = "contacts";

    protected $fillable = [
        'contact_code',
        'full_name',
        'contact_gender',
        'contact_birthday',
        'contact_email',
        'contact_facebook',
        'contact_zalo',
        'contact_mobile',
        'contact_mobile_2',
        'contact_identify',
        'contact_identify_day',
        'contact_identify_place',
        'contact_marital_status',
//        'contact_people_type',
//        'contact_religious_type',
        'contact_national',
        'contact_status_id',
        'contact_tax_code',
        'contact_tax_code_date',
        'atm_number',
        'bank_id',
        'user_id',
        'department_id',
//        'bank_branch_id',
        'permanent_address',
        'temporary_address',
        'contact_home_town',
        'relative_phone_number',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
