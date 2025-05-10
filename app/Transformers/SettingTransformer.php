<?php

namespace App\Transformers;

use App\Enums\SystemPermissionEnum;
use App\Models\Setting;
use League\Fractal\TransformerAbstract;
use function App\Helper\check_user_permission;

class SettingTransformer extends TransformerAbstract
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
    public function transform(Setting $entry)
    {
        $data = [
            'id' => $entry->id,
            'type' => $entry->type,
            'object_id' => $entry->object_id,
            'valid' => $entry->valid,
            'values' =>  array_merge((array)json_decode($entry->value), ['id' => $entry->id]),
            'is_edit' => check_user_permission(SystemPermissionEnum::EDIT_TAXES),
            'is_delete' => check_user_permission(SystemPermissionEnum::DELETE_TAXES),
        ];
        return $data;
    }
}
