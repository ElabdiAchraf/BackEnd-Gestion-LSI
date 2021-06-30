<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;

class ProfileController extends BaseController
{
    public function update(Request $request,  $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'nom'  => "required",
            'prenom'  => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors());
        }
        // $module->description = $input['description'];
        $profile = Profile::find($id);
        $profile->update($input);
        return $this->sendResponse($profile, 'profile updated Successfully!');
    }
}
