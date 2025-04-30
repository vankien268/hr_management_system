<?php

namespace App\Repositories\Interfaces;

interface ISystemStatusRepository extends IBaseRepository
{
    public function getStatusType();
    public function getData();
    public function formatDataStore($data);
    public function formatDataUpdate();
}
