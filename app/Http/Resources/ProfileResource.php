<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'nom'  => $this->nom,
            'prenom'  => $this->prenom,
            'date_naiss'  => $this->date_naiss,
            'sexe' => $this->sexe,
            'nom_pere' => $this->nom_pere,
            'phone'  => $this->phone,
            'pere_phone'  => $this->pere_phone,
            'adresse'  => $this->adresse,
        ];
    }
}
