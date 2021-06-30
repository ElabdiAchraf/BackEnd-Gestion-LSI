<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Resources\PFEResource;
use App\Http\Resources\SeanceResource;
use App\Models\Classe;
use App\Models\Module;
use App\Models\PFE;
use App\Models\Seance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PFEController extends BaseController
{

    public function index()
    {
        $pfes = PFE::all();
        return $this->sendResponse(PFEResource::collection($pfes), 'pfes retrieved Successfully!');
    }
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [

            'prof_id' => 'required',
            'etu_id' => 'required',
            'sujet' => 'required',


        ]);
        if ($validator->fails()) {
            return $this->sendError('Validate Error', $validator->errors());
        }
        $etudiant = User::find($input['etu_id']);
        $classe = Classe::find($etudiant->class_id);

        if ($classe->niveau == 3 && $etudiant->permission == 0) {

            $pfe = PFE::create($input);
            return $this->sendResponse($pfe, 'pfe added Successfully!');
        }
        return $this->sendError('storing  Error', "na pas le droit au pfe ");
    }


    public function show($id)
    {
        $pfe = PFE::find($id);
        if (is_null($pfe)) {
            return $this->sendError('pfe not found!');
        }
        return $this->sendResponse($pfe, 'pfe retireved Successfully!');
    }

    public function update(Request $request, PFE $pfe)
    {

        $input = $request->all();
        $validator = Validator::make($input, [
            'prof_id' => 'required',
            'etu_id' => 'required',
            'sujet' => 'required',
        ]);


        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors());
        }
        $etudiant = User::find($input['etu_id']);
        $classe = Classe::find($etudiant->class_id);
        if ($classe->niveau == 3) {
            $pfe->update($input);
            return $this->sendResponse($pfe, 'pfe updated Successfully!');
        }
        return $this->sendError('storing  Error', "na pas le droit au pfe ");
    }

    public function destroy(PFE $pfe)
    {
        $pfe->delete();
        return $this->sendResponse($pfe, 'pfe deleted Successfully!');
    }
}
