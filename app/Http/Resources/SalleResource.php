<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;


class SalleResource extends JsonResource
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
            'id_salle'            => $this->id,
            'Nom'            => $this->nom,
            'Numero'        => $this->numero,
            'Departement'    => $this->departement,
            'Etage'    => $this->etage,
            'Description'    => $this->description,
        ];
    }
}
