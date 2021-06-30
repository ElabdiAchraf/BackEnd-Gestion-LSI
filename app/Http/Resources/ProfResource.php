<?php

namespace App\Http\Resources;

use App\Models\Module;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfResource extends JsonResource
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
            'Module_Affecter'    => Module::where('prof_id', $this->id)->value('titre'),

        ];
    }
}
