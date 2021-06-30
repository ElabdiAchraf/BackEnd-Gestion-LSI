<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassResource extends JsonResource
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
            'id_class'            => $this->id,
            'Nom'                 => $this->name,
            'Niveau'              => $this->niveau,
            'created_at'          => $this->created_at,
            'updated_at'          => $this->updated_at,
            'Nombre_Etudiants'    => User::where('class_id', $this->id)->count(),
        ];
    }
}
