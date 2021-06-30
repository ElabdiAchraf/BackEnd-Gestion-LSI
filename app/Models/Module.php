<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'description',
        'niveau',
        'prof_id',
        'class_id',
    ];
    public function classe()
    {
        return $this->belongsTo(User::class, 'prof_id');
    }
    public function note()
    {
        return   $this->hasMany(Note::class, 'Module_id', 'id');
    }
}
