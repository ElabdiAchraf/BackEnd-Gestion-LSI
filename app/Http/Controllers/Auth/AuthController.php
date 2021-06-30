<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => 'required',
            "email" => 'required',
            "password" => 'required',
            "c_password" => "required|same:password",

        ]);
        if ($validator->fails()) {
            return  $this->SendError('please validate your failds', $validator->errors());
        }
        $input = $request->all();
        $input["password"] = Hash::make($input["password"]);
        /**@var User $user  */
        $user = User::create($input);
        // $success["token"] = $user->craeteToken('achraf')->accessToken;
        $success["name"] = $user["name"];
        return $this->SendResponse($success, "you are registred sucssesfully!!");
    }
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            /**@var User $user  */
            $user = Auth::user();


            $success['name'] = $user->name;
            $success['role'] = $user->permission;
            if ($user->pass_hashed == 0) {
                $success['pass_hashed'] = 0;
                return $this->SendResponse($success, 'successfully!');
            }
            $success['token'] = $user->createToken('achraf')->accessToken;

            return $this->SendResponse($success, 'successfully!');
        }
        return $this->SendError('please check your Auth', ['error' => 'unauthorised']);
    }
    public function user()
    {
        return Auth::user();
    }
}
