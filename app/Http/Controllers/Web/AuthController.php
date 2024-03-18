<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Utils as Utils;
use App\Models\User;
use App\Validators\Model\User as UserValidator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function signin(Request $request)
    {
        // TODO: Set default messages of Validator
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|string|min:6',
        ], [
            'username.required' => trans('empty_user_username'),
            'password.required' => trans('empty_user_password'),
            'password.string' => trans('invalid_user_password'),
            'password.min' => trans('invalid_user_password'),
        ]);

        if ($validator->fails()) {
            return Utils::responseJsonError($validator->errors()->first());
        }

        $credentials = $request->only('username', 'password');
        $user = User::where(['username' => $credentials['username'], 'role' => 'admin'])->first();
        if ($user && $user->password === md5($credentials['password'])) {
            Auth::login($user);
            $request->session()->regenerate();
            return Utils::responseJsonData();
        }

        return Utils::responseJsonError(trans('not_found_credential'));
    }

    public function signout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Utils::responseJsonData();
    }
}
