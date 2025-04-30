<?php

namespace App\Repositories\Interfaces;

use App\Models\Quote;

interface IQuoteProductRepository extends IBaseRepository
{
    public function formatDataStore($requestData);
    public function formatDataUpdate($requestData);
}
