<?php

namespace App\Http\Resources;

use App\Models\Classe;
use App\Models\Module;
use App\Models\Salle;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;


class SeanceResource extends JsonResource
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
            'id_seance'            => $this->id,
            'jour'            => $this->jour,
            'heure_debut'        => $this->heure_debut,
            'heure_fin'        => $this->heure_fin,
            'module'    => Module::where('id', $this->module_id)->value('titre'),
            'module_id'    => $this->module_id,
            'classe_id'    => Module::where('id', $this->module_id)->value('class_id'),
            'prof_id'    => Module::where('id', $this->module_id)->value('prof_id'),
            'professeur'    => User::where('id', Module::where('id', $this->module_id)->value('prof_id'))->value('name'),
            'classe'    => Classe::where('id', Module::where('id', $this->module_id)->value('class_id'))->value('name'),
            'salle_id'    => $this->salle_id,
            'Salle'    => Salle::where('id', $this->salle_id)->value('nom'),
            'description'    => $this->description,
            'num' => $this->num
        ];
    }
}
