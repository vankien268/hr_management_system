<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SystemPermissionEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\ITaxFeeRateRepository;
use App\Transformers\TaxFeeRateTransformer;
use App\Http\Requests\TaxFeeRateStoreRequest;
use App\Http\Requests\TaxFeeRateUpdateRequest;

use function App\Helper\check_user_permission;

class TaxFeeRateController extends Controller
{
    protected $taxFeeRateRepository;
    public function __construct(ITaxFeeRateRepository $taxFeeRateRepository)
    {
        $this->taxFeeRateRepository = $taxFeeRateRepository;
        $this->setTransformer(new TaxFeeRateTransformer());
    }

    public function index()
    {
        $breadcrumbs = [
            [
                'link' => null,
                'text' => __('Khai báo tỷ lệ thuế phí')
            ],
        ];
        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_TAX_FEE_RATE);
        $data = [
            'pageName' =>  trans('Khai báo tỷ lệ thuế phí'),
            'breadcrumbs' => $breadcrumbs,
            'btnAdd' => $btnAdd,
        ];
        return view('admin.tax-fee-rates.index')->with($data);
    }

    public function getAllTaxFeeRates(Request $request)
    {
        $perPage = $request->per_page;
        if(!$perPage) {
            $perPage = 30;
        }
        $getTaxFeeRates = $this->taxFeeRateRepository->model()->with('productGroup')->orderByDesc('id')->paginate($perPage);
        $this->setTransformer(new TaxFeeRateTransformer(true));
        return $this->responsePaginatedCollection($getTaxFeeRates, 200);
    }

    public function store(TaxFeeRateStoreRequest $request)
    {
        $data = $request->all();
        try {
            $taxFeeRate = $this->taxFeeRateRepository->create($data);
            return $this->successResponse(['taxFeeRate' => $taxFeeRate, 'message' => trans('Thêm tỷ lệ thuê phí !')], 200);
        } catch (\Exception $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function update(TaxFeeRateUpdateRequest $request, $id)
    {
        $data = $request->except('code');
        $entry = $this->taxFeeRateRepository->find($id);
        if (!$entry) {
            return $this->errorsResponse(['id' => trans('Không tồn tại tỷ lệ thuế phí !')], 422);
        }
        try {
            $taxFeeRate = $entry->update($data);
            return $this->successResponse(['taxFeeRate' => $taxFeeRate, 'message' => trans('Sửa tỷ lệ thuế phí thành công !')], 200);
        } catch (\Exception $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $entry = $this->taxFeeRateRepository->find($id);
        if(!$entry){
            return $this->errorsResponse(["id" => trans("Không tồn tại tỷ lệ thuế phí !")], 404);
        }
        try {
            $entry->forceDelete($id);
            return $this->successResponse(['taxFeeRate' => $entry,'message' => trans('Xóa dữ liệu thành công!')], 200);
        } catch (\Exception $e) {
            return $this->errorResponse(['id' => $e->getMessage()]);
        }
    }
}
