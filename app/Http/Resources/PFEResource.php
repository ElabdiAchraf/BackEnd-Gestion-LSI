<?php

namespace App\Http\Resources;

use App\Models\Classe;
use App\Models\Module;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class PFEResource extends JsonResource
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
            'Id_PFE'              => $this->id,
            'sujet'           => $this->sujet,
            'Date_soutenance' => $this->dateSout,
            'note'        => $this->note,
            'Etudiant'        => User::where('id', $this->etu_id)->value('name'),
            'Professeur'           => User::where('id', $this->prof_id)->value('name'),
            'Description'        => $this->description
        ];
    }
}
