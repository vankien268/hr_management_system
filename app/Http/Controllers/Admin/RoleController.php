<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Enums\SystemPermissionEnum;
use App\Http\Controllers\Controller;
use App\Transformers\RoleTransformer;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;

use function App\Helper\check_user_permission;
use App\Repositories\Interfaces\IRoleRepository;

class RoleController extends Controller
{
    protected $roleRepository;
    public function __construct(IRoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->setTransformer(new RoleTransformer());
    }

    public function index()
    {
        $breadcrumbs = [
            [
                'link' => null,
                'text' => __('Quản lý nhóm quyền')
            ],
        ];
        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_DECLARE_ROLE);

        $viewRole = check_user_permission(SystemPermissionEnum::VIEW_LIST_DECLARE_ROLE);
        if(!$viewRole){

            return view('page-errors.403');
        }
        $data = [
            'pageName' =>  trans('Quản lý nhóm quyền'),
            'breadcrumbs' => $breadcrumbs,
            'btnAdd' => $btnAdd
        ];
        return view('admin.roles.index')->with($data);
    }

    public function getAllRoles(Request $request)
    {
        $perPage = $request->per_page;
        if(!$perPage) {
            $perPage = 30;
        }
        if($request->getAll) {
            return $this->successResponse(['roles' => $this->roleRepository->model()->orderBy('name')->get()], 200);
        }
        $getRoles = $this->roleRepository->model()->with(['roleSystemFunctions', 'roleUsers'])->orderByDesc('id')->paginate($perPage);
        $this->setTransformer(new RoleTransformer(true));
        return $this->responsePaginatedCollection($getRoles, 200);
    }

    public function store(RoleStoreRequest $request)
    {
        if(! check_user_permission(SystemPermissionEnum::ADD_DECLARE_ROLE)) {
            return $this->errorsResponse(['message' => trans('Bạn không có quyền thêm nhóm quyền.')], 403);
        }

        $data = $request->all();
        try {
            $role = $this->roleRepository->create($data);
            return $this->successResponse(['role' => $role, 'message' => trans('Thêm thành công !')], 200);
        } catch (\Exception $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function update(RoleUpdateRequest $request, $id)
    {
        if(! check_user_permission(SystemPermissionEnum::EDIT_DECLARE_ROLE)) {
            return $this->errorsResponse(['message' => trans('Bạn không có quyền sửa nhóm quyền.')], 403);
        }
        $data = $request->except('code');
        $entry = $this->roleRepository->find($id);
        if (!$entry) {
            return $this->errorsResponse(['id' => trans('Không tồn tại !')], 422);
        }
        try {
            $role = $entry->update($data);
            return $this->successResponse(['role' => $role, 'message' => trans('Sửa thành công !')], 200);
        } catch (\Exception $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        if(! check_user_permission(SystemPermissionEnum::DELETE_DECLARE_ROLE)) {
            return $this->errorsResponse(['message' => trans('Bạn không xóa quyền thêm nhóm quyền.')], 403);
        }

        $entry = $this->roleRepository->find($id);

        if(!$entry){
            return $this->errorsResponse(["id" => trans("Không tồn tại !")], 404);
        }

        if($entry->id == 1) {
            return $this->errorsResponse(["message" => trans("Không thể xóa nhóm quyền quản trị !")], 403);
        }
        try {
            $this->roleRepository->destroy($id);
            return $this->successResponse(['role' => $entry,'message' => trans('Xóa dữ liệu thành công!')], 200);
        } catch (\Exception $e) {
            return $this->errorResponse(['id' => $e->getMessage()]);
        }
    }
}
