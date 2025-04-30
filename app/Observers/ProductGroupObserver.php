<?php

namespace App\Observers;

use App\Models\ProductGroup;
use App\Repositories\Interfaces\IProductGroupRepository;

class ProductGroupObserver
{
    protected $productGroupRepository;
    public function __construct(IProductGroupRepository $productGroupRepository)
    {
        $this->productGroupRepository = $productGroupRepository;
    }
    /**
     * Handle the ProductGroup "created" event.
     */
    public function created(ProductGroup $productGroup): void
    {
        //
    }

    /**
     * Handle the ProductGroup "updated" event.
     */
    public function updated(ProductGroup $productGroup): void
    {
        if($productGroup->isDirty('status')){
            $childrenIds = $productGroup->descendants->pluck('id')->toArray();
            $this->productGroupRepository->model()->whereIn('id', $childrenIds)->update(['status' => $productGroup->status]);
        }
    }

    /**
     * Handle the ProductGroup "deleted" event.
     */
    public function deleted(ProductGroup $productGroup): void
    {
        //
    }

    /**
     * Handle the ProductGroup "restored" event.
     */
    public function restored(ProductGroup $productGroup): void
    {
        //
    }

    /**
     * Handle the ProductGroup "force deleted" event.
     */
    public function forceDeleted(ProductGroup $productGroup): void
    {
        //
    }
}
