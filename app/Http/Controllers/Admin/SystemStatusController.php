<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SystemPermissionEnum;
use App\Helper\PermissionHelper;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Transformers\SystemStatusTransformer;
use App\Http\Requests\StoreSystemStatusRequest;
use App\Http\Requests\UpdateSystemStatusRequest;
use App\Repositories\Interfaces\ISystemStatusRepository;

use function App\Helper\check_user_permission;

class SystemStatusController extends Controller
{
    protected $manager;
    protected $systemStatusRepository;
    protected $transformer;
    public function __construct(Manager $manager, ISystemStatusRepository $systemStatusRepository)
    {
        $this->systemStatusRepository = $systemStatusRepository;
        $this->manager = $manager;
        $transformer = new SystemStatusTransformer(['is_delete' => true]);
        $this->transformer = $transformer;
        $this->setTransformer($transformer);
    }

    /**
     * Summary of view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function view()
    {
        $statusTypeList = $this->systemStatusRepository->getStatusType();
        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_SYSTEM_STATUS);
        return view(
            'admin.system-statuses.system_status',
            [
                'pageName' => trans("Khai báo trạng thái"),
                'statusTypeList' => $this->responseJsonData($statusTypeList, null),
                'btnAdd' => $btnAdd,
            ]
        );
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entries = $this->systemStatusRepository->getData()->get();
        return $this->responseCollection($entries, 200, [], ['paginate' => false]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSystemStatusRequest $request)
    {
        $requestData = $request->all();
        $entries = collect();
        DB::beginTransaction();
        try {
            foreach ($requestData['data'] as $key => $status) {
                $status = $this->systemStatusRepository->formatDataStore($status);
                $result = $this->systemStatusRepository->create($status);
                $entries->push($result);
            }
            DB::commit();
            return $this->responseCollection($entries, 200, [], ['paginate' => false]);
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
    public function update(UpdateSystemStatusRequest $request, string $id)
    {
        $requestData = $this->systemStatusRepository->formatDataUpdate();

        $entry = $this->systemStatusRepository->find($id);
        if(!$entry){
            return $this->errorsResponse(['id' => trans('Dữ liệu tìm kiếm không tồn tại.')], 404);
        }
        DB::beginTransaction();
        try {
            $entry = $this->systemStatusRepository->update($id, $requestData);
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
        $entry = $this->systemStatusRepository->find($id);
        if(!$entry){
            return $this->errorsResponse(['id' => trans('Dữ liệu tìm kiếm không tồn tại.')], 404);
        }
        DB::beginTransaction();
        try {
            $delete = $this->systemStatusRepository->destroy($id);
            DB::commit();
            if($delete){
                return $this->responseOne($entry);
            }
            return $this->errorsResponse(['id' => trans('Xóa không thành công.')], 422);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorsResponse(['id' => $th->getMessage()], 422);
        }
    }
}
