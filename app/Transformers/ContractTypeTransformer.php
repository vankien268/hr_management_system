<?php

namespace App\Transformers;

use App\Enums\SystemPermissionEnum;
use App\Models\ContractType;
use League\Fractal\TransformerAbstract;

use function App\Helper\check_user_permission;

class ContractTypeTransformer extends TransformerAbstract
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
    public function transform(ContractType $entry)
    {
        $data = [
            'id' => $entry->id,
            'code' => $entry->code,
            'name' => $entry->name,
            'note' => $entry->note,
            'status' => $entry->status,
            'status_text' => $entry->getTextStatus(),
            'delete_note' => '',
//            'is_edit' => $entry->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::EDIT_CONTRACT_TYPE),
            'is_edit' => true,
        ];
        if (array_key_exists('is_delete', $this->option) && $this->option['is_delete'] === true) {
            $delete = $entry->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::DELETE_CONTRACT_TYPE);

            if($entry->contracts->count() > 0 || $entry->deploymentSchedules->count() > 0){
                $delete = true;
            }
            $data = array_merge($data, [
                'is_delete' => $delete
            ]);
        }
        return $data;
    }
}
