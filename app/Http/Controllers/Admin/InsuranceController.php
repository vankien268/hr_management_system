<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InsuranceUpdateRequest;
use App\Http\Requests\TaxRequestStore;
use App\Http\Requests\TaxRequestUpdate;
use App\Models\Setting;
use App\Repositories\Interfaces\ISettingRepository;
use App\Transformers\SettingTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InsuranceController extends Controller
{
    private $settingRepository;

    public function __construct(ISettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function index()
    {
        $breadcrums = [
            'text' => trans('Khai báo bảo hiểm')
        ];
//        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_PRODUCT);
        $data = [
            'breadcrums' => $breadcrums,
            'pageName' => trans('Khai báo bảo hiểm'),
            'btnAdd' => true,
        ];
        return view('admin.insurances.index')->with($data);
    }

    public function getAllInsurances(Request $request)
    {
        $type = $request->type;

        $insurances = $this->settingRepository->model()
            ->where('type', $type)
            ->where('valid', 1)
            ->orderByDesc('id')->get();

        $this->setTransformer(new SettingTransformer());

        return $this->responseCollection(
            $insurances,
            200
        );
    }

    public function update(InsuranceUpdateRequest $request)
    {
        $type = $request->type;
        $insurances = $request->insurances;

        $remove_insurance_ids = $request->remove_insurance_ids;

        DB::beginTransaction();
        try {
            if($insurances) {
                foreach ($insurances as $item) {
                    $salaryGrade = $this->settingRepository->model()
                        ->where('valid', 1)
                        ->where('type', $type)
                        ->where('id', $item['id'] ?? 0)
                        ->first();

                    unset($item['id'], $item['idSave']);

                    if($salaryGrade) {
                        $salaryGrade->update(['value' => json_encode($item)]);
                        continue;
                    }

                    $this->settingRepository->create([
                        'type' => $type,
                        'valid' => 1,
                        'value' => json_encode($item)
                    ]);
                }
            }

            if($remove_insurance_ids) {
                $this->settingRepository->model()
                    ->whereIn('id', $remove_insurance_ids)->delete();
            }

            DB::commit();
            return $this->successResponse(['message' => trans('Cập nhật bảo hiểm thành công!')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }
}
