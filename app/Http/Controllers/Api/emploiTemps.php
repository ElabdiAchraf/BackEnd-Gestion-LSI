<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Resources\SeanceResource;
use App\Models\Module;
use App\Models\Seance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmploiController extends BaseController
{

    public function index()
    {
        $user = Auth::user();
        $seance = Seance::all();
        return $this->sendResponse(SeanceResource::collection($seance), 'seance retrieved Successfully!');
    }
    public function store(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();
        $validator = Validator::make($input, [

            'jour' => 'required',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
            'salle_id' => 'required',

        ]);
        $input['module_id'] = Module::where('titre', $input['module_titre'])->value('id');
        if ($validator->fails()) {
            return $this->sendError('Validate Error', $validator->errors());
        }
        if ($user->permission < 2) {
            $input['reservation'] = true;
        } else  $input['reservation'] = false;
        //
        if (Seance::isTimeAvailable($input['jour'], $input['heure_debut'], $input['heure_fin'], $input['salle_id'], $input['module_id'],)) {
            $seance = Seance::create($input);
            return $this->sendResponse($seance, 'seance added Successfully!');
        }
        return $this->sendError('time err', $validator->errors());
    }


    public function show($id)
    {
        $seance = Seance::find($id);
        if (is_null($seance)) {
            return $this->sendError('seance not found!');
        }
        return $this->sendResponse($seance, 'seance retireved Successfully!');
    }

    public function update(Request $request, Seance $seance)
    {
        $user = Auth::user();
        $input = $request->all();
        $validator = Validator::make($input, [
            'jour' => 'required',

            'heure_debut' => 'required',
            'heure_fin' => 'required',
            'salle_id' => 'required',
        ]);
        $input['module_id'] = Module::where('module_titre', $input['module_titre'])->id;
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors());
        }
        if ($user->permission < 2) {
            $input['reservation'] = true;
        } else  $input['reservation'] = false;
        if (Seance::isTimeAvailableUp($input['jour'], $input['heure_debut'], $input['heure_fin'], $input['salle_id'], $input['module_id'], $seance)) {
            $seance->update($input);
            return $this->sendResponse($seance, '  seance updated Successfully!');
        }
        return $this->sendError('time err', $validator->errors());
    }

    public function destroy(Seance $seance)
    {
        $seance->delete();
        return $this->sendResponse($seance, 'seance deleted Successfully!');
    }
}
