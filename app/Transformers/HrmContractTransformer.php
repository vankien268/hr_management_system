<?php

namespace App\Transformers;

use App\Models\HrmContract;
use Carbon\Carbon;
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
            'contract_type_id' => $entry->contract_type_id,
            'department_id' => $entry->department_id,
            'contact_id' => $entry->contact_id,
            'contact_full_name' => $entry->contact ? $entry->contact->full_name : null,
            'contract_type_name' => $entry->contractType ? $entry->contractType->name : null,
            'signer_user_id' => $entry->signer_user_id,
            'signer_department_id' => $entry->signer_department_id,
            'time_limited' => $entry->time_limited,
            'work_type' => $entry->work_type,
            'basic_salary' => $entry->basic_salary,
            'register_date' => $entry->register_date ? Carbon::parse($entry->register_date)->format('Y-m-d') : null,
            'effective_date' => $entry->effective_date ? Carbon::parse($entry->effective_date)->format('Y-m-d') : null,
            'expiration_date' => $entry->expiration_date ? Carbon::parse($entry->expiration_date)->format('Y-m-d') : null,
            'allowances' => $entry->allowances ? explode(',', $entry->allowances) : [],
            'note' => $entry->note,
            'department_name' => $entry->department->name ?? '',
        ];
    }
}
