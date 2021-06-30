<?php

namespace App\Http\Controllers\Auth;


use App\Http\Requests\ForgetRequest;
use App\Http\Requests\ResetRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\BaseController as BaseController;

class ForgotPasswordController extends BaseController

{
    public function forgot(ForgetRequest $forgotRequest)
    {
        $email = $forgotRequest->input('email');
        if (User::where('email', $email)->doesntExist()) {
            // return response(['message' => 'doesntExist!!'], 404);
            $this->SendError('email incorrect', ['error' => 'user doesnt Exist!!']);
        }
        $token = Str::random(10);
        try {
            DB::table('rest_password')->insert([
                'email' => $email,
                'token' => $token
            ]);
            Mail::send('mails.forgot', ['token' => $token], function ($message) use ($email) {
                $message->to($email);
                $message->subject('reset your password');
            });
            return $this->SendResponse('good', 'check your email');
            // response(['message' => 'check your email'], 200);
        } catch (\Exception $exp) {
            return response(['message' => $exp->getMessage()], 400);
        }
    }
    public function reset(ResetRequest $request)
    {
        $token = $request->input('token');
        if (!$passwordReset = DB::table('rest_password')->where('token', $token)->first()) {
            return  $this->SendError('invalid token');
        }
        if (!$user = User::where('email', $passwordReset->email)->first()) {
            return  $this->SendError('user doesnt exist');
        }
        $user->password = Hash::make($request->input(('password')));
        $user->pass_hashed = 1;
        $user->save();

        return $this->SendResponse('success', 'successfully!!');
    }
}
