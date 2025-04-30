<?php

namespace App\Transformers;

use App\Enums\ProjectPermissionEnum;
use App\Enums\SystemPermissionEnum;
use App\Models\QuoteProduct;
use League\Fractal\TransformerAbstract;
use function App\Helper\check_user_permission;

class QuoteProductTransformer extends TransformerAbstract
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
    public function transform(QuoteProduct $entry)
    {

        $data = [
            'id' => $entry->id,
            'quote_id' => $entry->quote_id,
            'product_id' => $entry->product_id,
            'price' => $entry->price,
            'quantity' => $entry->quantity,
            'amount' => $entry->amount,
            'tax_rate' => $entry->tax_rate,
            'fee_rate' => $entry->fee_tate

        ];
        if($entry->relationLoaded('product')){
            $data = array_merge($data, [
                'product' => fractal($entry->product, new ProductTransformer(true))->toArray()['data'],
            ]);
        }
        return $data;
    }
}
