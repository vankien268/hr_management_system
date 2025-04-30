<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProjectPermissionEnum;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Enums\StatusTypeEnum;
use App\Enums\SystemPermissionEnum;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuoteRequest;
use App\Http\Requests\StoreQuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;
use App\Models\ProjectFunctionUser;
use App\Transformers\UserTransformer;
use App\Transformers\QuoteTransformer;
use App\Transformers\ProductTransformer;
use App\Transformers\ContractTransformer;
use App\Transformers\CustomerTransformer;
use App\Transformers\ContractTypeTransformer;
use App\Transformers\SystemStatusTransformer;
use App\Repositories\Interfaces\IUserRepository;
use App\Repositories\Interfaces\IQuoteRepository;
use App\Transformers\ProjectManagementTransformer;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\Interfaces\ICustomerRepository;
use App\Repositories\Interfaces\IContractTypeRepository;
use App\Repositories\Interfaces\IQuoteProductRepository;
use App\Repositories\Interfaces\IProjectManagementRepository;
use PDF;

use function App\Helper\check_user_has_permission_in_project;
use function App\Helper\check_user_permission;

class QuoteController extends Controller
{
    protected $manager;
    protected $customerRepository;
    protected $projectRepository;
    protected $userRepository;
    protected $quoteRepository;
    protected $quoteProductRepository;
    protected $contractTypeRepository;
    protected $productRepository;
    protected $transformer;
    public function __construct(
        Manager $manager,
        IUserRepository $userRepository,
        IProjectManagementRepository $projectRepository,
        IQuoteRepository $quoteRepository,
        IQuoteProductRepository $quoteProductRepository,
        IContractTypeRepository $contractTypeRepository,
        ICustomerRepository $customerRepository,
        IProductRepository $productRepository,

    ) {
        $this->quoteRepository = $quoteRepository;
        $this->quoteProductRepository = $quoteProductRepository;
        $this->projectRepository = $projectRepository;
        $this->customerRepository = $customerRepository;
        $this->contractTypeRepository = $contractTypeRepository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->manager = $manager;
        $transformer = new QuoteTransformer(['is_delete' => true]);
        $this->transformer = $transformer;
        $this->setTransformer($transformer);
    }

