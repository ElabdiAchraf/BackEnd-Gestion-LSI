<?php

namespace App\Http\Controllers\Api\Professeur;

use App\Http\Controllers\BaseController;
use App\Http\Resources\ModuleResource;
use App\Http\Resources\NoteResource;
use App\Http\Resources\SeanceResource;
use App\Http\Resources\UserResource;
use App\Models\Module;
use App\Models\Note;
use App\Models\Seance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NoteController extends BaseController
{

    public function Modules()
    {
        $user = Auth::user();
        $modules = Module::where('prof_id', $user->id)->get();
        return $this->sendResponse(ModuleResource::collection($modules), 'modules retrieved Successfully!');
    }
    public function classeET($id)
    {
        $user = Auth::user();
        if ($user->permission > 0) {
            $class_id = Module::where('id', $id)->value('class_id');
            $Etudiant = User::where('class_id', $class_id)->where('permission', 0)->get();
            return $this->sendResponse(UserResource::collection($Etudiant), 'Etudiants retrieved Successfully!');
        }
        return $this->sendError(' vous n avez le droit', ' vous n avez le droit');
    }
    public function notes($id)
    {
        $user = Auth::user();
        if ($user->permission > 0) {
            $notes = Note::where('module_id', $id)->get();
            return $this->sendResponse(NoteResource::collection($notes), 'notes retrieved Successfully!');
        }
        return $this->sendError(' vous n avez le droit', ' vous n avez le droit');
    }
    public function store(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'note' => 'required',
            'module_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validate Error', $validator->errors());
        }
        $input['etu_id'] = $id;
        $note = Note::where('module_id', $input['module_id'])->where('etu_id', $id)->get();
        if (count($note) < 1) {
            $note = Note::create($input);
            return $this->sendResponse($note, 'seance added Successfully!');
        } else {
            return $this->sendError('Validate Error', $validator->errors());
        }
    }


    public function show($id)
    {
        $seance = Seance::find($id);
        if (is_null($seance)) {
            return $this->sendError('seance not found!');
        }
        return $this->sendResponse($seance, 'seance retireved Successfully!');
    }

    public function update(Request $request,  $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'note' => 'required',
        ]);
        $note = Note::find($id);
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors());
        }
        $note->update($input);
        return $this->sendResponse($note, 'note updated Successfully!');
        // 'module_id' => 'required',
    }

    public function destroy($id)
    {
        $note = Note::find($id);
        $note->delete();
        return $this->sendResponse($note, 'note deleted Successfully!');
    }
}
