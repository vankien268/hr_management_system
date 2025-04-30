<?php


namespace App\Repositories\Interfaces;


interface IProjectManagementRepository extends IBaseRepository
{
    public function getProjectsALLData($request);

    public function getDataProjectHistories($oldData, $newData);

    public function getDataProjectHistoriesCreate($project, $contact, $user);
}
