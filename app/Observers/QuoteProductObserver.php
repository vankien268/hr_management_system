<?php

namespace App\Observers;

use App\Models\QuoteProduct;
use App\Repositories\Interfaces\IProductRepository;

class QuoteProductObserver
{
    protected $productRepository;
    public function __construct(IProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    /**
     * Handle the QuoteProduct "created" event.
     */
    public function created(QuoteProduct $quoteProduct): void
    {
        //
    }

    /**
     * Handle the QuoteProduct "updating" event.
     */
    public function updating(QuoteProduct $quoteProduct): bool
    {
        if($quoteProduct->isDirty('product_id')){
            $product = $this->productRepository->findWithRelationships($quoteProduct->product_id, ['productGroup' => ['taxRate', 'feeRate']]);
            $quoteProduct->tax_rate = $product->productGroup->taxRate->rate;
            $quoteProduct->fee_rate = $product->productGroup->feeRate->rate;
        }
        return true;
    }

    /**
     * Handle the QuoteProduct "updated" event.
     */
    public function updated(QuoteProduct $quoteProduct): void
    {
        //
    }

    /**
     * Handle the QuoteProduct "deleted" event.
     */
    public function deleted(QuoteProduct $quoteProduct): void
    {
        //
    }

    /**
     * Handle the QuoteProduct "restored" event.
     */
    public function restored(QuoteProduct $quoteProduct): void
    {
        //
    }

    /**
     * Handle the QuoteProduct "force deleted" event.
     */
    public function forceDeleted(QuoteProduct $quoteProduct): void
    {
        //
    }
}
