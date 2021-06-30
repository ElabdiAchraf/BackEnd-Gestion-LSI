<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Resources\SeanceResource;
use App\Models\Module;
use App\Models\Seance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SeanceController extends BaseController
{
    public function reservetion()
    {
        $seance = Seance::where('reservation', true)->get();
        return $this->sendResponse(SeanceResource::collection($seance), 'reservation retrieved Successfully!');
    }
    public function index()
    {
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
        $input['class_id'] = Module::where('titre', $input['module_titre'])->value('class_id');
        if ($validator->fails()) {
            return $this->sendError('Validate Error', $validator->errors());
        }
        if ($user->permission  == 1) {
            $input['reservation'] = 1;
        } else  $input['reservation'] = 0;
        switch ($input['heure_debut']) {
            case "08:30":
                $input['num'] = 1;
                break;
            case "10:30":
                $input['num'] = 2;
                break;
            case "14:30":
                $input['num'] = 3;
                break;
            case "16:30":
                $input['num'] = 4;
                break;
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
        if ($user->permission == 1) {
            $input['reservation'] = 1;
        } else  $input['reservation'] = 0;
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
