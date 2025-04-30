<?php

namespace App\Helper;

use App\Enums\MenuPermissionEnum;
use App\Models\User;
use App\Enums\SystemPermissionEnum;

if (!function_exists('check_user_permission')) {
    function check_user_permission($permissionId, $projectId = null): bool
    {
        /** @var User */
        $user = auth()->user();
        if (!$user) {
            return false;
        }
        $permissions = request('list_permissions') ?? [];
        // dd($permissions);
        if (in_array(SystemPermissionEnum::SYSTEM_ADMIN, $permissions)) {
            return true;
        }
        if ($projectId) {
            $projectFunctionUser = request('project_functions') ?? collect();
            $checkUser = $projectFunctionUser->where('user_id', $user->id)->where('project_id', $projectId)->where('system_function_id', $permissionId)->first();
            if ($checkUser) {
                return true;
            }
            return false;
        }

        return in_array(SystemPermissionEnum::SYSTEM_ADMIN, $permissions) || in_array($permissionId, $permissions);
    }
}

if (!function_exists('check_user_has_permission_in_project')) {
    function check_user_has_permission_in_project($permissionId): bool
    {
        /** @var User */
        $user = auth()->user();
        if (!$user) {
            return false;
        }
        $projectFunctionUser = request('project_functions') ?? collect();
        $checkUser = $projectFunctionUser->where('user_id', $user->id)->where('system_function_id', $permissionId)->first();
        if ($checkUser) {
            return true;
        }
        return false;
    }
}

if (!function_exists('check_sub_menu_permission')) {
    function check_sub_menu_permission(String $routeName): bool
    {

        $permission = collect(MenuPermissionEnum::MenuPer);
        $checkHasPermission = $permission->where('route_name', 'like', $routeName)->first();
        if (!$checkHasPermission) {
            return true;
        }
        $user = auth()->user();
        if (!$user) {
            return false;
        }
        // dd($checkHasPermission);
        if (in_array($checkHasPermission['id'], [SystemPermissionEnum::VIEW_MENU_PROJECT, SystemPermissionEnum::VIEW_MENU_CONTRACT, SystemPermissionEnum::VIEW_PRICE_QUOTE])) {
            $projectFunctionUser = request('project_functions') ?? collect();

            if ($checkHasPermission['id'] == SystemPermissionEnum::VIEW_MENU_PROJECT) {
                $projectRole = SystemPermissionEnum::VIEW_PROJECT;
                $checkUser = $projectFunctionUser->where('user_id', $user->id)->where('system_function_id', $projectRole)->first();
                // dd($projectRole);
                if ($checkUser) {
                    return true;
                }
            }
            if ($checkHasPermission['id'] == SystemPermissionEnum::VIEW_MENU_CONTRACT) {
                $projectRole = SystemPermissionEnum::VIEW_CONTRACT;
                $checkUser = $projectFunctionUser->where('user_id', $user->id)->where('system_function_id', $projectRole)->first();
                // dd($projectRole);
                if ($checkUser) {
                    return true;
                }
            }
            if ($checkHasPermission['id'] == SystemPermissionEnum::VIEW_PRICE_QUOTE) {
                $projectRole = SystemPermissionEnum::VIEW_PRICE_QUOTES;
                // dd()
                $checkUser = $projectFunctionUser->where('user_id', $user->id)->where('system_function_id', $projectRole)->first();
                // dd($checkUser);
                if ($checkUser) {
                    return true;
                }
            }
        }
        $check = check_user_permission($checkHasPermission['id']);
        if ($check) {
            return true;
        }
        return false;
    }
}

if (!function_exists('check_menu_permission')) {
    function check_menu_permission(array $subMenuGroup): bool
    {
        $permissions = request('list_permissions') ?? [];
        if (in_array(SystemPermissionEnum::SYSTEM_ADMIN, $permissions)) {
            return true;
        }
        // $subMenu = collect($subMenuGroup)->pluck('id')->toArray();
        // // dd($permissions);
        // $check = array_intersect($permissions, $subMenu);
        // if(count($check) > 0){
        //     return true;
        // }
        $subMenu = collect($subMenuGroup);
        foreach ($subMenu as $key => $value) {
            $check = check_sub_menu_permission($value['route_name']);
            if ($check == true) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('check_user_is_admin')) {
    function check_user_is_admin(): bool
    {
        /** @var User */
        $user = auth()->user();
        if (!$user) {
            return false;
        }
        $permissions = request('list_permissions') ?? [];
        return in_array(SystemPermissionEnum::SYSTEM_ADMIN, $permissions);
    }
}

if (!function_exists('get_id_projects_user')) {
    function get_id_projects_user($permissionId): array
    {
        /** @var User */
        $user = auth()->user();
        if (!$user) {
            return [];
        }
        $projectFunctionUser = request('project_functions') ?? [];
        $checkUser = $projectFunctionUser->where('user_id', $user->id)->where('system_function_id', $permissionId);
        // dd($permissions);
        return $checkUser->pluck('project_id')->toArray();
    }
}
