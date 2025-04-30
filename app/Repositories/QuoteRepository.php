<?php

namespace App\Repositories;

use App\Enums\ProjectPermissionEnum;
use App\Enums\SystemPermissionEnum;
use App\Models\ProjectFunctionUser;
use App\Models\Quote;
use App\Repositories\Interfaces\IQuoteProductRepository;

use function App\Helper\check_user_is_admin;
use function App\Helper\check_user_permission;
use function App\Helper\get_id_projects_user;

class QuoteRepository extends BaseRepository implements Interfaces\IQuoteRepository
{
    protected $viewQuotePermission;
    protected $quoteProductRepository;
    public function __construct(Quote $model, IQuoteProductRepository $quoteProductRepository)
    {
        $this->model = $model;
        $this->quoteProductRepository = $quoteProductRepository;
    }

    public function getData(){
        // $this->viewQuotePermission = check_user_permission(SystemPermissionEnum::APPROVE_PRICE_QUOTE);
        $searchData = request()->all();

        $results = $this->model

        ->with(['contractType', 'project', 'customer', 'approveBy', 'details.product.unit']);

        if(isset($searchData['code'])){
            $results->where('code', 'like', '%' . $searchData['code'] . '%');
        }
        if(isset($searchData['customer_id'])){
            $results->where('customer_id', $searchData['customer_id']);
        }
        if(isset($searchData['project_id'])){
            $results->where('project_id', $searchData['project_id']);
        }
        if(isset($searchData['contract_type_id'])){
            $results->where('contract_type_id', $searchData['contract_type_id']);
        }

        if(isset($searchData['created_by'])){
            $results->whereHas('creator', function ($query) use ($searchData) {
                $query->where('name', 'like', '%' . $searchData['created_by'] . '%');
            });
        }

        if(isset($searchData['receiver'])){
            $results->where('receiver', 'like', '%' . $searchData['receiver'] . '%');
        }

        if(isset($searchData['phone'])){
            $results->where('phone', 'like', '%' . $searchData['phone'] . '%');
        }

        if(isset($searchData['is_search_date']) && $searchData['is_search_date'] == 'true'){
            $results->where('quote_date', '>=', $searchData['from_date'])->where('quote_date', '<=', $searchData['to_date']);
        }

        if(check_user_is_admin() || check_user_permission(SystemPermissionEnum::VIEW_LIST_PRICE_QUOTE)){
            return $results->orderBy('project_id');
        }else{
            $results->where(function ($query) {
                $query->whereIn('project_id', get_id_projects_user(SystemPermissionEnum::VIEW_PRICE_QUOTES));
                if(check_user_permission(SystemPermissionEnum::APPROVE_PRICE_QUOTE)){
                    $query->orWhere('approve_id', auth()->user()->id);
                }
            });

        }
        // if(check_user_permission(SystemPermissionEnum::APPROVE_PRICE_QUOTE)){
        //     $results->where('approve_id', auth()->user()->id);
        // }
        // else{

        // }
        return $results->orderBy('project_id');
    }

    public function formatDataStore($requestData){
        $totalAmount = 0;
        foreach($requestData['details']['data'] as $key => $product){
            $requestData['details']['data'][$key] = $this->quoteProductRepository->formatDataStore($product);
            $totalAmount += $requestData['details']['data'][$key]['amount'];
        }
        $requestData['total_amount'] = $totalAmount;
        return $requestData;
    }
    public function formatDataUpdate($requestData, Quote $quote){
        $totalAmount = 0;
        $listProductIds = $quote->details->pluck('id')->toArray();
        foreach($requestData['details']['data'] as $key => $product){
            $requestData['details']['data'][$key] = $this->quoteProductRepository->formatDataStore($product);
            $totalAmount += $requestData['details']['data'][$key]['amount'];
            $index = array_search($product['id'], $listProductIds);
            if($index !== false){
                unset($listProductIds[$index]);
            }
        }
        $requestData['list_product_delete'] = $listProductIds;
        $requestData['total_amount'] = $totalAmount;
        return $requestData;
    }

    public function findUserHasPermissionViewProjectAndCreate($projectId, $userId)
    {
        $userHasProject = ProjectFunctionUser::where('project_id', $projectId)->where('user_id', $userId)->first();
        if(!$userHasProject) {
            $permission = [
                'project_id' =>  $projectId,
                'user_id' => $userId,
                'system_function_id' => ProjectPermissionEnum::VIEW_PROJECT_ID
            ];
            ProjectFunctionUser::create($permission);
        }
        return true;
    }
}
