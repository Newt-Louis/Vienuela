<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function signIn(Request $request)
    {
        $credentials = [
            'account_user' => $request->username,
            'password' => $request->userpassword,
        ];
        $remember = $request->remember;
        if (Auth::attempt($credentials) && $remember === true) {
            $user = Auth::user();
            $tokenResult = $user->createToken($user->account_user,['*'],Carbon::now()->addDays(30));
            $token = $tokenResult->plainTextToken;
            $user->login_at = now();
            $user->save();
            return response()->json(['user' => $user,'token' => $token,'expired' => true], 200);
        } else if (Auth::attempt($credentials) && $remember === false) {
            $user = Auth::user();
            $token = $user->createToken($user->account_user)->plainTextToken;
            $user->login_at = now();
            $user->save();
            return response()->json(['user' => $user,'token' => $token,'expired' => false], 200);
        } else {
            return response()->json();
        }
    }
    public function signOut (Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Đã đăng xuất khỏi phiên hiện tại']);
    }
    public function createUser(Request $request)
    {
        $validated = $request->validate(
            [
                'realname' => 'required',
                'phone' => 'required | max:10 | unique:users,phone_user',
                'email' => 'required | unique:users,email_user',
                'username' => 'required | unique:users,account_user',
                'password' => 'required',
                'passwordconfirm' => 'required | same:password',
            ],
            [
                'realname.required' => 'Chưa nhập tên tài khoản',
                'phone.required' => 'Chưa nhập số điện thoại',
                'phone.max' => 'Số điện thoại chỉ được phép 10 chữ số',
                'phone.unique' => 'Số điện thoại này đã đăng ký rồi !!!',
                'email.required' => 'Chưa nhập email',
                'email.unique' => 'Email này đã đăng ký rồi !!!',
                'username.required' => 'Chưa tên tài khoản',
                'username.unique' => 'Tên tài khoản đã tồn tại',
                'password.required' => 'Chưa nhập mật khẩu',
                'passwordconfirm.required' => 'Chưa nhập mật khẩu xác nhận',
                'passwordconfirm.same' => 'Mật khẩu hoặc mật khẩu xác nhận không đúng',
            ]
        );
        if ($validated && ($request->remember === true)) {
            $user = [
              'name_user' => $request->realname,
              'phone_user' => $request->phone,
              'email_user' => $request->email,
              'account_user' => $request->username,
              'password_user' => Hash::make($request->password),
            ];
            $user = User::create($user);
            $token = $user->createToken($user->account_user,['*'],Carbon::now()->addDays(30));
            $tokenResult = $token->plainTextToken;
            $this->check_avatar_update_user($request,$user);
            $user->login_at = now();
            $user->save();
            $workspace = $user->has_many_workspaces()->create([
                'title_workspace' => 'Không gian làm việc của '.$user->account_user,
            ]);
            /*if ($request->hasFile('dragger')) {
                $avatar = $request->file('dragger');
                $userDirectory = 'avatars/'.$user->id_user;
                $avatarPath = $avatar->store($userDirectory, 'public');
                $user->update([
                    'avatar_user' => $avatar->getClientOriginalName(),
                    'avatar_path' => $avatarPath,
                ]);
            }*/
            return response()->json(['user' => User::find($user->id_user), 'token' => $tokenResult, 'expired' => true],200);
        } else if ($validated && ($request->remember === false)){
            $user = [
                'name_user' => $request->realname,
                'phone_user' => $request->phone,
                'email_user' => $request->email,
                'account_user' => $request->username,
                'password_user' => Hash::make($request->password),
            ];
            $user = User::create($user);
            $token = $user->createToken($user->account_user);
            $tokenResult = $token->plainTextToken;
            $this->check_avatar_update_user($request,$user);
            $user->login_at = now();
            $user->save();
            $workspace = $user->has_many_workspaces()->create([
                'title_workspace' => 'Không gian làm việc của '.$user->account_user,
            ]);
            /*if ($request->hasFile('dragger')) {
                $avatar = $request->file('dragger');
                $userDirectory = 'avatars/'.$user->id_user;
                $avatarPath = $avatar->store($userDirectory, 'public');
                $user->update([
                    'avatar_user' => $avatar->getClientOriginalName(),
                    'avatar_path' => $avatarPath,
                ]);
            }*/
            return response()->json(['user' => User::find($user->id_user), 'token' => $tokenResult, 'expired' => false],200);
        }
        return response()->json();
    }
    /*------------Phương thức kiểm tra file avatar có trong request không và cập nhật lại cho user------------*/
    public function check_avatar_update_user($request,$user)
    {
        if ($request->hasFile('dragger')) {
            $avatar = $request->file('dragger');
            $userDirectory = 'avatars/'.$user->id_user;
            $avatarPath = $avatar->store($userDirectory, 'public');
            $user->update([
                'avatar_user' => $avatar->getClientOriginalName(),
                'avatar_path' => $avatarPath,
            ]);
        }
    }
/*    public function editUser($id)
    {

    }*/
    public function updateUser (Request $request, $id)
    {
        $validated = $request -> validate(
            [
                'account_user' => 'required | unique:users,account_user',
                'name_user' => 'required | max:255',
                'email_user' => 'required | unique:users,email_user',
                'phone_user' => 'required | unique:users,phone_user',
            ],
            [
                'account_user.required' => 'Chưa nhập tên tài khoản',
                'account_user.unique' => 'Tên tài khoản đã tồn tại',
                'name_user.required' => 'Chưa nhập họ và tên',
                'name_user.max' => 'Họ và tên vượt quá giới hạn cho phép',
                'email_user.required' => 'Chưa nhập email',
                'email_user.unique' => 'Email đã tồn tại',
                'phone_user.required' => 'Chưa nhập số điện thoại',
                'phone_user.unique' => 'Số điện thoại này đã được đăng ký',
            ]
        );
        User::find($id)->update([
            'account_user' => $request['account_user'],
            'name_user' => $request['name_user'],
            'email_user' => $request['email_user'],
            'phone_user' => $request['phone_user'],
        ]);
    }
    public function changePassword(Request $request, $id)
    {
        $validated = $request->validate(
            [
                'password_user' => 'required',
                'password_user_confirmation' => 'required |same:password_user',
            ],
            [
                'password_user.required' => 'Chưa nhập mật khẩu',
                'password_user_confirmation.required' => 'Chưa nhập mật khẩu xác nhận',
                'password_user_confirmation.same' => 'Mật khẩu và mật khẩu xác nhận không đúng',
            ]
        );
        if ($validated)
        {
            $user = $request->except(['password_user','password_user_confirmation']);
            $user['password_user'] = Hash::make($request['password_user']);
            User::find($id)->update([
                'password_user' => $user
            ]);
            return ['success' => true, 'message' => 'Cập nhật mật khẩu thành công'];
        }
        return ['success' => false, 'message' => 'Không thành công vui lòng thử lại'];
    }
}
