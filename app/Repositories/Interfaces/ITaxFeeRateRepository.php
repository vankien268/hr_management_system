<?php


namespace App\Repositories\Interfaces;


interface ITaxFeeRateRepository extends IBaseRepository
{
    public function getListSelect($type = null);
}
