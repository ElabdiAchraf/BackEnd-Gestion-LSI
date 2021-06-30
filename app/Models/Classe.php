<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'niveau'
    ];


    public function ClassUser()
    {
        return   $this->hasMany(User::class, 'class_id', 'id');
    }
    public function ClassCoure()
    {
        return   $this->hasMany(Cour::class, 'class_id', 'id');
    }
    public function module()
    {
        return   $this->hasMany(Module::class, 'class_id', 'id');
    }
}
