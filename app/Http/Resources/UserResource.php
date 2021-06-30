<?php

namespace App\Http\Resources;

use App\Models\Classe;
use App\Models\Module;
use App\Models\Profile;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'Id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'permission'    => $this->permission,
            'class_id'      => $this->class_id,
            'classe'        => Classe::where('id', $this->class_id)->value('name'),
            'nom'           => Profile::where('user_id', $this->id)->value('nom'),
            'prenom'        => Profile::where('user_id', $this->id)->value('prenom')
        ];
    }
}
