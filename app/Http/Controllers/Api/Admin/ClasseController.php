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


class ClasseController extends BaseController
{


    public function index()
    {
        $classes = Classe::where('name', '!=', 'class0')->get();
        return $this->sendResponse(ClassResource::collection($classes), 'classes retrieved Successfully!');
    }
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validate Error', $validator->errors());
        }
        $classe = Classe::create($input);
        return $this->sendResponse($classe, 'classe added Successfully!');
    }


    public function show($id)
    {
        $classe = Classe::find($id);
        if (is_null($classe)) {
            return $this->sendError('classe not found!');
        }
        return $this->sendResponse($classe, 'classe retireved Successfully!');
    }

    public function update(Request $request,  $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors());
        }
        // $module->description = $input['description'];
        $classe = Classe::find($id);
        $classe->update($input);
        return $this->sendResponse($classe, 'classe updated Successfully!');
    }
    public function getEtudiants()
    {
    }

    public function destroy($id)
    {
        $classe = Classe::find($id);
        $classe->delete();
        return $this->sendResponse($classe, 'classe deleted Successfully!');
    }
}
