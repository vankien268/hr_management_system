<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Repositories\Interfaces\IUserRepository;
use App\Enums\UserEnum;
use App\Models\User;

class LoginController extends Controller
{
    protected $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getLogin()
    {
        return view('admin.auth.login');
    }

    public function postLogin(LoginRequest $request)
    {
        $checkLogin = Auth::attempt(
            [
                'username' => $request['username'],
                'password' => $request['password'],
                //ghi nhớ đăng nhập
            ],
            $request->remember
        );

        //kiểm tra tài khoản đầu tiên với request
        $user = User::where('username', $request['username'])->first();

        //kiểm tra nếu số lần đăng nhập sai lớn hơn 5 lần thì khoá và thay đổi trạng thái thành khoá
        if (@$user->login_number >= UserEnum::LOGIN_NUMBER) {
            $user->update(['status' => UserEnum::BLOCK]);
            auth()->logout();
            return $this->errorsResponse(['message' => trans('Tài khoản đã bị khóa')], 403);
        }

        //kiểm tra đăng nhập sai tài khoản mật khẩu thì tăng số lần sai lên 1
        if (!$checkLogin) {
            if ($user) {
                $user->increment('login_number', 1);
            }
            return $this->errorsResponse(['message' => trans('Tài khoản hoặc mật khẩu không đúng')], 401);
        }
        if ($user->status == UserEnum::BLOCK) {
            auth()->logout();
            return $this->errorsResponse(['message' => (trans('Tài khoản đã bị khóa'))], 403);
        }
        if ($user->login_number > 0) {
            $user->update([
                'login_number' => 0
            ]);
        }
        // /** @var User */
        // $user = Auth::user()->load('roles.roleSystemFunctions');
        // $permission = $user->roles->pluck('roleSystemFunctions.*.system_function_id');
        // $r = $permission->reduce(function ($result, $item) {
        //     return array_merge($result, $item);
        // }, []);
        // Auth::user()->setAttribute('permission', $r);

        // dd($user);
        return $this->successResponse(['message' => trans('Đăng nhập thành công !'), 'user_info' => 1], 200);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('admin.login');
    }
}
