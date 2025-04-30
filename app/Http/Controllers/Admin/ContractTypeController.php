<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SystemPermissionEnum;
use App\Http\Requests\UpdateContractTypeRequest;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContractTypeRequest;
use App\Transformers\ContractTypeTransformer;
use App\Repositories\Interfaces\IContractTypeRepository;

use function App\Helper\check_user_permission;

class ContractTypeController extends Controller
{
    protected $manager;
    protected $contractTypeRepository;
    protected $transformer;
    public function __construct(Manager $manager, ContractTypeTransformer $transformer, IContractTypeRepository $contractTypeRepository)
    {
        $this->contractTypeRepository = $contractTypeRepository;
        $this->manager = $manager;
        $this->transformer = $transformer;
        $this->setTransformer($transformer);
    }

    /**
     * Summary of view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function view()
    {
        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_CONTRACT_TYPE);
        return view(
            'admin.contract.contract_type',
            [
                'pageName' => trans("Khai báo loại hợp đồng"),
                'btnAdd' => $btnAdd,
            ]
        );
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requestData = request()->all();
        $entries = $this->contractTypeRepository->getData()->latest('id');
        $this->setTransformer(new ContractTypeTransformer(['is_delete' => true]));
        if(isset($requestData['getAll']) && $requestData['getAll'] == 'true'){
            return $this->responseCollection($entries->get(), 200, [], ['paginate' => false]);
        }
        return $this->responsePaginatedCollection($entries->paginate($requestData['per_page'] ?? 30));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractTypeRequest $request)
    {
        $requestData = $this->contractTypeRepository->formatDataStore();
        DB::beginTransaction();
        try {
            $entry = $this->contractTypeRepository->create($requestData);
            DB::commit();
            return $this->responseOne($entry);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorsResponse(['id' => $th->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractTypeRequest $request, string $id)
    {
        $requestData = $this->contractTypeRepository->formatDataUpdate();
        $entry = $this->contractTypeRepository->find($id);
        if(!$entry){
            return $this->errorsResponse(['id' => trans('Dữ liệu tìm kiếm không tồn tại.')], 404);
        }
        DB::beginTransaction();
        try {
            $entry = $this->contractTypeRepository->update($id, $requestData);
            DB::commit();
            return $this->responseOne($entry);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorsResponse(['id' => $th->getMessage()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $entry = $this->contractTypeRepository->find($id);
        if(!$entry){
            return $this->errorsResponse(['id' => trans('Dữ liệu tìm kiếm không tồn tại.')], 404);
        }
        DB::beginTransaction();
        try {
            $this->contractTypeRepository->destroy($id);
            DB::commit();
            return $this->responseOne($entry);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorsResponse(['id' => $th->getMessage()], 422);
        }
    }
}
