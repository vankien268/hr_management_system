<?php

namespace App\Http\Controllers\Admin;

use App\Models\Unit;
use App\Models\ProductGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Enums\SystemPermissionEnum;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Transformers\ProductTransformer;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Transformers\ProductGroupTransformer;

use function App\Helper\check_user_permission;
use App\Repositories\Interfaces\IProductRepository;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(IProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $breadcrums = [
            'text' => trans('Quản lý sản phẩm')
        ];
        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_PRODUCT);
        $data = [
            'breadcrums' => $breadcrums,
            'pageName' => trans('Quản lý sản phẩm'),
            'btnAdd' => $btnAdd,
        ];
        return view('admin.products.index')->with($data);
    }

    public function getAllProducts(Request $request)
    {
        $nameOrCode = $request->nameOrCode;
        $productGroupId = $request->product_group_id;
        $products = $this->productRepository->model()->with(['unit', 'productGroup', 'productGroup.taxRate', 'productGroup.feeRate'])
            ->where(function ($query) use ($nameOrCode, $productGroupId) {
                if ($nameOrCode) {
                    $query->where('name', 'like', '%' . $nameOrCode . '%')->orWhere('code', 'like', '%' . $nameOrCode . '%');
                }
                if ($productGroupId) {
                    $query->Where('product_group_id', $productGroupId);
                }
            })
            ->orderByDesc('id')->get();

        $productGroups = ProductGroup::status()
            ->with(['taxRate', 'feeRate'])->orderBy('_lft')->withDepth()
            ->get();

        $this->setTransformer(new ProductTransformer(true, true));
        $productGroups = fractal($productGroups, new ProductGroupTransformer(['taxRate', 'feeRate']));
        $units = Unit::status()->select(['id', 'name'])->get();
        return $this->responseCollection(
            $products,
            200,
            [
                'productGroups' => $productGroups->toArray(),
                'units' => $units->toArray()
            ],
            ['paginate' => false]
        );
    }

    public function store(ProductStoreRequest $request)
    {
        $data = $request->all();
        DB::beginTransaction();
        try {
            if ($request->hasFile('image_link')) {
                $file = $request->file('image_link');
                $imageName = time() . '.' . $file->extension();
                Storage::disk('public')->put('/product_images/' . $imageName, $file->getContent());
                $data['image_link'] = 'product_images/' . $imageName;
            }
            if ($request->edit_price != 'false') {
                $data['edit_price'] = 1;
            } else {
                $data['edit_price'] = 0;
            }
            $this->productRepository->create($data);
            DB::commit();
            return $this->successResponse(['message' => trans('Thêm sản phẩm thành công !')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function update($id, ProductUpdateRequest $request)
    {
        $data = $request->except('code');
        $product = $this->productRepository->find($id);
        if (!$product) {
            return $this->errorsResponse(['message' => trans('Sản phẩm không tồn tại.')], 422);
        }
        $product->load(['unit', 'productGroup']);

        DB::beginTransaction();
        try {
            if ($request->hasFile('image_link')) {
                // delete ảnh cũ
                $imageLink = $product->image_link;
                if ($imageLink) {
                    $imageOldInStorage = substr($imageLink, strrpos($imageLink, '/') + 1);
                    //  dd( $imageOldInStorage, $imageLink);
                    if (Storage::disk('public')->exists('/product_images/' . $imageOldInStorage)) {
                        unlink(storage_path('app/public/product_images/' . $imageOldInStorage));
                    }
                }

                $file = $request->file('image_link');
                $imageName = time() . '.' . $file->extension();
                Storage::disk('public')->put('/product_images/' . $imageName, $file->getContent());
                $data['image_link'] = 'product_images/' . $imageName;
            }
            if ($request->edit_price != 'false') {
                $data['edit_price'] = 1;
            } else {
                $data['edit_price'] = 0;
            }
            $product->update($data);
            DB::commit();
            return $this->successResponse(['product' => $product->refresh(), 'message' => trans('Sửa sản phẩm thành công !')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy($id)
    {
        $product = $this->productRepository->find($id);
        if (!$product) {
            return $this->errorsResponse(trans('Không tồn tại sản phẩm'), 422);
        }
        DB::beginTransaction();
        try {
            $product->forceDelete();
            DB::commit();
            return $this->successResponse(['message' => trans('Xóa sản phẩm thành công !')]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return $this->errorResponse($throwable->getMessage());
        }
    }
}
