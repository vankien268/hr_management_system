<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HrmContactUpdateRequest;
use App\Repositories\Interfaces\IHrmContactRepository;
use App\Repositories\Interfaces\IHrmContractRepository;
use App\Transformers\HrmContactTransformer;
use App\Transformers\HrmContractTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HrmContractController extends Controller
{

    /**
     * @var IHrmContractRepository
     */
    private $contractRepository;

    public function __construct(IHrmContractRepository $contractRepository)
    {
        $this->contractRepository = $contractRepository;
    }


    public function index()
    {
        $breadcrums = [
            'text' => trans('Quản lý hợp đồng nhân sự')
        ];
//        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_PRODUCT);
        $data = [
            'breadcrums' => $breadcrums,
            'pageName' => trans('Quản lý hợp đồng nhân sự'),
            'btnAdd' => true,
        ];
        return view('admin.hrm-contracts.index')->with($data);
    }

    public function getAllHrmContracts(Request $request)
    {
        $code = $request->code;
        $fullname = $request->fullname;
        $birthday_from = $request->birthday_from;
        $birthday_to = $request->birthday_to;
        $contact_phone = $request->contact_phone;
        $contact_email = $request->contact_email;
        $contact_identify = $request->contact_identify;

        $contacts = $this->contractRepository->model()
            ->where(function ($query) use (
                $fullname,
                $code,
                $birthday_from,
                $birthday_to,
                $contact_phone,
                $contact_email,
                $contact_identify
            ) {
//                if ($fullname) {
//                    $query->where('full_name', 'like', '%' . $fullname . '%');
//                }
//
//                if ($code) {
//                    $query->Where('contact_code','like',  '%' . $code . '%');
//                }
//
//                if ($contact_phone) {
//                    $query->Where('contact_mobile', 'like',  '%' . $contact_phone . '%')
//                        ->orWhere('contact_mobile_2',  'like',  '%' . $contact_phone . '%')
//                        ->orWhere('relative_phone_number',  'like',  '%' . $contact_phone . '%');
//                }
//
//                if ($contact_email) {
//                    $query->Where('contact_email', $contact_email);
//                }
//
//                if ($contact_identify) {
//                    $query->Where('contact_identify', 'like', '%' . $contact_identify . '%');
//                }
//
//                if ($birthday_from) {
//                    $query->where('contact_birthday', '>=', $birthday_from);
//                }
//
//                if ($birthday_to) {
//                    $query->where('contact_birthday', '<=', $birthday_to);
//                }
            })
            ->orderByDesc('id')->get();

        $this->setTransformer(new HrmContractTransformer());

        return $this->responseCollection(
            $contacts,
            200
        );
    }

    public function store(AllowanceStoreRequest $request)
    {
        $data = $request->all();
        DB::beginTransaction();
        try {
            unset($data['allowed_number_days']);
            $this->contractRepository->create($data);
            DB::commit();
            return $this->successResponse(['message' => trans('Thêm phụ cấp thành công!')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function update($id, HrmContactUpdateRequest $request)
    {

        $contact = $this->contractRepository->find($id);

        if (! $contact) {
            return $this->errorsResponse(['message' => trans('Nhân sự không tồn tại.')], 422);
        }

        $data = $request->all();
        unset($data['id']);
        DB::beginTransaction();
        try {

            $contact->update($data);
            DB::commit();
            return $this->successResponse(['allowance' => $contact->refresh(), 'message' => trans('Sửa nhân sự thành công !')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy($id)
    {
        $allowance = $this->contractRepository->find($id);

        if (! $allowance) {
            return $this->errorsResponse(['message' => trans('Phụ cấp không tồn tại.')], 422);
        }

        DB::beginTransaction();
        try {
            $allowance->update(['valid' => 0]);
            DB::commit();
            return $this->successResponse(['message' => trans('Xóa phụ cấp thành công !')]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return $this->errorResponse($throwable->getMessage());
        }
    }
}
