<?php

namespace App\Http\Controllers\Api\Etudiants;

use App\Http\Controllers\BaseController;
use App\Http\Resources\SeanceResource;
use App\Models\Classe;
use App\Models\Module;
use App\Models\Seance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmploiTempsController extends BaseController
{

    public function index()
    {
        $user = Auth::user();
        if ($user->permission == 0) {
            $classe = Classe::where('id', $user->class_id)->value('id');
            $module = Module::where('class_id', $classe)->value('id');
            $seance = Seance::where('module_id', $module)->get();
            return $this->sendResponse(SeanceResource::collection($seance), 'seance retrieved Successfully!');
        }
        // if ($user->permission == 1) {
        //     $module = Module::where('prof_id', $user->id)->value('id');
        //     $seance = Seance::where('module_id', $module)->get();
        //     return $this->sendResponse(SeanceResource::collection($seance), 'seance retrieved Successfully!');
        // }
    }
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [

            'jour' => 'required',
            'module_titre' => 'required',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
            'salle_id' => 'required',

        ]);
        $input['module_id'] = Module::where('titre', $input['module_titre'])->value('id');
        if ($validator->fails()) {
            return $this->sendError('Validate Error', $validator->errors());
        }
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
        $input = $request->all();
        $validator = Validator::make($input, [
            'jour' => 'required',
            'module_titre' => 'required',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
            'salle_id' => 'required',
        ]);
        $input['module_id'] = Module::where('module_titre', $input['module_titre'])->id;
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors());
        }
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
