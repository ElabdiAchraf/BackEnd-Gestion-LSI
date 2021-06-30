<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Salle;
use Illuminate\Http\Request;
use App\Http\Resources\SalleResource;
use Illuminate\Support\Facades\Validator;

class SalleController extends  BaseController
{
    public function index()
    {
        $salles = Salle::all();

        return $this->sendResponse(SalleResource::collection($salles), 'salles retrieved Successfully!');
    }
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [

            'nom'            => 'required',
            'numero'        => 'required',
            'departement'    => 'required',

        ]);
        if ($validator->fails()) {
            return $this->sendError('Validate Error', $validator->errors());
        }
        $salle = Salle::create($input);
        return $this->sendResponse($salle, 'salle added Successfully!');
    }


    public function show($id)
    {
        $salle = Salle::find($id);
        if (is_null($salle)) {
            return $this->sendError('salle not found!');
        }
        return $this->sendResponse($salle, 'salle retireved Successfully!');
    }

    public function update(Request $request, Salle $salle)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'nom'            => 'required',
            'numero'        => 'required',
            'departement'    => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors());
        }
        // $module->description = $input['description'];
        $salle->update($input);

        return $this->sendResponse($salle, '  salle updated Successfully!');
    }

    public function destroy(Salle $salle)
    {
        $salle->delete();
        return $this->sendResponse($salle, 'salle deleted Successfully!');
    }
}
