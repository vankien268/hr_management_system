<?php

namespace App\Repositories;

use App\Models\Dispatch;
use App\Repositories\Interfaces\IDispatchRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class DispatchRepository extends BaseRepository implements IDispatchRepository{

    protected $dispatchRepository;

    public function __construct(Dispatch $model)
    {
        $this->model = $model;
    }

    public function getDataSendNotificationsFromDate($dispatch)
    {
        $record = $this->model->where('id', $dispatch->id)

        ->whereDate('from_date', Carbon::now()->format('Y-m-d'))
        ->orwhereRaw('DATE_FORMAT(from_date, "%Y-%m-%d") = ?', [Carbon::now()->addDay()->format('Y-m-d')])
        ->with(['customer:id,name,code'])
        ->with(['project' => function($q) {
            $q->with('functionProjectHasUsers');
        }])
        ->first();
        if($record) {
            $record->isTodate = false;
        }
        return $record;
    }

    public function getDataSendNotificationsToDate($dispatch)
    {
        $record = $this->model->where('id', $dispatch->id)

        ->with(['customer:id,name,code'])
        ->where(function($query){
            $query->where('to_date', Carbon::now()->format('Y-m-d'))
            ->orWhere('to_date', Carbon::now()->addDay()->format('Y-m-d')) ;
        })
        ->with(['project' => function($q) {
            $q->with('functionProjectHasUsers');
        }])
        ->first();
        if($record) {
            $record->isTodate = true;
        }
        return $record;

    }
}
