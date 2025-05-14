<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SystemPermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\InternalFundUpdateRequest;
use App\Http\Requests\SalaryGradeUpdateRequest;
use App\Models\InitValue;
use App\Repositories\Interfaces\IInitValueRepository;
use App\Repositories\Interfaces\ISalaryGradeRepository;
use App\Transformers\SalaryGradeTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function App\Helper\check_user_permission;
use function Nette\Utils\first;

class SalaryGradeController extends Controller
{

    /**
     * @var ISalaryGradeRepository
     */
    private $salaryGradeRepository;

    public function __construct(ISalaryGradeRepository $salaryGradeRepository)
    {

        $this->salaryGradeRepository = $salaryGradeRepository;
    }

    public function index()
    {
        $breadcrums = [
            'text' => trans('Khai báo thang bảng lương')
        ];
//        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_PRODUCT);
        $data = [
            'breadcrums' => $breadcrums,
            'pageName' => trans('Khai báo thang bảng lương'),
            'btnAdd' => true,
        ];
        return view('admin.salary-grades.index')->with($data);
    }

    public function getInfoSalaryGrades(Request $request)
    {
        $salaryGrades = $this->salaryGradeRepository->model()
            ->where('valid', 1)
            ->get();

        $this->setTransformer(new SalaryGradeTransformer());

        return $this->responseCollection(
            $salaryGrades,
            200
        );
    }

    public function update(SalaryGradeUpdateRequest $request)
    {
        $salaryGrades = $request->salary_grades;
        $removeSalaryGrades = $request->remove_salary_grade_ids;

        DB::beginTransaction();
        try {

            if($salaryGrades) {
                foreach ($salaryGrades as $item) {
                    $salaryGrade = $this->salaryGradeRepository->model()
                        ->where('valid', 1)
                        ->where('id', $item['id'] ?? 0)
                        ->first();

                    $item['attributes'] = $item['attributes'] ? json_encode($item['attributes']) : null;

                    if($salaryGrade) {
                        $salaryGrade->update($item);
                        continue;
                    }

                    unset($item['id']);

                    $this->salaryGradeRepository->create($item);
                }
            }

            if($removeSalaryGrades) {
                $this->salaryGradeRepository->model()
                    ->whereIn('id', $removeSalaryGrades)->delete();
            }

            DB::commit();
            return $this->successResponse(['message' => trans('Cập nhật thang bảng lương thành công!')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }
}
