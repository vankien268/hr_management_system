<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\APIResponseHandlerTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class BaseAPIController extends Controller
{
    use APIResponseHandlerTrait;

    protected  $portal_id;

    public function __construct()
    {
        $potal_id = Session::get('portal_id');
        $this->portal_id =  $potal_id;
    }


    public function getPortalId()
    {
        $potal_id = Session::get('portal_id');
        return $potal_id;
    }

    protected function authenticationMiddleware()
    {
        return $this->middleware('auth:sanctum');
    }

    protected function clientCredentialsMiddleware()
    {
        return $this->middleware('client.credentials');
    }
}
