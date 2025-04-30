<?php

namespace App\Http\Controllers\Admin;

use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Enums\TaxFeeTypeEnum;
use Illuminate\Support\Facades\DB;
use App\Enums\SystemPermissionEnum;
use App\Http\Controllers\Controller;
use App\Transformers\TaxFeeRateTransformer;
use App\Transformers\ProductGroupTransformer;
use function App\Helper\check_user_permission;
use App\Http\Requests\StoreProductGroupRequest;
use App\Http\Requests\UpdateProductGroupRequest;

use App\Repositories\Interfaces\ITaxFeeRateRepository;
use App\Repositories\Interfaces\IProductGroupRepository;

class ProductGroupController extends Controller
{
    protected $manager;
    protected $productGroupRepository;
    protected $taxFeeRateRepository;
    protected $transformer;
    public function __construct(Manager $manager, IProductGroupRepository $productGroupRepository, ITaxFeeRateRepository $taxFeeRateRepository)
    {
        $this->productGroupRepository = $productGroupRepository;
        $this->taxFeeRateRepository = $taxFeeRateRepository;
        $this->manager = $manager;
        $transformer = new ProductGroupTransformer(['is_delete' => request('is_delete')]);
        $this->transformer = $transformer;
        $this->setTransformer($transformer);
    }

    /**
     * Summary of view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function view()
    {
        request()->merge(['load_relation' => false]);
        $productGroup = $this->productGroupRepository->getListData();
        $taxRate = $this->taxFeeRateRepository->getListSelect(TaxFeeTypeEnum::TAX)->get();
        $feeRate = $this->taxFeeRateRepository->getListSelect(TaxFeeTypeEnum::FEE)->get();
        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_PRODUCT_GROUP);
        return view(
            'admin.products.product_group',
            [
                'pageName' => trans("Danh sách nhóm sản phẩm"),
                'productGroup' => $this->responseJsonData($productGroup, new ProductGroupTransformer()),
                'taxRate' => $this->responseJsonData($taxRate, new TaxFeeRateTransformer()),
                'feeRate' => $this->responseJsonData($feeRate, new TaxFeeRateTransformer()),
                'btnAdd' => $btnAdd,
            ]
        );
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productGroup = $this->productGroupRepository->getListData();
        return $this->responseCollection($productGroup, 200, [], ['paginate' => false]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductGroupRequest $request)
    {
        $storeData = $request->all();
        DB::beginTransaction();
        try {
            $entry = $this->productGroupRepository->create($storeData);
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
    public function update(UpdateProductGroupRequest $request, string $id)
    {
        $entry = $this->productGroupRepository->find($id);
        if (!$entry) {
            return $this->errorsResponse(['id' => trans('Dữ liệu tìm kiếm không tồn tại.')], 404);
        }
        DB::beginTransaction();
        try {
            $updateData = $request->all();
            $entry = $this->productGroupRepository->update($id, $updateData);
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
        $entry = $this->productGroupRepository->find($id);
        if(!$entry){
            return $this->errorsResponse(['id' => trans('Dữ liệu tìm kiếm không tồn tại.')], 404);
        }
        DB::beginTransaction();
        try {
            $delete = $this->productGroupRepository->destroy($id);
            if($delete === false){
                return $this->errorsResponse(['id' => trans('Không thể xóa đo đã phát sinh dữ liệu liên quan.')], 422);
            }
            DB::commit();
            return $this->responseOne($entry);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorsResponse(['id' => $th->getMessage()], 422);
        }
    }

    /**
     * TODO:: di chuyển record
     * @return void
     */
    public function moveUp($id)
    {
        $entry = $this->productGroupRepository->find($id);
        if (!$entry) {
            return $this->errorsResponse(['id' => trans('Dữ liệu tìm kiếm không tồn tại.')], 404);
        }
        DB::beginTransaction();
        try {
            $entry->up();
            DB::commit();
            return $this->responseOne($entry);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorsResponse(['id' => $th->getMessage()], 422);
        }
    }
    /**
     * TODO:: di chuyển record
     * @return void
     */
    public function moveDown($id)
    {
        $entry = $this->productGroupRepository->find($id);
        if (!$entry) {
            return $this->errorsResponse(['id' => trans('Dữ liệu tìm kiếm không tồn tại.')], 404);
        }
        DB::beginTransaction();
        try {
            $entry->down();
            DB::commit();
            return $this->responseOne($entry);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorsResponse(['id' => $th->getMessage()], 422);
        }
    }
}
