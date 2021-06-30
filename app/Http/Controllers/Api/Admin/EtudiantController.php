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
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class EtudiantController extends BaseController
{

    public function index()
    {
        $classeId = Classe::where('name', 'class0')->value('id');
        $etu = User::where('permission', 0)->where('class_id', '!=', $classeId)->get();
        // $etu = User::where('permission', 0)->get();
        return $this->sendResponse(UserResource::collection($etu), 'Etudiants retrieved Successfully!');
    }
    public function show($id)
    {
        $etu = User::find($id)->profile()->get();
        if (is_null($etu)) {
            return $this->sendError('etu not found!');
        }
        return $this->sendResponse($etu, 'Etu retireved Successfully!');
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
        $input["password"] = Hash::make($input["password"]);
        $input["pass_hashed"] = 0;
        $user = User::create($input);
        $profile['nom'] = $input['name'];
        $profile['user_id'] = $user->id;
        $profile['prenom'] = $input['prenom'];
        $profile['role'] = 0;
        $profile['CNE'] = $input['CNE'];
        Profile::create($profile);
        $success["name"] = $user["name"];
        $success["per"] = 0;
        return $this->SendResponse($success, "the user created  sucssesfully!!");
    }
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'class_id'  => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors());
        }
        $etu = User::find($id);
        $etu->update($input);
        return $this->sendResponse($etu, 'classe updated Successfully!');
    }
    public function destroy($id)
    {
        $etu = User::find($id);
        $etu->delete();
        return $this->sendResponse($etu, 'Etu deleted Successfully!');
    }
    // nouveau inscriptions

    public function NewRegistration()
    {
        $classeId = Classe::where('name', 'class0')->value('id');
        $etu = User::where('permission', 0)->where('class_id', $classeId)->get();
        return $this->sendResponse(UserResource::collection($etu), 'Etudiants retrieved Successfully!');
    }
}
