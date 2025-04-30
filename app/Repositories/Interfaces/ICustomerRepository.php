<?php

namespace App\Repositories\Interfaces;

interface ICustomerRepository extends IBaseRepository
{
    public function getData();
    public function formatDataStore();
    public function formatDataUpdate();
}
