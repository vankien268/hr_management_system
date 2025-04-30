<?php

namespace App\Transformers;

use App\Enums\SystemPermissionEnum;
use League\Fractal\TransformerAbstract;
use App\Models\TaxFeeRate;

use function App\Helper\check_user_permission;

class TaxFeeRateTransformer extends TransformerAbstract
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
    public function transform(TaxFeeRate $entry)
    {
        $data = [
            'id' => $entry->id,
            'code' => $entry->code,
            'description' => $entry->description,
            'rate' => $entry->rate,
            'type' => $entry->type,
            'status' => $entry->status,
            'note' => $entry->note,
            'isEdit' => $entry->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::EDIT_TAX_FEE_RATE),
        ];
        if($this->isDelete) {
            $data['isDelete'] = $entry->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::DELETE_TAX_FEE_RATE);
            if($entry->productGroup->count()) {
                $data['isDelete'] = false;
            }
        }
        return $data;
    }
}
