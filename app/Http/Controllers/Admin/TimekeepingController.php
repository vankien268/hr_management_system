<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalaryGradeUpdateRequest;
use App\Repositories\Interfaces\ISalaryGradeRepository;
use App\Repositories\Interfaces\ITimekeepingRepository;
use App\Transformers\SalaryGradeTransformer;
use App\Transformers\TimeKeepingTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Nette\Utils\first;

class TimekeepingController extends Controller
{

    /**
     * @var ITimekeepingRepository
     */
    private $timekeepingRepository;

    public function __construct(ITimekeepingRepository $timekeepingRepository)
    {

        $this->timekeepingRepository = $timekeepingRepository;
    }

    public function index()
    {
        $breadcrums = [
            'text' => trans('Chấm công')
        ];
//        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_PRODUCT);
        $data = [
            'breadcrums' => $breadcrums,
            'pageName' => trans('Chấm công'),
            'btnAdd' => true,
        ];
        return view('admin.timekeepings.index')->with($data);
    }

    public function getInfoTimekeepings(Request $request)
    {
        if($request->shift_id == 0) {
//
            $query = DB::table('working_shift_users')
                ->select('working_shift_setting_id')
                ->where('user_id', auth()->user()->id);
            if($query->get()->count() > 1) {
                $data = [
                    'timeKeepings' => [],
                    'isCheckIn' =>  false,
                    'isComplete' => false,
                ];

                return response()->json($data);
            }

            $working_shift_setting_id = $query->first()->working_shift_setting_id;
        }

        $timeKeepings = $this->timekeepingRepository->model()
            ->where('valid', 1)
            ->where('user_id', auth()->user()->id)
            ->where('shift_id', $working_shift_setting_id ?? $request->shift_id)
            ->get()
            ->map(function ($item) {
                $item->check_in_time = $item->check_in ? Carbon::parse($item->check_in)->format('H:i:s') : '';
                $item->check_out_time = $item->check_out ? Carbon::parse($item->check_out)->format('H:i:s') : '';
                return $item;
            });


        $data = [
            'timeKeepings' => $timeKeepings,
            'isCheckIn' => $this->timekeepingRepository->model()
                ->where('user_id', auth()->user()->id)
                ->where('shift_id',$working_shift_setting_id ?? $request->shift_id)->where('valid', 1)->whereDate('checkin_date', now()->format('Y-m-d'))->exists(),
            'isComplete' => $this->timekeepingRepository->model()
                ->where('user_id', auth()->user()->id)
                ->where('shift_id',$working_shift_setting_id ?? $request->shift_id)->where('valid', 1)->whereDate('checkin_date', now()->format('Y-m-d'))
                ->whereNotNull('check_in')
                ->whereNotNull('check_out')
                ->exists(),
        ];

        $this->setTransformer(new TimeKeepingTransformer());

        return response()->json($data);
    }

    public function update(Request $request)
    {
        $data = $request->all();

        if(! $request->shift_id) {
            return $this->errorsResponse(['shift_id' => ["Vui lòng chọn ca chấm công."]], 422);
        }

        $isCheckin = $request->is_checkin;

        DB::beginTransaction();
        try {

            if($isCheckin == false) {
                $attributes = [
                  'user_id'  => auth()->user()->id,
                  'check_in'  => date('Y-m-d H:i:s'),
                  'check_out'  => null,
                  'checkin_date'  => date('Y-m-d'),
                  'shift_id'  => $request->shift_id,
                ];

                $this->timekeepingRepository->create($attributes);
                $message = trans('Bạn đã chấm công vào thành công!');

            }else {
                $record =  $this->timekeepingRepository->model()
                    ->where('user_id', auth()->user()->id)
                    ->where('shift_id', $request->shift_id)
                    ->where('valid', 1)->whereDate('checkin_date', now()->format('Y-m-d'))->first();

                $record->update([
                    'check_out'  => date('Y-m-d H:i:s'),
                ]);

                $message = trans('Bạn đã chấm ra vào thành công!');
            }

            DB::commit();
            return $this->successResponse(['message' => $message]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }
}
