<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Enums\SystemPermissionEnum;
use App\Http\Controllers\Controller;
use App\Transformers\ProjectTypeTransformer;
use App\Http\Requests\ProjectTypeStoreRequest;
use function App\Helper\check_user_permission;

use App\Http\Requests\ProjectTypeUpdateRequest;
use App\Repositories\Interfaces\IProjectTypeRepository;

class ProjectTypeController extends Controller
{
    protected $projectTypeRepository;
    public function __construct(IProjectTypeRepository $projectTypeRepository)
    {
        $this->projectTypeRepository = $projectTypeRepository;
        $this->setTransformer(new ProjectTypeTransformer(true));
    }

    public function index()
    {
        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_PROJECT_TYPE);
        $breadcrumbs = [
            [
                'link' => null,
                'text' => __('Quản lý loại dự án')
            ],
        ];
        $data = [
            'pageName' => trans('Quản lý loại dự án'),
            'breadcrumbs' => $breadcrumbs,
            'btnAdd' => $btnAdd
        ];
        return view('admin.project-types.index')->with($data);
    }
    public function getProjectTypes(Request $request)
    {
        $perPage = $request->per_page;
        if (!$perPage) {
            $perPage = 30;
        }
        $projectTypes = $this->projectTypeRepository->getAllData($request);
        if ($request->getAll) {
            return $this->responseCollection($projectTypes->orderBy('name')->get(), 200, [], ['paginate' => false]);
        }
        return $this->responsePaginatedCollection($projectTypes->orderByDesc('id')->paginate($perPage), 200);
    }
    public function store(ProjectTypeStoreRequest $request)
    {
        $data = $request->all();
        try {
            $projectType = $this->projectTypeRepository->create($data);
            return $this->successResponse(['projectType' => $projectType, 'message' => trans('Thêm loại dự án thành công !')], 200);
        } catch (\Exception $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function update(ProjectTypeUpdateRequest $request, $id)
    {
        $data = $request->except('code');
        $entry = $this->projectTypeRepository->find($id);
        if (!$entry) {
            return $this->errorsResponse(['id' => trans('Không tồn tại loại dự án !')], 422);
        }
        try {
            $projectType = $entry->update($data);
            return $this->successResponse(['projectType' => $projectType, 'message' => trans('Sửa loại dự án thành công !')], 200);
        } catch (\Exception $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $entry = $this->projectTypeRepository->find($id);
        if (!$entry) {
            return $this->errorsResponse(["id" => trans("Không tồn tại loại dự án !")], 404);
        }
        try {
            $this->projectTypeRepository->destroy($id);
            return $this->successResponse(['projectType' => $entry, 'message' => trans('Xóa dữ liệu thành công!')], 200);
        } catch (\Exception $e) {
            return $this->errorResponse(['id' => $e->getMessage()]);
        }
    }
}
