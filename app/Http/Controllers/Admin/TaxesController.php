<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SystemPermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\AllowanceStoreRequest;
use App\Http\Requests\AllowanceUpdateRequest;
use App\Http\Requests\TaxRequestStore;
use App\Http\Requests\TaxRequestUpdate;
use App\Models\Setting;
use App\Repositories\Interfaces\IAllowanceRepository;
use App\Repositories\Interfaces\ISettingRepository;
use App\Transformers\AllowanceTransformer;
use App\Transformers\SettingTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function App\Helper\check_user_permission;

class TaxesController extends Controller
{

    private $settingRepository;

    public function __construct(ISettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function index()
    {
        $breadcrums = [
            'text' => trans('Khai báo thuế thu nhập cá nhân')
        ];
        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_TAXES);
        $data = [
            'breadcrums' => $breadcrums,
            'pageName' => trans('Khai báo thuế thu nhập cá nhân'),
            'btnAdd' => $btnAdd,
        ];
        return view('admin.taxes.index')->with($data);
    }

    public function getAllTaxes(Request $request)
    {
        $taxes = $this->settingRepository->model()
            ->where('type', Setting::TYPE_TAX_CALCUL)
            ->where('valid', 1)
            ->get();

        $this->setTransformer(new SettingTransformer());

        return $this->responseCollection(
            $taxes,
            200
        );
    }

    public function store(TaxRequestStore $request)
    {

        if(! check_user_permission(SystemPermissionEnum::ADD_TAXES)) {
            return $this->errorsResponse(['message' => trans('Bạn không có quyền thêm thuế thu nhập cá nhân.')], 403);
        }

        $data = $request->only(['tax_name', 'tax_income_from', 'tax_income_to', 'tax_rate', 'tax_reduction']);

        DB::beginTransaction();
        try {
            $this->settingRepository->create([
                'value' => json_encode($data),
                'valid' => 1,
                'type' => Setting::TYPE_TAX_CALCUL
            ]);
            DB::commit();
            return $this->successResponse(['message' => trans('Thêm thuế thành công!')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function update($id, TaxRequestUpdate $request)
    {
        if(! check_user_permission(SystemPermissionEnum::EDIT_TAXES)) {
            return $this->errorsResponse(['message' => trans('Bạn không có quyền sửa thuế thu nhập cá nhân.')], 403);
        }

        $tax = $this->settingRepository->find($id);

        if (! $tax) {
            return $this->errorsResponse(['message' => trans('Thuế không tồn tại.')], 422);
        }

        DB::beginTransaction();
        try {
            $data = $request->all();
            unset($data['project_functions'], $data['list_permissions']);

            $tax->update(['value' => $data]);
            DB::commit();
            return $this->successResponse(['tax' => $tax->refresh(), 'message' => trans('Sửa thuế thành công!')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy($id)
    {
        if(! check_user_permission(SystemPermissionEnum::DELETE_TAXES)) {
            return $this->errorsResponse(['message' => trans('Bạn không có quyền xóa thuế thu nhập cá nhân.')], 403);
        }

        $tax = $this->settingRepository->find($id);

        if (! $tax) {
            return $this->errorsResponse(['message' => trans('Thuế không tồn tại.')], 422);
        }

        DB::beginTransaction();
        try {
            $tax->update(['valid' => 0]);
            DB::commit();
            return $this->successResponse(['message' => trans('Xóa thuế thành công!')]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return $this->errorResponse($throwable->getMessage());
        }
    }
}
