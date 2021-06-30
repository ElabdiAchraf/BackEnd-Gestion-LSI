<?php

namespace App\Http\Resources;

use App\Models\Classe;
use App\Models\Module;
use App\Models\Profile;
use App\Models\User;

use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'ID_Note'            => $this->id,
            'note'               => $this->note,
            'module_id'          => $this->module_id,
            'module'          => Module::where('id', $this->module_id)->value('titre'),
            'name'               => User::where('id', $this->etu_id)->first()->name,
            'nom'               => Profile::where('id', $this->etu_id)->value('nom'),
            'prenom'               => Profile::where('id', $this->etu_id)->value('prenom'),
            'etu_id'              => $this->etu_id,
            'Description'          => $this->description,
        ];
    }
}
