<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Enums\SystemPermissionEnum;
use App\Http\Controllers\Controller;
use App\Transformers\UnitTransformer;
use App\Http\Requests\UnitStoreRequest;
use App\Http\Requests\UnitUpdateRequest;

use function App\Helper\check_user_permission;
use App\Repositories\Interfaces\IUnitRepository;

class UnitController extends Controller
{
    protected $unitRepository;
    public function __construct(IUnitRepository $unitRepository)
    {
        $this->unitRepository = $unitRepository;
        $this->setTransformer(new UnitTransformer());
    }

    public function index()
    {
        $breadcrumbs = [
            [
                'link' => null,
                'text' => __('Quản lý đơn vị tính')
            ],
        ];
        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_UNIT);
        $data = [
            'pageName' =>  trans('Quản lý đơn vị tính'),
            'breadcrumbs' => $breadcrumbs,
            'btnAdd' => $btnAdd,
        ];
        return view('admin.units.index')->with($data);
    }

    public function getAllUnits(Request $request)
    {
        $perPage = $request->per_page;
        if(!$perPage) {
            $perPage = 30;
        }
        $getUnits = $this->unitRepository->model()->with('products')->orderByDesc('id')->paginate($perPage);
        $this->setTransformer(new UnitTransformer(true));
        return $this->responsePaginatedCollection($getUnits, 200);
    }

    public function store(UnitStoreRequest $request)
    {
        $data = $request->all();
        try {
            $unit = $this->unitRepository->create($data);
            return $this->successResponse(['unit' => $unit, 'message' => trans('Thêm đơn vị tính thành công !')], 200);
        } catch (\Exception $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function update(UnitUpdateRequest $request, $id)
    {
        $data = $request->except('code');
        $entry = $this->unitRepository->find($id);
        if (!$entry) {
            return $this->errorsResponse(['id' => trans('Không tồn tại đơn vị tính !')], 422);
        }
        try {
            $unit = $entry->update($data);
            return $this->successResponse(['unit' => $unit, 'message' => trans('Sửa đơn vị tính thành công !')], 200);
        } catch (\Exception $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $entry = $this->unitRepository->find($id);
        if(!$entry){
            return $this->errorsResponse(["id" => trans("Không tồn tại đơn vị tính !")], 404);
        }
        try {
            $entry->forceDelete($id);
            return $this->successResponse(['unit' => $entry,'message' => trans('Xóa dữ liệu thành công!')], 200);
        } catch (\Exception $e) {
            return $this->errorResponse(['id' => $e->getMessage()]);
        }
    }

}
