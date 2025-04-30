<?php

namespace App\Observers;

use App\Enums\QuoteStatusEnum;
use App\Enums\SystemPermissionEnum;
use App\Models\Quote;
use App\Repositories\Interfaces\IQuoteRepository;

use function App\Helper\check_user_permission;

class QuoteObserver
{
    protected $quoteRepository;
    public function __construct(IQuoteRepository $quoteRepository)
    {
        $this->quoteRepository = $quoteRepository;
    }
    /**
     * Handle the Quote "creating" event.
     */
    public function creating(Quote $quote): bool
    {
        $code = date('y') . date('m') . date('d');
        $c = $this->quoteRepository->model()->whereDate('created_at', date('Y-m-d'))->get();
        $quote->code = $code . '-' . ($c->count() + 1);
        return true;
    }
    /**
     * Handle the Quote "created" event.
     */
    public function created(Quote $quote): void
    {
        //
    }

    /**
     * Handle the Quote "updating" event.
     */
    public function updating(Quote $quote): bool
    {
        if(!check_user_permission(SystemPermissionEnum::EDIT_PRICE_QUOTES, $quote->getOriginal('project_id'))){
            return false;
        }
        if($quote->isDirty('status') && $quote->status == QuoteStatusEnum::APPROVED){
            $quote->approve_id = auth()->user()->id;
        }
        return true;
    }

    /**
     * Handle the Quote "updated" event.
     */
    public function updated(Quote $quote): void
    {
        //
    }

    /**
     * Handle the Quote "deleted" event.
     */
    public function deleted(Quote $quote): void
    {
        //
    }

    /**
     * Handle the Quote "restored" event.
     */
    public function restored(Quote $quote): void
    {
        //
    }

    /**
     * Handle the Quote "force deleted" event.
     */
    public function forceDeleted(Quote $quote): void
    {
        //
    }
}
