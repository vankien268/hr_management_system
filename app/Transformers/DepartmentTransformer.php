<?php

namespace App\Transformers;

use App\Enums\SystemPermissionEnum;
use App\Models\Department;
use League\Fractal\TransformerAbstract;

use function App\Helper\check_user_permission;

class DepartmentTransformer extends TransformerAbstract
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
    public function transform(Department $entry)
    {
        $data = [
            'name' => $entry->name,
            'code' => $entry->code,
            'status' => $entry->status ? "Sử dụng" : "Ngừng sử dụng",
            'note' => $entry->note,
            'is_edit' => check_user_permission(SystemPermissionEnum::EDIT_DEPARTMENT),
            'is_delete' => check_user_permission(SystemPermissionEnum::DELETE_DEPARTMENT),
        ];
        return $data;
    }

}
