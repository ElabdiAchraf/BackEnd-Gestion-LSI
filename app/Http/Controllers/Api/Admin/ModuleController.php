<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Module;
use App\Models\Profile;
use App\Models\Classe;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ModuleResource;


class ModuleController extends BaseController
{


    public function index()
    {
        $modules = Module::all();

        return $this->sendResponse(ModuleResource::collection($modules), 'modules retrieved Successfully!');
    }
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'titre' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validate Error', $validator->errors());
        }
        $module = Module::create($input);
        return $this->sendResponse($module, 'module added Successfully!');
    }


    public function show($id)
    {
        $module = Module::find($id);
        if (is_null($module)) {
            return $this->sendError('module not found!');
        }
        return $this->sendResponse($module, 'module retireved Successfully!');
    }

    public function update(Request $request, Module $module)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'titre' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors());
        }
        // $module->description = $input['description'];
        $module->update($input);

        return $this->sendResponse($module, 'module updated Successfully!');
    }

    public function destroy(Module $module)
    {
        $module->delete();
        return $this->sendResponse($module, 'module deleted Successfully!');
    }
}
