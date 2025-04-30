<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SystemPermissionEnum;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\IRoleRepository;
use App\Repositories\Interfaces\IRoleSystemFunctionRepository;
use App\Repositories\Interfaces\ISystemFunctionRepository;
use App\Transformers\SystemFunctionTransformer;

use function App\Helper\check_user_permission;

class SystemFuntionController extends Controller
{
    protected $manager;
    protected $systemFunctionRepository;
    protected $roleRepository;
    protected $roleSystemFunctionRepository;
    protected $transformer;
    public function __construct(Manager $manager, ISystemFunctionRepository $systemFunctionRepository, IRoleRepository $roleRepository, IRoleSystemFunctionRepository $roleSystemFunctionRepository, SystemFunctionTransformer $transformer)
    {
        $this->systemFunctionRepository = $systemFunctionRepository;
        $this->roleRepository = $roleRepository;
        $this->roleSystemFunctionRepository = $roleSystemFunctionRepository;
        $this->manager = $manager;
        $this->transformer = $transformer;
        $this->setTransformer($transformer);
    }

    /**
     * Summary of view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function view()
    {
        $funs = $this->systemFunctionRepository->model()->withTrashed()->get();
        $funsMenu = $this->systemFunctionRepository->model()->withTrashed()->where('is_role_menu', 1)->get();

        // request()->merge(['load_relation' => false]);
        $asignRole = check_user_permission(SystemPermissionEnum::EDIT_DECLARE_ROLE);
        if(!$asignRole){
            return view('page-errors.403');
        }
        return view(
            'admin.roles.system_function',
            [
                'pageName' =>  trans('Gán quyền'),
                'funcs' => $funs->toArray(),
                'funcs_menu' => $funsMenu->toArray()
            ]
        );
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $req = $request->all();
        $entries = $this->systemFunctionRepository->model()->withDepth()->where('type', 0)->where('id', '!=', SystemPermissionEnum::SYSTEM_ADMIN)->orderBy('_lft', 'asc')->get(); //
        $roles = $this->roleRepository->findWithRelationships($req['role_id'] ?? 1, ['roleSystemFunctions']);
        if(!$roles){
            return $this->errorsResponse(['id' => trans('Nhóm quyền không tồn tại.')], 404);
        }
        return $this->responseCollection($entries, 200,
        [
            'list_role' => $roles->roleSystemFunctions->count() > 0 ? $roles->roleSystemFunctions->pluck('system_function_id')->toArray() : [],
            'role_name' => $roles->name
        ],
        [
            'paginate' => false
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $req = $request->all();
        $roles = $this->roleRepository->findWithRelationships($id, ['roleSystemFunctions']);
        if(!$roles){
            return $this->errorsResponse(['id' => trans('Nhóm quyền không tồn tại.')], 404);
        }
        $oldIds = $roles->roleSystemFunctions->count() > 0 ? $roles->roleSystemFunctions->pluck('system_function_id')->toArray() : [];
        $roleIds = array_unique($req['list_role']);
        // dd($roleIds);
        foreach ($roleIds as $i) {
            $index = array_search($i, $oldIds);
            if($index !== false){
                unset($oldIds[$index]);
            }
            try {
                $roles->roleSystemFunctions()->create(['system_function_id' => $i]);
            } catch (\Throwable $th) {
                continue;
            }
        }
        $this->roleSystemFunctionRepository->model()->where('role_id', $id)->whereIn('system_function_id', $oldIds)->forceDelete();
        $entries = $this->systemFunctionRepository->model()->withDepth()->get();
        return $this->responseCollection($entries, 200, ['list_role' => $roles->fresh()->roleSystemFunctions->pluck('system_function_id')->toArray()], ['paginate' => false]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
