<?php

namespace App\Transformers;

use App\Enums\SystemPermissionEnum;
use App\Models\Allowance;
use League\Fractal\TransformerAbstract;
use function App\Helper\check_user_permission;

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
            'is_edit' =>  check_user_permission(SystemPermissionEnum::EDIT_ALLOWANCE),
        ];

        $data['is_deleted'] = false;

        if(check_user_permission(SystemPermissionEnum::DELETE_ALLOWANCE)) {
            $data['is_deleted'] = true;

            if($entry->default != 0) {
                $data['is_deleted'] = false;
            }
        }
        return $data;
    }
}
