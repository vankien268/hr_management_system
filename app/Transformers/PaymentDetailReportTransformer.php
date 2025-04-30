<?php

namespace App\Transformers;

use App\Models\PaymentDetail;
use League\Fractal\TransformerAbstract;

class PaymentDetailReportTransformer extends TransformerAbstract
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
    protected $relation = false;
    public function __construct($relation = false)
    {
        $this->relation = $relation;
    }
    public function transform(PaymentDetail $entry)
    {
        $data = [
            'id' => $entry->id,
            'contract_id' => $entry->contract_id,
            'payment_times' => $entry->payment_times,
            'amount' => $entry->amount,
            'actual_amount' => $entry->actual_amount,
            'expected_payment_date' => $entry->expected_payment_date,
            'payment_date' => $entry->payment_date,
            'note' => $entry->note
        ];

        if ($this->relation) {
            $data['contract'] = fractal($entry->contract, new ContractTransformer());
            $data['project_name'] = '<p class="pt-1 pb-1">'.$entry->contract->project->code . '-' . $entry->contract->project->name .'</p>'. '<p class="pb-1">'. $entry->contract->project->customer->code . '-' . $entry->contract->project->customer->name. '<p>';
            // $data['project'] = fractal($entry->contract->project, new ProjectManagementTransformer());
            $data['customer'] = fractal($entry->contract->project->customer, new CustomerTransformer());
            $data['contract_signing_date'] = '<p class="pt-1 pb-1">'.'Ngày ký: ' . $entry->contract->signing_date .'</p>'. '<p class="pb-1">'. 'Số hợp đồng: ' . $entry->contract->code. '<p>';
        }

        return $data;
    }
}
