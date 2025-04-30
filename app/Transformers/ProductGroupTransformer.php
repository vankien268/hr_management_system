<?php

namespace App\Transformers;

use App\Models\ProductGroup;
use App\Enums\SystemPermissionEnum;

use League\Fractal\TransformerAbstract;
use function App\Helper\check_user_permission;

class ProductGroupTransformer extends TransformerAbstract
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
    public function transform(ProductGroup $entry)
    {
        $data = [
            'id' => $entry->id,
            'code' => $entry->code,
            'prefix' => $this->showPrefix($entry),
            'name' => $entry->name,
            'note' => $entry->note,
            'status' => $entry->status,
            'status_text' => $entry->getTextStatus(),
            '_lft' => $entry->_lft,
            '_rgt' => $entry->_rgt,
            'parent_id' => $entry->parent_id,
            'edit_status' => $entry->productGroup && $entry->productGroup->status == true ? true : false,
            'tax_id' => $entry->tax_id,
            'fee_id' => $entry->fee_id,
            'is_edit' => $entry->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::EDIT_PRODUCT_GROUP),
        ];

        if($entry->relationLoaded('taxRate')){
            $data = array_merge($data, [
                'tax' => fractal($entry->taxRate, new TaxFeeRateTransformer())->toArray()
            ]);
        }
        if($entry->relationLoaded('feeRate')){
            $data = array_merge($data, [
                'fee' => fractal($entry->feeRate, new TaxFeeRateTransformer())->toArray()
            ]);
        }

        if(array_key_exists('is_delete', $this->option) && $this->option['is_delete'] == true){
            $delete = $entry->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::DELETE_PRODUCT_GROUP);
            if($entry->products->count() > 0 || $entry->productGroups->count() > 0){
                $delete = false;
            }
            $data = array_merge($data, [
                'is_delete' => $delete
            ]);
        }
        return $data;
    }

    function showPrefix(ProductGroup $entry, $char = '-') {
        $result = '';
        for($i = 0; $i < $entry->depth; $i++){
            $result .= $char;
        }
        return $result;
    }
}
