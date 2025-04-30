<?php

namespace App\Repositories\Interfaces;

interface IContractRepository extends IBaseRepository
{
    public function getData();
    public function formatDataStore();
    public function formatDataUpdate();
    public function formatDataContractModules($data);
    public function formatDataPaymentDetails($data);
    public function updateContract($contract);

}
