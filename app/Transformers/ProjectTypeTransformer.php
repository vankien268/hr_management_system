<?php

namespace App\Transformers;

use App\Enums\SystemPermissionEnum;
use App\Models\ProjectType;
use League\Fractal\TransformerAbstract;

use function App\Helper\check_user_permission;

class ProjectTypeTransformer extends TransformerAbstract
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
    protected $isDelete = false;
    public function __construct($isDelete = false)
    {
        $this->isDelete = $isDelete;
    }
    public function transform(ProjectType $entry)
    {
        $data = [
            'id' => $entry->id,
            'name' => $entry->name,
            'code' => $entry->code,
            'status' => $entry->status,
            'note' => $entry->note,
            'isEdit' => $entry->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::EDIT_PROJECT_TYPE),
        ];
        if($this->isDelete) {
            $data['isDelete'] = true;
          $data['is_delete_permission'] = $entry->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::DELETE_PROJECT_TYPE);
            if($entry->project) {
                $data['isDelete'] = false;
            }
        }
        return $data;
    }
}
