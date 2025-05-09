<?php

namespace App\Transformers;

use App\Models\HrmContact;
use League\Fractal\TransformerAbstract;

class HrmContactTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(HrmContact $entry)
    {
        return [
            'id' => $entry->id,
            'contact_code' => $entry->contact_code,
            'full_name' => $entry->full_name,
            'contact_gender' => $entry->contact_gender,
            'contact_birthday' => $entry->contact_birthday,
            'contact_email' => $entry->contact_email,
            'contact_facebook' => $entry->contact_facebook,
            'contact_zalo' => $entry->contact_zalo,
            'contact_mobile' => $entry->contact_mobile,
            'contact_mobile_2' => $entry->contact_mobile_2,
            'contact_identify' => $entry->contact_identify,
            'contact_identify_day' => $entry->contact_identify_day,
            'contact_identify_place' => $entry->contact_identify_place,
            'contact_marital_status' => $entry->contact_marital_status,
//            'contact_people_type' => $entry->contact_people_type,
//            'contact_religious_type' => $entry->contact_religious_type,
            'contact_national' => $entry->contact_national,
            'contact_status_id' => $entry->contact_status_id,
            'user_id' => $entry->user_id,
            'department_id' => $entry->department_id,
            'department_name' => $entry->department->name ?? '',
            'contact_tax_code' => $entry->contact_tax_code,
            'contact_tax_code_date' => $entry->contact_tax_code_date,
            'atm_number' => $entry->atm_number,
            'bank_id' => $entry->bank_id,
            'bank_branch_id' => $entry->bank_branch_id,
            'permanent_address' => $entry->permanent_address,
            'temporary_address' => $entry->temporary_address,
            'contact_home_town' => $entry->contact_home_town,
            'relative_phone_number' => $entry->relative_phone_number,
        ];
    }

}
