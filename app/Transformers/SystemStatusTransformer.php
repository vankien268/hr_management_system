<?php

namespace App\Transformers;

use App\Enums\SystemPermissionEnum;
use App\Models\SystemStatus;
use League\Fractal\TransformerAbstract;

use function App\Helper\check_user_permission;

class SystemStatusTransformer extends TransformerAbstract
{
    protected $option;
    public function __construct($option = [])
    {
        $this->option = $option;
    }
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
    public function transform(SystemStatus $entry)
    {
        $data = [
            'id' => $entry->id,
            'name' => $entry->name,
            'note' => $entry->note,
            'type' => $entry->type,
            'type_text' => $entry->getStatusType(),
            'status' => $entry->status,
            'status_text' => $entry->getTextStatus(),
            'is_edit' => $entry->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::EDIT_SYSTEM_STATUS),
        ];

        if (array_key_exists('is_delete', $this->option) && $this->option['is_delete'] === true) {
            $delete = $entry->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::DELETE_SYSTEM_STATUS);
            if (
                $entry->contracts->count() > 0 ||
                $entry->projects->count() > 0 ||
                $entry->customers->count() > 0 ||
                $entry->tasks->count() > 0 ||
                $entry->acceptanceRecords->count() > 0 ||
                $entry->deploymentRecords->count() > 0 ||
                $entry->deploymentSchedules->count() > 0 ||
                $entry->dispatches->count() > 0
            ) {
                $delete = false;
            }
            $data = array_merge($data, [
                'is_delete' => $delete
            ]);
        }
        return $data;
    }
}
