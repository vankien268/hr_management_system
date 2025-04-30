<?php

namespace App\Traits;

use App\Enums\ProjectPermissionEnum;
use App\Enums\SystemPermissionEnum;

trait ProjectPermission
{
    // lấy user đăng nhập
    public function getUserLogin()
    {
        return auth()->user();
    }
    public function userAdmin($user = true)
    {
        return in_array(SystemPermissionEnum::SYSTEM_ADMIN, request('list_permissions'));
    }
    // lấy các quyền dự án của user đăng nhập có
    public function userPermissions($isContract = false)
    {
        $user = $this->getUserLogin();
        $user->load('userHasProjectPermisison');
        if($isContract) {
            $userHasProjectIds = [];
            $projectIdOfUser =  $user->projectFunctionUsers->pluck('pivot.project_id')->unique()->toArray();
            foreach($projectIdOfUser as $id) {
                $isResult = $this->checkUserHasProjectPermission(ProjectPermissionEnum::VIEW_CONTRACT, $id);
                if($isResult) {
                    $userHasProjectIds[] = $id;
                }
            }
            return  $userHasProjectIds;
        }
        $permissionCode = $user->projectFunctionUsers->groupBy('pivot.project_id')->transform(function($item) {
            return  $item->pluck('code');
        })->toArray();
        return $permissionCode;
    }
      // check quyền dự án
    public function checkUserHasProjectPermission($permission, $projectId)
    {
        if($this->userAdmin($this->getUserLogin())) {
            return true;
        }

        if(! $projectId) {
            return false;
        }
        $permissionOfUserLogin = $this->userPermissions();
        if(
            isset($permissionOfUserLogin[$projectId])
            && in_array($permission, $permissionOfUserLogin[$projectId])
        ) {
            return true;
        }
        return false;
    }

    // check quyền sửa/xóa hợp đồng
    public function checkEditOrDeletePermissionContract($permission, $projectId)
    {
        $user = $this->getUserLogin();
        if($this->userAdmin($user)) {
            return true;
        }
        $canUserHasEditContractInProject = $this->checkUserHasProjectPermission($permission, $projectId);
        if($canUserHasEditContractInProject) {
            return true;
        }
        return false;
    }

    // check quyền xem chi tiết thanh toán hợp đồng
    public function checkNumerPaymentContract($permission, $projectId)
    {
        $user = $this->getUserLogin();
        if($this->userAdmin($user)) {
            return true;
        }

        if($this->checkUserHasProjectPermission($permission, $projectId)) {
            return true;
        }
        return false;
    }

    // kiểm tra người tạo hợp đồng, dự án, báo giá
    public function checkUserCreate($userId)
    {
        $user = $this->getUserLogin();
        if($this->userAdmin($user)) {
            return true;
        }

        if($user->id == $userId) {
            return true;
        }
        return false;
    }

    public function listProjectOfUser()
    {
        $user = $this->getUserLogin();
        $user->load('userHasProjectPermisison');
        $projectIdOfUser =  $user->projectFunctionUsers->pluck('pivot.project_id')->unique()->toArray();
        return  $projectIdOfUser;
    }

    public function checkPermissionContract($permission, $projectId)
    {
        $user = $this->getUserLogin();
        if($this->userAdmin($user)) {
            return true;
        }

        if($this->checkUserHasProjectPermission($permission, $projectId)) {
            return true;
        }
        return false;
    }

}
