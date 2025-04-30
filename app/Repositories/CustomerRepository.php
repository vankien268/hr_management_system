<?php

namespace App\Repositories;

use App\Enums\SystemPermissionEnum;
use App\Models\Customer;

use function App\Helper\check_user_permission;

class CustomerRepository extends BaseRepository implements Interfaces\ICustomerRepository
{
    protected $viewVIPCustomerPermission;
    public function __construct(Customer $model)
    {
        $this->model = $model;
    }
    public function getData(){
        $this->viewVIPCustomerPermission = check_user_permission(SystemPermissionEnum::VIEW_LIST_CUSTOMER_VIP);
        $requestData = $this->formatSearchData(request()->all());
        // $result = $this->model->with(['status', 'city', 'district', 'ward', 'bank', 'projects', 'contracts']);
        if(!isset($requestData['getAll'])){
            $result = $this->model->with(['status', 'city', 'district', 'ward', 'bank', 'projects', 'contracts', 'user']);
        }
        else{
            $result = $this->model->query();
        }
        if(isset($requestData['search'])){
            $result->where(function ($query) use ($requestData) {
                $query->where('code', 'like', '%' . $requestData['search'] . '%')->orWhere('name', 'like', '%' . $requestData['search'] . '%');
            });
        }
        if(isset($requestData['code'])){
            $result->where('code', 'like', '%' . $requestData['code'] . '%');
        }
        if(isset($requestData['name'])){
            $result->where('name', 'like', '%' . $requestData['name'] . '%');
        }
        if(isset($requestData['tax_code'])){
            $result->where('tax_code', 'like', '%' . $requestData['tax_code'] . '%');
        }
        if(isset($requestData['to_date']) && $requestData['from_date'] === "true"){
            $result->whereBetween('created_at', [$requestData['from_date'], $requestData['to_date']]);
        }
        if(!$this->viewVIPCustomerPermission){
            $result->withoutVIPCustomer();
        }
        return $result->latest('id');
    }
    public function formatDataStore(){
        $requestData = request()->all();
        if(!isset($requestData['bank_id']) || $requestData['bank_id'] == null){
            unset($requestData['bank_number']);
            unset($requestData['bank_username']);
        }
        return $requestData;
    }
    public function formatDataUpdate(){
        $requestData = request()->all();
        unset($requestData['code']);
        if(!isset($requestData['bank_id']) || $requestData['bank_id'] == null){
            $requestData['bank_number'] = null;
            $requestData['bank_username'] = null;
        }
        return $requestData;
    }

    public function formatSearchData($data)
    {
        if(isset($data['from_date']) || isset($data['to_date'])){
            $data['from_date'] = isset($data['from_date']) ? $data['from_date']: '1999-01-01';
            $data['to_date'] = isset($data['to_date']) ? $data['to_date'] : date('Y-m-d');
        }else{
            unset($data['from_date']);
            unset($data['to_date']);
        }
        return $data;
    }
}
