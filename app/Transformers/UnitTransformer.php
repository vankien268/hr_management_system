<?php

namespace App\Transformers;

use App\Models\Unit;
use App\Enums\SystemPermissionEnum;

use League\Fractal\TransformerAbstract;
use function App\Helper\check_user_permission;

class UnitTransformer extends TransformerAbstract
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
    public function transform(Unit $entry)
    {
        $data = [
            'id' => $entry->id,
            'code' => $entry->code,
            'name' => $entry->name,
            'status' => $entry->status,
            'note' => $entry->note,
            'created_by' => $entry->created_by,
            'isEdit' => $entry->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::EDIT_UNIT),
            'isDelete' => $entry->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::DELETE_UNIT)
        ];
        if($this->isDelete) {
            $data['isDelete'] = $entry->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::DELETE_UNIT);
            if($entry->products->count()) {
                $data['isDelete'] = false;
            }
        }
        return $data;
    }
}
