<?php

namespace App\Transformers;

use App\Enums\SystemPermissionEnum;
use League\Fractal\TransformerAbstract;
use App\Models\User;
use Carbon\Carbon;

use function App\Helper\check_user_permission;

class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    protected $isPivot = false;
    protected $isDelete = false;
    protected $usersInProject = false;
    public function __construct($isPivot = false, $isDelete = false, $usersInProject =false)
    {
        $this->isPivot = $isPivot;
        $this->isDelete = $isDelete;
        $this->usersInProject = $usersInProject;
    }

    public function transform(User $entry)
    {
        $related = [];
        // if($entry->relationLoaded('status') === false){
        //     array_push($related, 'status');
        // }
        if($entry->relationLoaded('department') === false){
            array_push($related, 'department');
        }

        $entry = $entry->load($related);
        $data = [
            'id' => $entry->id,
            'name' => $entry->name,
            'username' => $entry->username,
            'department_id' => $entry->department_id,
            'department_name' =>  @$entry->department->name,
            'status' => $entry->status,
            'statusName' => $this->transformStatus($entry->status),
            'genderName' => $this->transformGender($entry->gender),
            'birthday' => $entry->birthday,
            'gender' => $entry->gender,
            'email' => $entry->email,
            'phone' => $entry->phone,
            'skype' => $entry->skype,
            'situation' => User::isUserOnline($entry->id) ? 'ON' : 'OFF',
            'remember_token' => $entry->remember_token,
            'idSave' =>  $entry->id,
            'roles' => fractal($entry->roles->unique('id'), new RoleTransformer()),
            'isEdit' =>  check_user_permission(SystemPermissionEnum::EDIT_USER),
            'is_delete_permission' =>  check_user_permission(SystemPermissionEnum::DELETE_USER),
            'changePassword' =>  check_user_permission(SystemPermissionEnum::CHANGE_PASSWORD_USER),
            'avatar' => $entry->avatar
        ];
        if($this->isPivot) {
            $data['pivot'] = $entry->pivot;
        }
//        if($this->isDelete) {
//            $data['isDelete'] = $entry->resultUserHasRelated($entry);
//        }
        if($this->usersInProject) {
            $data['idSave'] =  $entry->id;
        }
        return $data;
    }

    private  function transformStatus($status)
    {
        return $status? 'Kích hoạt' : 'Khóa';
    }

    private function transformGender($gender)
    {
        $nameGender = "";
        switch($gender) {
            case 1 :
                $nameGender = 'Nam';
                break;
            case 2 :
                $nameGender = 'Nữ';
                break;
            default:
            $nameGender = 'Khác';
        }
        return  $nameGender;
    }
}
