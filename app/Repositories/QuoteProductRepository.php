<?php

namespace App\Repositories;

use App\Models\Quote;
use App\Models\QuoteProduct;
use App\Repositories\Interfaces\IProductRepository;

class QuoteProductRepository extends BaseRepository implements Interfaces\IQuoteProductRepository
{
    protected $productRepository;
    public function __construct(QuoteProduct $model, IProductRepository $productRepository)
    {
        $this->model = $model;
        $this->productRepository = $productRepository;
    }
    public function formatDataStore($requestData){
        $product = $this->productRepository->findWithRelationships($requestData['product_id'], ['productGroup' => ['taxRate', 'feeRate']]);
        $requestData['price'] = str_replace('.', '', $requestData['price']);
        $requestData['amount'] = $requestData['price'] * $requestData['quantity'];

        $requestData['tax_rate'] = $product->productGroup->taxRate->rate;
        $requestData['fee_rate'] = $product->productGroup->feeRate->rate;
        return $requestData;
    }
    public function formatDataUpdate($requestData){
        unset($requestData['quote_id']);

        $requestData['price'] = str_replace('.', '', $requestData['price']);
        $requestData['amount'] = $requestData['price'] * $requestData['quantity'];
        
        return $requestData;
    }
}
