<?php

namespace App\Http\Controllers\Api\Prof;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Module;
use App\Models\Profile;
use App\Models\Classe;
use App\Models\Salle;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class HomeController extends BaseController
{
    public function index()
    {
        $classes = Classe::all();
        $profs = User::where('permission', 1)->get();
        $modules = Module::all();
        $etudiants = User::where('permission', 0)->get();
        $salles = Salle::all();
        $info["classes"] = $classes;
        $info["classes_nbr"] = $classes->count();
        $info["moduls"] = $modules;
        $info["moduls_nbr"] = $modules->count();
        $info["profs"] = $profs;
        $info["profs_nbr"] = $profs->count();
        $info["etudiants"] = $etudiants;
        $info["salles"] = $salles;
        $info["etudiants_nbr"] = $etudiants->count();
        return $this->sendResponse($info, 'data retrieved Successfully!');
    }
    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => 'required',
            "email" => 'required',
            "prenom" => 'required',
            "permission" => 'required',
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
        $profile['role'] = $input['permission'];

        if ($input['permission'] == 0) {
            $profile['CNE'] = $input['CNE'];
        }
        Profile::create($profile);

        if ($input['permission'] == 1) {
            $module = Module::where('titre', $input['module_titre'])->first();
            $module->prof_id = $user->id;
            $module->save();
        }
        $success["name"] = $user["name"];
        $success["per"] = $input["permission"];
        return $this->SendResponse($success, "the user created  sucssesfully!!");
    }
}
