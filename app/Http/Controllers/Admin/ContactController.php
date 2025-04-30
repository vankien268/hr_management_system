<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactDestroyRequest;
use App\Http\Requests\ContactStoreRequest;
use App\Models\Contact;
use App\Models\Project;
use App\Repositories\Interfaces\IContactRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    protected $contactRepository;

    public function __construct(
        IContactRepository $contactRepository
        )
    {
        $this->contactRepository =  $contactRepository;
    }

    public function storeByProject(ContactStoreRequest $request)
    {
        $data = $request->all();
        $updateAndInsertPivot = [];
        $attributesCreate = [];
        $maxId = $this->contactRepository->model()->withTrashed()->max('id');
        $project = Project::with('contacts')->find($data['project_id']);
        $positionMax = $project->contacts->max('pivot.position');
        $contactDestroyIDs = $request->get('destroyContactIds');
        DB::beginTransaction();
        try{
            if($contactDestroyIDs) {
                $checkContact =  $project->contacts->pluck('pivot.contact_id');
                if(!$checkContact->diff($contactDestroyIDs)->count())
                {
                    return $this->successResponse(['message' => trans('Người liên hệ phải tồn tại ít nhất một người. Vui lòng thử lại.')], 403,);
                }

                $project->contacts()->detach($contactDestroyIDs);
                $this->contactRepository->destroy($contactDestroyIDs);
            }
            array_map(function($item)
            use(&$maxId, &$positionMax, $data, &$updateAndInsertPivot, &$attributesCreate){
                 // array contacts insert
                 if(!$item['id']) {
                    // cập nhật các thuộc tính thêm mới cho bảng pivot
                     $id = ++$maxId;
                     $item['pivot']['contact_id'] = $id;
                     $item['pivot']['project_id'] = $data['project_id'];
                     $item['pivot']['position'] =  ++$positionMax;
                     $updateAndInsertPivot[] =  $item['pivot'];
                     // cập nhật các thuộc tính cần thiết cho bảng contacts để insert mới.
                     $item['id'] = $id;
                     $item['customer_id'] = $data['customer_id'];
                     $item['created_at'] = now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
                     $item['updated_at'] = now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
                     unset($item['pivot']);
                     array_push($attributesCreate, $item);
                 } else {
                    $this->contactRepository->update($item['id'], $item);
                     // cập nhật các thuộc tính update cho bảng pivot
                     $updateAndInsertPivot[$item['id']] = $item['pivot'];
                 }
                 unset($item['pivot'], $item['note']);
                 return $item;
            }, $data['contacts']);
            Contact::insert($attributesCreate);
            $project->contacts()->syncWithoutDetaching($updateAndInsertPivot);
            $contacts= $project->refresh()->contacts;
            DB::commit();
            return $this->successResponse(['contacts' => $contacts,'message' => trans('Cập nhật thành công !')], 200,);
        }catch(\Exception $th) {
            DB::rollback();
            return $this->errorResponse($th->getMessage());
        }
    }
}
