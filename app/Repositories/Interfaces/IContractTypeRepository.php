<?php

namespace App\Repositories\Interfaces;

interface IContractTypeRepository extends IBaseRepository
{
    public function getData();
    public function formatDataStore();
    public function formatDataUpdate();
}
