<?php

namespace App\Repositories;

use App\Enums\SystemPermissionEnum;
use App\Models\Project;
use App\Repositories\Interfaces\IProjectManagementRepository;

use function App\Helper\check_user_permission;

class ProjectManagementRepository extends BaseRepository implements IProjectManagementRepository{
    protected $viewListProjectPermission;
    public function __construct(Project $model)
    {
        $this->model = $model;
    }

    const RELATIONS = [
        'contacts',
        'projectType',
        'statusProject',
        'customer',
        'tasks',
        'tasks.user',
        'city',
        'users',
        'deploymentSchedules',
        'projectFunctionUsers',
        'projectFunctions',
        'userCreateProject'
    ];

    public function getProjectsALLData($request)
    {
        $this->viewListProjectPermission = check_user_permission(SystemPermissionEnum::VIEW_LIST_PROJECT);
        $nameAndCode = $request['nameAndCode'];
        $city_id = $request['city_id'];
        $project_type  = $request['project_type'];
        $customer_name = $request['customer_name'];
        $customer_code = $request['customer_code'];
        $user_name = $request['user_name'];
        $from_date = $request['from_date'];
        $to_date = $request['to_date'];

        $projects = $this->model->with(static::RELATIONS)
        ->when($nameAndCode, function ($query) use ($nameAndCode){
            return $query->where('name','like', '%'.$nameAndCode.'%')->orWhere('code', 'like', '%'.$nameAndCode.'%');

            })->when($city_id, function ($query) use ($city_id,){
                    return $query->where('city_id', $city_id);
            })
            ->when($project_type, function ($query) use ($project_type,){
                return $query->where('project_type_id', $project_type);
            })
            ->when($customer_name, function ($query) use ($customer_name){
                $query->whereHas('customer', function($q) use ($customer_name) {
                    $q->where('id', $customer_name);
                });
            })
            ->when($customer_code, function ($query) use ($customer_code){
                $query->whereHas('customer', function($q) use ($customer_code) {
                    $q->where('code','like', '%'.$customer_code.'%');
                });
            })
            ->when($user_name, function ($query) use ($user_name){
                $query->whereHas('users', function($q) use ($user_name) {
                    $q->where('name','like', '%'.$user_name.'%');
                });
            })->when($from_date && $to_date, function ($query) use ($from_date, $to_date){
                $query->whereBetween('created_at', [$from_date, $to_date]);
            });

        // Nếu quyền hệ thống thì sẽ bỏ qua đoạn check dưới.
        // Check quyền hợp đồng của dự án
        // $userHasPermissionProjectIds =  $this->model->userPermissions(true);
        // if($request->contractPermission) {
        //     $projects->whereIn('id', $userHasPermissionProjectIds);
        // }

        // // Kiểm tra quyền user có quyền xem dự án nào(check quyền của dự án)
        // $projects->whereIn('id',$this->model->listProjectOfUser());

        if(isset($request['name']) && $request['name'] != null){
            $projects->where('name', 'like', '%' . $request['name'] . '%');
        }

        if(!$this->viewListProjectPermission && !$this->model()->userAdmin()){
            $projectId = request('project_functions')->pluck('project_id');
            $projects->where(function($query) use($projectId){
                $query->whereIn('id', $projectId)->orWhere('created_by', auth()->user()->id);
            });
        }

        return $projects;
    }

    public function getDataProjectHistories($oldData, $newData)
    {
        $old = [];
        $attributes = [];

          // Changed city_id
                if(isset($newData['city_id'])) {
                    $attributes['city_id'] = $newData['city_id'];
                    unset($newData['city_id']);

                  }

                // old city_id
                if(isset($oldData['city_id'])) {
                  $old['city_id'] = $oldData['city_id'];
                  unset($oldData['city_id']);

                }

                 // Changed status_id
                 if(isset($newData['status_id'])) {
                    $attributes['status_id'] = $newData['status_id'];
                    unset($newData['status_id']);

                  }
                // old status_id
                if(isset($oldData['status_id'])) {
                  $old['status_id'] = $oldData['status_id'];
                  unset($oldData['status_id']);

                }

                 // Changed project_type_id
                 if(isset($newData['project_type_id'])) {
                    $attributes['project_type_id'] = $newData['project_type_id'];
                    unset($newData['project_type_id']);

                  }
                // old project_type_id
                if(isset($oldData['project_type_id'])) {
                  $old['project_type_id'] = $oldData['project_type_id'];
                  unset($oldData['project_type_id']);

                }

                 // Changed customer_id
                 if(isset($newData['customer_id'])) {
                    $attributes['customer_id'] = $newData['customer_id'];
                    unset($newData['customer_id']);

                  }
                // old customer_id
                if(isset($oldData['customer_id'])) {
                  $old['customer_id'] = $oldData['customer_id'];
                  unset($oldData['customer_id']);

                }

                if(isset($newData['name'])) {
                    $newData['project_name'] = $newData['name'];
                }

                if(isset($newData['name'])) {
                    $newData['project_name'] = $newData['name'];
                    $oldData['project_name'] = $oldData['name'];
                }
                $attributes['project'] = $newData;
                $old['project'] = $oldData;

                return ['old' => $old, 'attributes' => $attributes];
    }

    public function getDataProjectHistoriesCreate($project, $contact, $user)
    {
        $attributes = [];
          // Changed city_id
                if(isset($project['city_id'])) {
                    $attributes['city_id'] = $project['city_id'];
                  }

                 // Changed status_id
                 if(isset($project['status_id'])) {
                    $attributes['status_id'] = $project['status_id'];
                  }

                 // Changed project_type_id
                 if(isset($project['project_type_id'])) {
                    $attributes['project_type_id'] = $project['project_type_id'];
                }
                // Changed customer_id
                if(isset($project['customer_id'])) {
                    $attributes['customer_id'] = $project['customer_id'];
                }

                if(isset($project['name'])) {
                    $attributes['project']['name'] = $project['name'];
                    $attributes['project']['project_name'] = $project['name'];
                }

                if(isset($project['code'])) {
                    $attributes['project']['code'] = $project['code'];
                 }

                if(isset($project['description'])) {
                    $attributes['project']['description'] = $project['description'];
                }

                #Contact

                if(isset($contact['name'])) {
                    $attributes['contact']['name'] = $contact['name'];
                }

                if(isset($contact['phone'])) {
                    $attributes['contact']['phone'] = $contact['phone'];
                }

                if(isset($contact['email'])) {
                    $attributes['contact']['email'] = $contact['email'];
                }

                if(isset($contact['position'])) {
                    $attributes['contact']['position'] = $contact['position'];
                }

                if(isset($contact['status'])) {
                    $attributes['contact']['status'] = $contact['status'];
                }

                if(isset($contact['note'])) {
                    $attributes['contact']['contact_note'] = $contact['note'];
                }

                #user
                  // Changed user_id
                if(isset($user['user_id'])) {
                    $attributes['user']['user_id'] = $user['user_id'];
                }

                if(isset($user['note'])) {
                    $attributes['user']['user_note'] = $user['note'];
                }

                return ['attributes' => $attributes];
    }
}
