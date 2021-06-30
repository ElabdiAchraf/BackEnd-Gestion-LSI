<?php

namespace App\Http\Resources;

use App\Models\Classe;
use App\Models\User;

use Illuminate\Http\Resources\Json\JsonResource;

class ModuleResource extends JsonResource
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
            'ID_Module'            => $this->id,
            // 'Professeur'            => User::where('id', $this->prof_id)->first()->name,
            'Titre'                => $this->titre,
            'Classe'           => Classe::where('id', $this->class_id)->first()->name,
            'created_at'           => $this->created_at,
            'updated_at'           => $this->updated_at,
            'Description'          => $this->description,
            'Semestre'               => $this->niveau,
        ];
    }
}
