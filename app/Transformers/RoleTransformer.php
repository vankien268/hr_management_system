<?php

namespace App\Transformers;

use App\Models\Role;
use App\Enums\SystemPermissionEnum;

use League\Fractal\TransformerAbstract;
use function App\Helper\check_user_permission;

class RoleTransformer extends TransformerAbstract
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
    public  function __construct($isDelete = false)
    {
        $this->isDelete = $isDelete;
    }
    public function transform(Role $entry)
    {
        $data = [
            'id' => $entry->id,
            'name' => $entry->name,
            'status' => $entry->status,
            'isEdit' => check_user_permission(SystemPermissionEnum::EDIT_DECLARE_ROLE)
        ];
        $data['isDelete'] = check_user_permission(SystemPermissionEnum::DELETE_DECLARE_ROLE);

        if ( $entry->id === 1) {
            $data['isDelete'] = false;
        }
        return $data;
    }
}
