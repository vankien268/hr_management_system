<?php


namespace App\Repositories;


use App\Models\RequestTicket;
use App\Repositories\Interfaces\IRequestTicketRepository;

class RequestTicketRepository extends BaseRepository implements IRequestTicketRepository {
    public function __construct(RequestTicket $model)
    {
        $this->model = $model;
    }

}
