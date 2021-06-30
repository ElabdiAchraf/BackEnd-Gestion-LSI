<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;


    protected $fillable = [
        'nom',
        'prenom',
        'user_id',
        'date_naiss',
        'CNE',
        'sexe',
        'nom_pere',
        'phone',
        'pere_phone',
        'adresse',
        'role'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
