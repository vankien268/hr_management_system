<?php


namespace App\Repositories\Interfaces;


interface IUserRepository extends IBaseRepository
{
    public function getDataFilter($request);
    public function getListUser();
}
