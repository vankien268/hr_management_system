<?php

namespace App\Transformers;

use App\Models\AnnexContract;
use League\Fractal\TransformerAbstract;

class AnnexContractTransformer extends TransformerAbstract
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
    public function transform(AnnexContract $entry)
    {
        $data = [
            'id' => $entry->id,
            'contract_id' => $entry->contract_id,
            'date' => $entry->date,
            'description' => $entry->description,
            'code' => $entry->code,
        ];
        if($this->relation) {
            $data['contract'] = fractal($entry->contract, new ContractTransformer());
        }
        return $data;
    }
}
