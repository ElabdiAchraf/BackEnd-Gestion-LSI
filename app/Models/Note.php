<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = [
        'note',
        'description',
        'module_id',
        'etu_id'
    ];
    public function ClassUser()
    {
        return   $this->hasMany(User::class, 'class_id', 'id');
    }
    public function module()
    {
        return   $this->hasMany(Module::class, 'class_id', 'id');
    }
}
