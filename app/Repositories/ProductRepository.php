<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\IProductRepository;

class ProductRepository extends BaseRepository implements IProductRepository {
    public function __construct(Product $model)
    {
        $this->model = $model;
    }
    public function getData(){
        return $this->model->with(['productGroup' => ['taxRate', 'feeRate'], 'unit']);
    }
}
