<?php

namespace App\Transformers;

use App\Models\ContractModule;
use League\Fractal\TransformerAbstract;

class ContractModuleTransformer extends TransformerAbstract
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
    public function transform(ContractModule $entry)
    {
        $data = [
            'id' => $entry->id,
            'module_id' => $entry->module_id,
            'contract_id' => $entry->contract_id,
            'value' => $entry->value,
            'note_module' => $entry->note_module,
            'status' => $entry->status,
            'module' => $entry->module->name, //fractal($entry->module, new ModuleTransformer())->toArray()
        ];
        if($this->relation) {
            $data['contract'] = fractal($entry->contract, new ContractTransformer());
        }
        return $data;
    }
}