    /**
     * Summary of view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function view()
    {
        request()->merge(['type' => StatusTypeEnum::CONTRACT, 'using' => true]);
        $contractTypes = $this->contractTypeRepository->getData()->get();
        $products = $this->productRepository->getData()->get();
        $canExistsPermissionAddQuote = check_user_permission(SystemPermissionEnum::ADD_SYSTEM_PRICE_QUOTE);
        $canExistsPermissionSystemEditQuote = check_user_permission(SystemPermissionEnum::EDIT_SYSTEM_PRICE_QUOTE);
        $canExistsPermissionSystemDeleteQuote = check_user_permission(SystemPermissionEnum::DELETE_SYSTEM_PRICE_QUOTE);
        if (!$canExistsPermissionAddQuote) {
            // $getAllPermisisonProject = $this->quoteRepository->model()->userPermissions();
            // foreach ($getAllPermisisonProject as $permissions) {
            //     if (in_array(ProjectPermissionEnum::ADD_PRICE_QUOTES, $permissions)) {
            //         $canExistsPermissionAddQuote = true;
            //     }
            // }
            $canExistsPermissionAddQuote = check_user_has_permission_in_project(SystemPermissionEnum::ADD_PRICE_QUOTES);
        }
        $approve = check_user_permission(SystemPermissionEnum::APPROVE_PRICE_QUOTE);
        return view(
            'admin.quote.quote',
            [
                'pageName' => trans("Báo giá sản phẩm"),
                'contractTypes' => $this->responseJsonData($contractTypes, new ContractTypeTransformer()),
                'products' => $this->responseJsonData($products, new ProductTransformer(true)),
                'canExistsPermissionAddQuote' =>  $canExistsPermissionAddQuote,
                'canExistsPermissionSystemEditQuote' =>  $canExistsPermissionSystemEditQuote,
                'canExistsPermissionSystemDeleteQuote' =>  $canExistsPermissionSystemDeleteQuote,
                'approvePermission' => $approve,
            ]
        );
    }
    /**
     * Display a listing of the resource.
     */
    public function index(QuoteRequest $request)
    {
        $entries = $this->quoteRepository->getData()->latest('id')->paginate(request('per_page') ?? 30);
        $checkPermissionApprove = check_user_permission(SystemPermissionEnum::APPROVE_PRICE_QUOTE);
        $this->setTransformer(new QuoteTransformer(['is_delete' => true, 'approve_permission' => $checkPermissionApprove]));
        return $this->responsePaginatedCollection($entries);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuoteRequest $request)
    {
        $storeData = $this->quoteRepository->formatDataStore($request->all());
        $checkPermissionAddIntoProject = $this->quoteRepository->model()->checkUserHasProjectPermission(ProjectPermissionEnum::ADD_PRICE_QUOTES, $request->project_id)
        || check_user_permission(SystemPermissionEnum::ADD_SYSTEM_PRICE_QUOTE);
        if (!$checkPermissionAddIntoProject) {
            return $this->errorsResponse(['project_id' => [trans('Không có quyền thêm báo giá cho dự án đã chọn.')]], 422);
        }
        DB::beginTransaction();
        try {
            $entry = $this->quoteRepository->create($storeData);
            foreach ($storeData['details']['data'] as $product) {
                $product = array_merge($this->quoteProductRepository->formatDataStore($product), [
                    'quote_id' => $entry->id,
                ]);
                $this->quoteProductRepository->create($product);
            }
            $this->quoteRepository->findUserHasPermissionViewProjectAndCreate($request->project_id, $request->approve_id);
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
    public function update(UpdateQuoteRequest $request, string $id)
    {
        // $checkPermissionUpdate = in_array($request->project_id, $this->quoteRepository->model()->listProjectOfUser());
        // if(!$checkPermissionUpdate) {
        //     return $this->errorResponse(trans('Không có quyền sửa báo giá cho dự án đã chọn.'), 422);
        // }
        $entry = $this->quoteRepository->findWithRelationships($id, ['details']);
        if (!$entry) {
            return $this->errorsResponse(['id' => trans('Dữ liệu tìm kiếm không tồn tại.')], 404);
        }
        $dataUpdate = $this->quoteRepository->formatDataUpdate($request->all(), $entry);
        // $checkPermissionUpdateIntoProject = $this->quoteRepository->model()->checkUserHasProjectPermission(ProjectPermissionEnum::EDIT_PRICE_QUOTES, $request->project_id)
        // || check_user_permission(SystemPermissionEnum::EDIT_SYSTEM_PRICE_QUOTE);
        // if (!$checkPermissionUpdateIntoProject) {
        //     return $this->errorsResponse(['project_id' => [trans('Không có quyền sửa báo giá cho dự án đã chọn.')]], 422);
        // }
        DB::beginTransaction();
        try {
            $entry = $this->quoteRepository->update($id, $dataUpdate);
            foreach ($dataUpdate['details']['data'] as $product) {
                if ($product['id'] != null) {
                    $this->quoteProductRepository->update($product['id'], $this->quoteProductRepository->formatDataUpdate($product));
                    continue;
                }
                $product = array_merge($this->quoteProductRepository->formatDataStore($product), [
                    'quote_id' => $entry->id,
                ]);
                $this->quoteProductRepository->create($product);
            }
            if (isset($dataUpdate['list_product_delete'])) {
                $this->quoteProductRepository->destroy($dataUpdate['list_product_delete']);
            }
            $this->quoteRepository->findUserHasPermissionViewProjectAndCreate($request->project_id, $request->approve_id);
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
        $entry = $this->quoteRepository->findWithRelationships($id, ['details']);
        if (!$entry) {
            return $this->errorsResponse(['id' => trans('Dữ liệu tìm kiếm không tồn tại.')], 404);
        }
        if (!check_user_permission(SystemPermissionEnum::DELETE_PRICE_QUOTES, $entry->project_id) && !check_user_permission(SystemPermissionEnum::DELETE_SYSTEM_PRICE_QUOTE)) {
            return $this->errorResponse(trans('Không có quyền xóa báo giá cho dự án đã chọn.'), 422);
        }
        DB::beginTransaction();
        try {
            $delete = $this->quoteRepository->destroy($id);
            if ($delete === false) {
                return $this->errorsResponse(['id' => trans('Báo giá đã được duyệt, không thể xóa.')], 422);
            }
            DB::commit();
            return $this->responseOne($entry);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorsResponse(['id' => $th->getMessage()], 422);
        }
    }

    public function getListStatus($status = null)
    {
        $requestData = request()->all();
        $status = isset($requestData['status']) ? $requestData['status'] : 0;
        return $this->successResponse(['data' => $this->quoteRepository->model()->getListStatus($status)]);
    }

    public function exportFilePdf($id)
    {
        $entries = $this->quoteRepository->getData()->findOrFail($id);
        if (!$entries) {
            return $this->errorsResponse(['message' => trans('Không tồn tại báo giá sản phẩm.')], 422);
        }
        // dd($entries->toArray());
        $view = view('admin.pdf.quote-export-pdf', ['data' => $entries->toArray()]);
        $pdf = PDF::loadHTML($view, "UTF-8");
        return $pdf->download('ProjectQuote.pdf');
    }

    public function approveQuote(Request $request, String $id)
    {
        $entry = $this->quoteRepository->findWithRelationships($id, ['details', 'contractType', 'project', 'customer', 'approveBy', 'details.product.unit']);
        if (!$entry) {
            return $this->errorsResponse(['id' => trans('Dữ liệu tìm kiếm không tồn tại.')], 404);
        }
        if (!check_user_permission(SystemPermissionEnum::APPROVE_PRICE_QUOTE)) {
            return $this->errorResponse(trans('Không có quyền duyệt báo giá cho dự án đã chọn.'), 422);
        }
        DB::beginTransaction();
        try {
            $requestData = $request->all();
            $entry->status = $requestData['status'];
            $entry->save();
            DB::commit();
            $this->setTransformer(new QuoteTransformer(['is_delete' => true, 'approve_permission' => true]));
            return $this->responseOne($entry);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorsResponse(['id' => $th->getMessage()], 422);
        }
    }
}
