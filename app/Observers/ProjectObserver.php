<?php

namespace App\Observers;

use App\Models\Project;
use App\Repositories\Interfaces\IQuoteRepository;

class ProjectObserver
{
    protected $quoteRepository;
    public function __construct(IQuoteRepository $quoteRepository)
    {
        $this->quoteRepository = $quoteRepository;
    }
    /**
     * Handle the Project "created" event.
     */
    public function created(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "updated" event.
     */
    public function updated(Project $project): void
    {
        if($project->isDirty('customer_id')){
            $project = $project->load('quotes');
            foreach($project->quotes as $item){
                $item->customer_id = $project->customer_id;
                $item->save();
            }
        }
    }

    /**
     * Handle the Project "deleted" event.
     */
    public function deleted(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "restored" event.
     */
    public function restored(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "force deleted" event.
     */
    public function forceDeleted(Project $project): void
    {
        //
    }
}
