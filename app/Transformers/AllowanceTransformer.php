<?php

namespace App\Transformers;

use App\Models\Allowance;
use League\Fractal\TransformerAbstract;

class AllowanceTransformer extends TransformerAbstract
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
    public function transform(Allowance $entry)
    {
        $data = [
            'id' => $entry->id,
            'allowance_name' => $entry->allowance_name,
            'allowance_type' => $entry->allowance_type,
            'allowed_number_days' => $entry->allowed_number_days ? $entry->allowed_number_days : 0,
            'allowance_amount' => $entry->allowance_amount,
            'description' => $entry->description,
            'valid' => $entry->valid,
            'default' => $entry->default,
            'status' => $entry->status,
            'status_name' => $entry->status == 1 ? "Sử dụng" : "Ngừng sử dụng",
            'is_deleted' => $entry->default != 0
//            'is_edit' => $entry->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::EDIT_DEPARTMENT),
        ];
        return $data;
    }
}
