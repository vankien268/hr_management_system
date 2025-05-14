<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Enums\UserEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use App\Enums\SystemPermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUserStoreRequest;
use App\Transformers\UserTransformer;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Validator;

use function App\Helper\check_user_permission;
use App\Repositories\Interfaces\IUserRepository;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;

    }
    public function view_profile($id)
    {
        // $breadcrums = [
        //     'text' => trans('Quản lý người dùng')
        // ];
        $req = request()->all();
        $user = $this->userRepository->findWithRelationships($id, ['department']);
        if(!$user){
            return view('page-errors.404');
        }
        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_USER);
        $data = [
            // 'breadcrums' => $breadcrums,
            'pageName' => trans('Thông tin người dùng'),
            'btnAdd' => true,
            'user' => fractal($user, new UserTransformer())->toArray(),
        ];
        return view('admin.users.user_profile')->with($data);
    }
    public function index()
    {
        $breadcrums = [
            'text' => trans('Quản lý người dùng')
        ];
        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_USER);
        $data = [
            'breadcrums' => $breadcrums,
            'pageName' => trans('Quản lý người dùng'),
            'btnAdd' => $btnAdd,
        ];
        return view('admin.users.index')->with($data);
    }

    public function getAllUsers(Request $request)
    {
        $perPage = $request->per_page;
        if(!$perPage) {
            $perPage = 30;
        }
        $usernameId = $request['username_id'];
        $userId = $request['user_id'];
        if($usernameId && $userId && $userId != $usernameId) {
            return $this->responseCollection(collect([]), 200, [], ['paginate' => false]);
        }
        $users = $this->userRepository->getDataFilter($request);

        $this->setTransformer(new UserTransformer(false, true));
        if($request->getAll) {
            return $this->responseCollection($users->orderBy('name')->get(), 200, [], ['paginate' => false]);
        }
        return $this->responsePaginatedCollection($users->orderByDesc('department_id')->paginate($perPage), 200);
    }

    public function store(UserStoreRequest $request)
    {
        if(! check_user_permission(SystemPermissionEnum::ADD_USER)) {
            return $this->errorsResponse(['message' => trans('Bạn không có quyền thêm người dùng.')], 403);
        }

        $data = $request->all();
        $roles = $data['roles'];
        $roleErrors = $this->getErrorsRoleDuplicate($roles);
        if(count($roleErrors) > 0) {
            return $this->errorsResponse($roleErrors, 422);
        }
        $data['birthday'] = Carbon::createFromFormat('Y-m-d', $data['birthday'])->format('Y-m-d');

        DB::beginTransaction();
        try {
            $data['password'] = bcrypt($data['password']);
            $user = $this->userRepository->create($data);

            $userRoles = array_column($roles, 'role_id');
            $user->roles()->sync($userRoles);

            if($user) {
                $currentYear = date('Y');
                $countContact = DB::table('contacts')->count();

                $hrmContactId = str_pad($countContact + 1, 5, 0, STR_PAD_LEFT);

                $codeHrmContact = "EPL/{$currentYear}/{$hrmContactId}";

                $contacts = [
                  'contact_code' => $codeHrmContact,
                    'full_name' => $data['name'] ?? null,
                    'contact_birthday' =>  $data['birthday'],
                    'contact_gender' => $data['gender'],
                    'contact_email' => $data['email'],
                    'contact_mobile' => $data['phone'],
                    'department_id' => $data['department_id'],
                    'user_id' => $user->id,
                ];

                DB::table('contacts')->insert($contacts);
            }

            DB::commit();
            return $this->successResponse(['message' => trans('Thêm người dùng thành công !'), 'data' =>$user ]);
        }catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }

    }

    private function getErrorsRoleDuplicate($roles)
    {
        $messages = new MessageBag();
        $countRoles = count($roles);
        for($i = 0; $i < $countRoles; $i ++)
            for($j = $i + 1; $j < $countRoles; $j ++)
            {
                if($roles[$i]['role_id'] == $roles[$j]['role_id']) {
                    $messages->add('roles.'.$j.'.role_id', trans('Nhóm quyền đã bị trùng.'));
                }
            }

        return $messages;
    }

    public function update(UserUpdateRequest $request, $id)
    {
        if(! check_user_permission(SystemPermissionEnum::EDIT_USER)) {
            return $this->errorsResponse(['message' => trans('Bạn không có quyền sửa người dùng.')], 403);
        }

        $data = $request->only(['name', 'password', 'gender', 'email', 'phone',
            'status', 'birthday', 'department_id', 'skype', 'roles']);
        $data['id'] = $id;
        $data['birthday'] = Carbon::createFromFormat('Y-m-d', $data['birthday'])->format('Y-m-d');
        $validate = Validator::make($data,
            [
                'id' => 'required|numeric|exists:users,id',
            ],
            [
                'id.required' => trans('Mã người dùng không được bỏ trống !'),
                'id.numeric' => trans('Mã người dùng phải là số !'),
                'id.exists' => trans('Mã người dùng không tồn tại !'),
            ]
        );

        if($validate->fails()) {
            return $this->errorsResponse($validate->errors(), 422);
        }
        $roles = $data['roles'];
        $roleErrors = $this->getErrorsRoleDuplicate($roles);
        if(count($roleErrors) > 0) {
            return $this->errorsResponse($roleErrors, 422);
        }
        DB::beginTransaction();
        try {
            $user = $this->userRepository->find($data['id']);
            if(array_key_exists('password', $data) && !$data['password']) {
                unset($data['password']);
            }
            if($request->get('password')) {
                $data['password'] = bcrypt($request->password);
            }
            if($user->status == UserEnum::BLOCK
                 && $user->login_number == 5
             ) {
                 $data['login_number'] = 0;
             }

            $user->update($data);
            $userRoles = array_column($roles, 'role_id');
            $user->roles()->sync($userRoles);

            $currentYear = date('Y');
            $countContact = DB::table('contacts')->count();

            $hrmContactId = str_pad($countContact + 1, 5, 0, STR_PAD_LEFT);

            $codeHrmContact = "EPL/{$currentYear}/{$hrmContactId}";

            $contacts = [
                'contact_code' => $codeHrmContact,
                'full_name' => $data['name'] ?? null,
                'contact_birthday' =>  $data['birthday'],
                'contact_gender' => $data['gender'],
                'contact_email' => $data['email'],
                'contact_mobile' => $data['phone'],
                'department_id' => $data['department_id'],
                'user_id' => $user->id,
            ];

            if(!  DB::table('contacts')->where('user_id', $user->id)->first()) {
                DB::table('contacts')->where('user_id', $user->id)->insert($contacts);
            }else {
                DB::table('contacts')->where('user_id', $user->id)->update($contacts);
            }

            DB::commit();
            return $this->successResponse(['message' => trans('Sửa người dùng thành công !')], 200);
        }catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function changePassword($id,Request $request)
    {
        if(! check_user_permission(SystemPermissionEnum::CHANGE_PASSWORD_USER)) {
            return $this->errorsResponse(['message' => trans('Bạn không có quyền đổi mật khẩu người dùng.')], 403);
        }
        $data = $request->all();
        $data['id'] = $id;
        $data['password'] = trim($request->get('password'));
        $validate = Validator::make($data,
            [
                'id' => 'required|numeric|exists:users,id',
                'password' => ['required','max:30','regex:/^.*(?=.{6,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[{[\]~`!%^&*=};:?><@$()#_]).*$/',function($attribute, $value, $fail){
                    if(str_contains($value, ' ')) {
                        return $fail(trans('Mật khẩu phải viết liền, từ 6 ký tự có ít nhất 1 chữ thường, 1 chữ hoa, 1 số và 1 ký tự đặc biệt'));
                    }
                }],
            ],
            [
                'id.required' => trans('Mã người dùng không được bỏ trống !'),
                'id.numeric' => trans('Mã người dùng phải là số !'),
                'id.exists' => trans('Mã người dùng không tồn tại !'),
                'password.required' => trans('Mật khẩu không được bỏ trống !'),
                'password.max' => trans('Mật khẩu không được quá 30 ký tự !'),
                'password.regex' => trans('Mật khẩu phải viết liền, từ 6 ký tự có ít nhất 1 chữ thường, 1 chữ hoa, 1 số và 1 ký tự đặc biệt'),
            ]
        );

        if($validate->fails()) {
            return $this->errorsResponse($validate->errors(), 422);
        }
        $this->userRepository->find($data['id'])->update([
            'password' => bcrypt($request->password)
        ]);
        return $this->successResponse(['message' => trans('Đổi mật khẩu thành công !')]);
    }

    public function destroy($id)
    {
        if(! check_user_permission(SystemPermissionEnum::DELETE_USER)) {
            return $this->errorsResponse(['message' => trans('Bạn không có quyền xóa người dùng.')], 403);
        }

        $data['id'] = $id;
        $validate = Validator::make($data,
            [
                'id' => 'required|numeric|exists:users,id'
            ],
            [
                'id.required' => trans('Mã người dùng không được bỏ trống !'),
                'id.numeric' => trans('Mã người dùng phải là số !'),
                'id.exists' => trans('Mã người dùng không tồn tại !')
            ]
        );

        if($validate->fails()) {
            return $this->errorsResponse($validate->errors(), 422);
        }
       DB::beginTransaction();
        try {

            $user = $this->userRepository->findWithRelationships($data['id'], ['roles','userHasProjectPermisison']);
                $user->projectFunctionUsers()->detach();
                $user->roles()->detach();
               $user->delete();

                 DB::table('contacts')->where('user_id', $id)->delete();
                DB::commit();
                return $this->successResponse(['message' => trans('Xóa người dùng thành công !')]);
                return $this->errorsResponse(["message" => trans("Không thể xóa người dùng vì đã phát sinh dữ liệu liên quan.")], 422);
        }catch (\Throwable $throwable) {
            DB::rollBack();
            return $this->errorResponse($throwable->getMessage());
        }
    }

    public function profile()
    {
       $user = auth()->user();

       $data = [
            'pageName' => trans('Thông tin tài khoản'),
            'user' => fractal($user, new UserTransformer())->toArray(),
        ];
        return view('admin.users.user_profile')->with($data);
    }

    public function storeProfile(ProfileUserStoreRequest $request)
    {
        $data = $request->all();
        $user = auth()->user();
        DB::beginTransaction();
        try {
                if($request->hasFile('avatar')) {
                    // delete ảnh cũ
                    $avatar = $user->avatar;
                    if ($avatar) {
                        $imageOldInStorage = substr($avatar, strrpos($avatar, '/') + 1);
                    //  dd( $imageOldInStorage, $imageLink);
                        if (Storage::disk('public')->exists('/user_images/' . $imageOldInStorage)) {
                            unlink(storage_path('app/public/user_images/' . $imageOldInStorage));
                        }
                    }

                    $file = $request->file('avatar');
                    $imageName = time() . '.' . $file->extension();
                    Storage::disk('public')->put('/user_images/' . $imageName, $file->getContent());
                    $data['avatar'] = 'user_images/'.$imageName;
                }
                $this->userRepository->update($user->id, $data);
                 DB::commit();
                return $this->successResponse(['message' => trans('Cập nhật thành công !')]);
        }catch (\Throwable $throwable) {
            DB::rollBack();
            return $this->errorResponse($throwable->getMessage());
        }
    }

}
