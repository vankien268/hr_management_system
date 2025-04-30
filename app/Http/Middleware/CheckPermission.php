<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\MenuPermissionEnum;

use Symfony\Component\HttpFoundation\Response;

use function App\Helper\check_menu_permission;
use function App\Helper\check_sub_menu_permission;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User */
        $user = auth()->user();
        // request()->merge(['code' => $request->code]);
        if($user){
            $user = $user->load(['roles.roleSystemFunctions', 'projectFunctionUser']);
            $permissions = $user->roles->pluck('roleSystemFunctions.*.system_function_id')->unique()->reduce(function ($result, $item) {
                return array_merge($result, $item);
            }, []);
            request()->merge(['list_permissions' => $permissions, 'project_functions' => $user->projectFunctionUser]);
        }
        // dd(check_menu_permission(MenuPermissionEnum::GROUP_MENU_REPORT));
        // dd(request()->route()->getName());
        if(check_sub_menu_permission(request()->route()->getName()) == false){
            return redirect('/404-page');
        }
        return $next($request);
    }
}
