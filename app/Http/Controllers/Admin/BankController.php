<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Enums\SystemPermissionEnum;
use App\Http\Controllers\Controller;
use App\Transformers\BankTransformer;
use App\Http\Requests\BankStoreRequest;
use App\Http\Requests\BankUpdateRequest;
use Illuminate\Support\Facades\Validator;

use function App\Helper\check_user_permission;
use App\Repositories\Interfaces\IBankRepository;

class BankController extends Controller
{
    protected $bankRepository;
    public function __construct(IBankRepository $bankRepository)
    {
        $this->bankRepository = $bankRepository;
        $this->setTransformer(new BankTransformer());
    }

    public function index()
    {
        $breadcrumbs = [
            [
                'link' => null,
                'text' => __('Quản lý ngân hàng')
            ],
        ];
        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_BANK);
        $data = [
            'pageName' =>  trans('Quản lý ngân hàng'),
            'breadcrumbs' => $breadcrumbs,
            'btnAdd' => $btnAdd,
        ];
        return view('admin.banks.index')->with($data);
    }

    public function getAllBanks(Request $request)
    {
        $perPage = $request->per_page;
        if(!$perPage) {
            $perPage = 30;
        }
        $getBanks = $this->bankRepository->model()->with('customer')->orderByDesc('id')->paginate($perPage);
        $this->setTransformer(new BankTransformer(true));
        return $this->responsePaginatedCollection($getBanks, 200);
    }

    public function store(BankStoreRequest $request)
    {
        if(! check_user_permission(SystemPermissionEnum::ADD_BANK)) {
            return $this->errorsResponse(['message' => trans('Bạn không có quyền thêm ngân hàng.')], 403);
        }

        $data = $request->all();
        try {
            $bank = $this->bankRepository->create($data);
            return $this->successResponse(['bank' => $bank, 'message' => trans('Thêm ngân hàng thành công !')], 200);
        } catch (\Exception $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function update(BankUpdateRequest $request, $id)
    {
        if(! check_user_permission(SystemPermissionEnum::EDIT_BANK)) {
            return $this->errorsResponse(['message' => trans('Bạn không có quyền sửa ngân hàng.')], 403);
        }

        $data = $request->except('code');
        $entry = $this->bankRepository->find($id);
        if (!$entry) {
            return $this->errorsResponse(['id' => trans('Không tồn tại ngân hàng !')], 422);
        }
        try {
            $bank = $entry->update($data);
            return $this->successResponse(['bank' => $bank, 'message' => trans('Sửa loại ngân hàng thành công !')], 200);
        } catch (\Exception $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        if(! check_user_permission(SystemPermissionEnum::DELETE_BANK)) {
            return $this->errorsResponse(['message' => trans('Bạn không có quyền xóa ngân hàng.')], 403);
        }

        $entry = $this->bankRepository->find($id);
        if(!$entry){
            return $this->errorsResponse(["id" => trans("Không tồn tại ngân hàng !")], 404);
        }
        try {
            $entry->forceDelete($id);
            return $this->successResponse(['bank' => $entry,'message' => trans('Xóa dữ liệu thành công!')], 200);
        } catch (\Exception $e) {
            return $this->errorResponse(['id' => $e->getMessage()]);
        }
    }
}
