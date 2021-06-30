<?php

namespace App\Http\Controllers\Api\Etudiants;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\ModuleResource;
use App\Http\Resources\NoteResource;
use App\Models\Module;
use App\Models\Classe;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;



class HomeController extends BaseController
{
    public function getModules()
    {
        $user = Auth::user();
        $class = Classe::where('id', $user->class_id)->value('id');
        $modules = Module::where('class_id', $class)->get();
        return $this->sendResponse(ModuleResource::collection($modules), 'data retrieved Successfully!');
    }
    public function getNotes()
    {
        $user = Auth::user();
        $notes = Note::where('etu_id', $user->id)->get();
        return $this->sendResponse(NoteResource::collection($notes), 'notes retrieved Successfully!');
    }
}
