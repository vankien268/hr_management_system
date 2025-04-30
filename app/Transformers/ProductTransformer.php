<?php

namespace App\Transformers;

use App\Models\Product;
use App\Models\TaxFeeRate;
use App\Enums\SystemPermissionEnum;

use League\Fractal\TransformerAbstract;
use function App\Helper\check_user_permission;

class ProductTransformer extends TransformerAbstract
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
    protected $relations = false;
    protected $option;
    protected  $isDelete;
    public function __construct($relations = false, $isDelete = false, $option = [])
    {
        $this->relations = $relations;
        $this->option = $option;
        $this->isDelete =  $isDelete;
    }
    public function transform(Product $entry)
    {
        $data = [
            'id' => $entry->id,
            'code' => $entry->code,
            'name' => $entry->name,
            'unit_id' => $entry->unit_id,
            'price' => $entry->price,
            'edit_price' => $entry->edit_price ? true : false,
            'note' => $entry->note,
            'status' => $entry->status,
            'image_link' => $entry->image_link,
            'product_group_id' => $entry->product_group_id,
            'product_group_name' => @$entry->productGroup->code.
            ' - '.$entry->productGroup->name.' - '.$this->getTaxFee($entry, true).' - '.$this->getTaxFee($entry, false),
            'isEdit' => $entry->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::EDIT_PRODUCT),
        ];
        if($this->relations) {
            $data['unit'] = fractal($entry->unit, new UnitTransformer());
        }
        if($entry->relationLoaded('productGroup')){
            $data = array_merge($data, [
                'product_group' => fractal($entry->productGroup, new ProductGroupTransformer())->toArray(),
            ]);
        }
        if($this->isDelete) {
            $data['isDelete'] = true;
            $data['is_delete_permission'] = $entry->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::DELETE_PRODUCT);
            if($entry->quoteProducts->count()) {
                $data['isDelete'] = false;
            }
        }
        return $data;
    }

    private function getTaxFee($entry, $isTax)
    {
        if( $isTax) {
            return TaxFeeRate::TYPE_TAX[ $entry->productGroup->taxRate->type].
            ' : '.$entry->productGroup->taxRate->rate.'%';
        }else {
            return TaxFeeRate::TYPE_TAX[ $entry->productGroup->feeRate->type].
            ' : '.$entry->productGroup->feeRate->rate.'%';
        }

    }
}
