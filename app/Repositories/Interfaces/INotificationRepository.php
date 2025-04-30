<?php

namespace App\Repositories\Interfaces;

interface INotificationRepository extends IBaseRepository
{
    public function getDataNotificationFilter($request);
}
