<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\ClassResource;
use App\Models\Module;
use App\Models\Profile;
use App\Models\Classe;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ModuleResource;
use App\Http\Resources\ProfResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class ProfController extends BaseController
{


    public function index()
    {
        $prof = User::where('permission', 1)->get();
        return $this->sendResponse(ProfResource::collection($prof), 'prof retrieved Successfully!');
    }
    public function show($id)
    {
        $prof = User::find($id)->profile()->get();
        if (is_null($prof)) {
            return $this->sendError('prof not found!');
        }
        return $this->sendResponse($prof, 'prof retireved Successfully!');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => 'required',
            "email" => 'required',
            "prenom" => 'required',
            "password" => 'required',
            "c_password" => "required|same:password",
        ]);
        if ($validator->fails()) {
            return  $this->SendError('please validate the failds', $validator->errors());
        }
        $input = $request->all();
        $input['permission'] = 1;
        $input["password"] = Hash::make($input["password"]);
        $input["pass_hashed"] = 0;
        $user = User::create($input);

        $profile['nom'] = $input['name'];
        $profile['user_id'] = $user->id;
        $profile['prenom'] = $input['prenom'];
        $profile['role'] = $input['permission'];
        Profile::create($profile);


        $module = Module::where('titre', $input['module_titre'])->first();
        $module->prof_id = $user->id;
        $module->save();

        $success["name"] = $user["name"];
        $success["per"] = $input["permission"];
        return $this->SendResponse($success, "the user created  sucssesfully!!");
    }
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'module_titre'  => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors());
        }
        $module = Module::where('titre', $input['module_titre'])->first();
        $module->prof_id = $id;
        return $this->sendResponse($module, 'module updated Successfully!');
    }
    public function destroy($id)
    {
        $prof = User::find($id);
        $prof->delete();
        return $this->sendResponse($prof, 'prof deleted Successfully!');
    }
}
