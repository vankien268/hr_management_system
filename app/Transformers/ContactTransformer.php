<?php

namespace App\Transformers;

use App\Enums\ProjectPermissionEnum;
use App\Enums\SystemPermissionEnum;
use App\Models\Contact;
use League\Fractal\TransformerAbstract;
use function App\Helper\check_user_permission;

class ContactTransformer extends TransformerAbstract
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
    protected $isPivot = false;
    protected $isDelete = false;
    protected $projectId = null;
    public function __construct($isPivot = false, $isDelete = false, $projectId = null)
    {
        $this->isPivot = $isPivot;
        $this->isDelete =  $isDelete;
        $this->projectId =  $projectId;
    }

    public function transform(Contact $entry)
    {
        $data = [
            'id' => $entry->id,
            'name' => $entry->name,
            'email'=>  $entry->checkUserHasProjectPermission(
                ProjectPermissionEnum::VIEW_EMAIL_CUSTOMER_CONTACT,
                $this->projectId) || check_user_permission(SystemPermissionEnum::SYSTEM_EDIT_PROJECT)?  $entry->email : null,

            'phone' => $entry->checkUserHasProjectPermission(
                ProjectPermissionEnum::VIEW_PHONE_CUSTOMER_CONTACT,
                $this->projectId) || check_user_permission(SystemPermissionEnum::SYSTEM_EDIT_PROJECT) ?  $entry->phone : null,
            'position' => $entry->position,
            'note' => $entry->note,
            'customer_id' => $entry->customer_id
        ];
        if($this->isPivot) {
            $data['pivot'] = $entry->pivot;
        }
        return $data;
    }
}
