<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use \App\Http\Controllers\Traits\APIResponseHandlerTrait;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, APIResponseHandlerTrait;

    public function __construct()
    {
        if(!request()->has('is_delete')){
            request()->merge(['is_delete' => false]);
        }else {
            request()->merge(['is_delete' => true]);
        }
    }
}
