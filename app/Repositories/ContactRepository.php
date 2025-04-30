<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Repositories\Interfaces\IContactRepository;

class ContactRepository extends BaseRepository implements IContactRepository{
    public function __construct(Contact $model)
    {
        $this->model = $model;
    }
}
