<?php

namespace App\Repositories\Interfaces;

use App\Models\Quote;

interface IQuoteRepository extends IBaseRepository
{
    public function getData();

    public function formatDataStore($requestData);
    public function formatDataUpdate($requestData, Quote $quote);

    public function findUserHasPermissionViewProjectAndCreate($projectId, $userId);
}
