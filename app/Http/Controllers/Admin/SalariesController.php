<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SystemPermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentStoreRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use App\Http\Requests\salaryStoreRequest;
use App\Http\Requests\salaryUpdateRequest;
use App\Repositories\DepartmentRepository;
use App\Repositories\Interfaces\ISalariesRepository;
use App\Transformers\SalaryTransformer;
use Illuminate\Http\Request;
use function App\Helper\check_user_permission;

class SalariesController extends Controller
{
    /**
     * @var ISalariesRepository
     */
    private $salariesRepository;

    public function __construct(ISalariesRepository $salariesRepository)
    {
        $this->salariesRepository = $salariesRepository;
    }

    public function index()
    {
        $breadcrumbs = [
            [
                'link' => null,
                'text' => __('Quản lý tiền lương')
            ],
        ];
//        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_DEPARTMENT);
        $data = [
            'pageName' =>  trans('Quản lý tiền lương'),
            'breadcrumbs' => $breadcrumbs,
            'btnAdd' => true,
        ];
        return view('admin.salaries.index')->with($data);
    }

    public function salaryContacts()
    {
        $breadcrumbs = [
            [
                'link' => null,
                'text' => __('Danh sách bảng lương nhân viên')
            ],
        ];
//        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_DEPARTMENT);
        $data = [
            'pageName' =>  trans('Danh sách bảng lương nhân viên'),
            'breadcrumbs' => $breadcrumbs,
            'btnAdd' => true,
        ];
        return view('admin.salaries.salary-contacts.index')->with($data);
    }

    public function getAllSalaries(Request $request)
    {
        $monthYear = explode('-', $request->month);

        $month = $monthYear[1] ?? null;
        $year = $monthYear[0] ?? null;

        $salaries = $this->salariesRepository->model()->where(function ($query) use (
            $month,
            $year
        ) {
            if ($month) {
                $query->where('month', $month);
            }

            if ($year) {
                $query->where('year', $year);
            }
        })->orderByDesc('id')->get();
        $this->setTransformer(new SalaryTransformer());

        return $this->responseCollection(
            $salaries,
            200
        );
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
    public function store(salaryStoreRequest $request)
    {
        $data = $request->all();
        $departmentIds = array_column($data['department_ids'], 'id');
        $departmentIds = implode(',', $departmentIds);

        $departmentNames = array_column($data['department_ids'], 'name');
        $departmentNames =implode(',', $departmentNames);;

        $attributes = [
          'name' =>   $data['name'],
          'month' =>   $data['month'],
          'year' =>   $data['year'],
          'department_ids' =>  $departmentIds,
          'department_names' =>  $departmentNames,
        ];

        try {
            $salary = $this->salariesRepository->create($attributes);
            return $this->successResponse(['salaries' => $salary, 'message' => trans('Thêm bảng lương thành công!')], 200);
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
    public function update(salaryUpdateRequest $request, $id)
    {
        $entry = $this->salariesRepository->find($id);

        $data = $request->all();
        $departmentIds = array_column($data['department_ids'], 'id');
        $departmentIds = implode(',', $departmentIds);

        $departmentNames = array_column($data['department_ids'], 'name');
        $departmentNames =implode(',', $departmentNames);;

        $attributes = [
            'name' =>   $data['name'],
            'month' =>   $data['month'],
            'year' =>   $data['year'],
            'department_ids' =>  $departmentIds,
            'department_names' =>  $departmentNames,
        ];

        if(!$entry) {
            return $this->errorsResponse(['id' => trans('Không tồn tại bảng lương !')], 422);
        }

        try {
            $department = $entry->update($attributes);
            return $this->successResponse(['department' => $department, 'message' => trans('Sửa bảng lương thành công!')], 200);
        }catch (\Exception $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $entry = $this->salariesRepository->find($id);
        if(!$entry){
            return $this->errorsResponse(['id' => trans('Không tồn tại bảng lương !')], 422);
        }
        try {
            $entry->delete();
            return $this->successResponse(['department' => $entry,'message' => trans('Xóa bảng lương thành công!')], 200);
        } catch (\Exception $e) {
            return $this->errorResponse(['id' => $e->getMessage()]);
        }
    }
}
