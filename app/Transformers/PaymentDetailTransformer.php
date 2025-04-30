<?php

namespace App\Transformers;

use App\Models\PaymentDetail;
use League\Fractal\TransformerAbstract;

class PaymentDetailTransformer extends TransformerAbstract
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
    protected $relation = false;
    protected $relationHistory = [];
    public function __construct($relation = false, $relationHistory = [])
    {
        $this->relation = $relation;
        $this->relationHistory = $relationHistory;
    }
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(PaymentDetail $entry)
    {
        $data =  [
            'id' => $entry->id,
            'contract_id' => $entry->contract_id,
            'payment_times' => $entry->payment_times,
            'amount' => $entry->amount,
            'actual_amount' => $entry->actual_amount,
            'expected_payment_date' => $entry->expected_payment_date,
            'payment_date' => $entry->payment_date,
            'note' => $entry->note
        ];
        if($this->relation) {
            $data['contract'] = fractal($entry->contract, new ContractTransformer());

        }
        return $data;
    }
}
