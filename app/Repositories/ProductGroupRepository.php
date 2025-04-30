<?php

namespace App\Repositories;

use App\Models\ProductGroup;

class ProductGroupRepository extends BaseRepository implements Interfaces\IProductGroupRepository
{
    public function __construct(ProductGroup $model)
    {
        $this->model = $model;
    }
    public function getListData()
    {
        $requestData = request()->all();
        $result = $this->model;
        if(!isset($requestData['load_relation']) || $requestData['load_relation'] == false){
            $result = $this->model->with(['products', 'taxRate', 'feeRate', 'productGroups']);
        }
        return $result->orderBy('_lft')->withDepth()->get();
    }
}
