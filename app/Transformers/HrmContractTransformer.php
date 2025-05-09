<?php

namespace App\Transformers;

use App\Models\HrmContract;
use League\Fractal\TransformerAbstract;

class HrmContractTransformer extends TransformerAbstract
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
    public function transform(HrmContract $entry)
    {
        return [
            'id' => $entry->id,
            'contract_code' => $entry->contract_code,
            'contract_name' => $entry->contract_name,
            'contract_number' => $entry->contract_number,
            'contact_type_id' => $entry->contact_type_id,
            'department_id' => $entry->department_id,
            'contact_id' => $entry->contact_id,
            'signer_user_id' => $entry->signer_user_id,
            'signer_department_id' => $entry->signer_department_id,
            'register_date' => $entry->register_date,
            'time_limited' => $entry->time_limited,
            'work_type' => $entry->work_type,
            'basic_salary' => $entry->basic_salary,
            'effective_date' => $entry->effective_date,
            'expiration_date' => $entry->expiration_date,
            'allowances' => $entry->allowances,
            'note' => $entry->note,
        ];
    }
}
