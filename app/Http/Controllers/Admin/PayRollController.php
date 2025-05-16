<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SystemPermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\AllowanceStoreRequest;
use App\Http\Requests\AllowanceUpdateRequest;
use App\Http\Requests\PayRollStoreRequest;
use App\Http\Requests\PayRollUpdateRequest;
use App\Repositories\Interfaces\IAllowanceRepository;
use App\Repositories\Interfaces\IPayRollRepository;
use App\Transformers\AllowanceTransformer;
use App\Transformers\PayRollTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function App\Helper\check_user_permission;

class PayRollController extends Controller
{
    /**
     * @var IPayRollRepository
     */
    private $payRollRepository;

    public function __construct(IPayRollRepository $payRollRepository)
    {
        $this->payRollRepository = $payRollRepository;
    }

    public function index()
    {
        $breadcrums = [
            'text' => trans('Bậc lương vị trí')
        ];

        $data = [
            'breadcrums' => $breadcrums,
            'pageName' => trans('Bậc lương vị trí'),
            'btnAdd' => true,
        ];
        return view('admin.pay-rolls.index')->with($data);
    }

    public function getAllPayRolls(Request $request)
    {
        $payRolls = $this->payRollRepository->model()
           ->where('valid', 1)
            ->orderByDesc('id')->get()->transform(function ($item) {
                $item->pay_ranges =  DB::table('pay_ranges')->where('pay_roll_id', $item->id)->get()->toArray();
                return $item;
            });

        $this->setTransformer(new PayRollTransformer());

        return $this->responseCollection(
            $payRolls,
            200
        );
    }

    public function store(PayRollStoreRequest $request)
    {
        $data = $request->all();
        DB::beginTransaction();
        try {
            $pay_ranges = $data['pay_ranges'] ?? [];

            unset($data['pay_ranges']);

            $payRoll = $this->payRollRepository->create($data);

            foreach ($pay_ranges as $key => $item) {
                $pay_ranges[$key]['pay_roll_id'] = $payRoll->id;
                $pay_ranges[$key]['level'] = $key + 1;
            }

            DB::table('pay_ranges')->insert($pay_ranges);

            DB::commit();
            return $this->successResponse(['message' => trans('Thêm bậc lương vị trí thành công!')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function update($id, PayRollUpdateRequest $request)
    {
        $payRoll = $this->payRollRepository->find($id);

        if (! $payRoll) {
            return $this->errorsResponse(['message' => trans('Bậc lương vị trí không tồn tại.')], 422);
        }

        $data = $request->all();

        DB::beginTransaction();
        try {
            $pay_ranges = $data['pay_ranges'] ?? [];

            unset($data['pay_ranges']);

            $payRoll->update($data);

            DB::table('pay_ranges')->where('pay_roll_id', $payRoll->id)->delete();

            $payRangeNews = [];

            foreach ($pay_ranges as $key => $item) {
                $payRangeNews[] = [
                  'pay_roll_id' =>   $payRoll->id,
                  'performance_based_pay' =>   $item['performance_based_pay'] ?? 0,
                  'person_based_pay' =>   $item['person_based_pay'] ?? 0,
                  'position_based_pay' =>   $item['position_based_pay'] ?? 0,
                  'level' => $key + 1,
                ];
            }

            DB::table('pay_ranges')->insert($payRangeNews);

            DB::commit();
            return $this->successResponse(['pay_roll' => $payRoll->refresh(), 'message' => trans('Cập nhật bậc lương vị trí thành công!.')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy($id)
    {
        $payRoll = $this->payRollRepository->find($id);

        if (! $payRoll) {
            return $this->errorsResponse(['message' => trans('Bậc lương vị trí không tồn tại.')], 422);
        }

        DB::beginTransaction();
        try {

            DB::table('pay_ranges')->where('pay_roll_id', $payRoll->id)->delete();

            $payRoll->delete();
            DB::commit();
            return $this->successResponse(['message' => trans('Xóa bậc lương vị trí thành công !')]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return $this->errorResponse($throwable->getMessage());
        }
    }
}
