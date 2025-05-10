<?php

namespace App\Transformers;

use App\Enums\SystemPermissionEnum;
use App\Models\Bank;
use League\Fractal\TransformerAbstract;

use function App\Helper\check_user_permission;

class BankTransformer extends TransformerAbstract
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
    public function transform(Bank $entry)
    {
        $data = [
            'id' => $entry->id,
            'def_name' => $entry->def_name,
            'name' => $entry->name,
            'status' => $entry->status,
            'note' => $entry->note,
            'isEdit' => check_user_permission(SystemPermissionEnum::EDIT_BANK),
            'isDelete' => check_user_permission(SystemPermissionEnum::DELETE_BANK)
        ];
//        $data['isDelete'] = true;
//        if ($this->isDelete) {
//            $data['isDelete'] = $entry->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::DELETE_BANK);
//            if ($entry->customer) {
//                $data['isDelete'] = false;
//            }
//        }
        return $data;
    }
}
