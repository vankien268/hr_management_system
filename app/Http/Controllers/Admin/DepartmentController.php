<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Enums\SystemPermissionEnum;
use App\Http\Controllers\Controller;
use App\Repositories\DepartmentRepository;
use App\Transformers\DepartmentTransformer;
use App\Http\Requests\DepartmentStoreRequest;

use App\Http\Requests\DepartmentUpdateRequest;
use function App\Helper\check_user_permission;

class DepartmentController extends Controller
{
    protected $departmentRepository;
    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function index()
    {
        $breadcrumbs = [
            [
                'link' => null,
                'text' => __('Quản lý bộ phận')
            ],
        ];
        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_DEPARTMENT);
        $data = [
            'pageName' =>  trans('Quản lý bộ phận'),
            'breadcrumbs' => $breadcrumbs,
            'btnAdd' => $btnAdd,
        ];
        return view('admin.departments.index')->with($data);
    }

   public function getAllDepartments()
   {
       $getAllDepartment = $this->departmentRepository->model()->with(['childrenDepartment', 'user'])->orderByDesc('id')->get()->map(function($item) {
           $item->convertStatus =  $item->status? trans('Sử dụng') : trans('Ngừng sử dụng');
           $item->is_delete_permission = check_user_permission(SystemPermissionEnum::DELETE_DEPARTMENT);
           $item->isEdit = check_user_permission(SystemPermissionEnum::EDIT_DEPARTMENT);
           $item->isDelete = true;
           if($item->childrenDepartment->count()
             || $item->user
           ) {
               $item->isDelete = false;
           }
           return $item;
       })->toTree();
       return $this->successResponse(['getAllDepartment' => $getAllDepartment], 200);
   }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentStoreRequest $request)
    {

        if(! check_user_permission(SystemPermissionEnum::ADD_DEPARTMENT)) {
            return $this->errorsResponse(['message' => trans('Bạn không có quyền thêm bộ phận.')], 403);
        }

        $data = $request->all();
        try {
            $department = $this->departmentRepository->create($data);
            return $this->successResponse(['department' => $department, 'message' => trans('Thêm bộ phận thành công !')], 200);
        }catch (\Exception $th) {
            return $this->errorResponse($th->getMessage());
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentUpdateRequest $request, $id)
    {
        if(! check_user_permission(SystemPermissionEnum::EDIT_DEPARTMENT)) {
            return $this->errorsResponse(['message' => trans('Bạn không có quyền sửa bộ phận.')], 403);
        }

        $data = $request->except('code');
        $entry = $this->departmentRepository->find($id);
        if(!$entry) {
            return $this->errorsResponse(['id' => trans('Không tồn tại bộ phận !')], 422);
        }
        try {
            $department = $entry->update($data);
            return $this->successResponse(['department' => $department, 'message' => trans('Sửa bộ phận thành công !')], 200);
        }catch (\Exception $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {

        if(! check_user_permission(SystemPermissionEnum::DELETE_DEPARTMENT)) {
            return $this->errorsResponse(['message' => trans('Bạn không có quyền xóa bộ phận.')], 403);
        }

        $entry = $this->departmentRepository->find($id);
        if(!$entry){
            return $this->errorsResponse(["id" => trans("Không tồn tại bộ phận !")], 404);
        }
        try {
            if($entry->childrenDepartment->count() || $entry->users->count()) {
                return $this->errorsResponse(['message' => trans('Không thể xóa.Bộ phận này đang có dữ liệu con!')], 422);
            }
            $entry->forceDelete();
            return $this->successResponse(['department' => $entry,'message' => trans('Xóa dữ liệu thành công!')], 200);
        } catch (\Exception $e) {
            return $this->errorResponse(['id' => $e->getMessage()]);
        }
    }
}
