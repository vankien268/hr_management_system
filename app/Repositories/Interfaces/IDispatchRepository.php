<?php


namespace App\Repositories\Interfaces;


interface IDispatchRepository extends IBaseRepository
{
    public function getDataSendNotificationsFromDate($dispatch);
    public function getDataSendNotificationsToDate($dispatch);
}
