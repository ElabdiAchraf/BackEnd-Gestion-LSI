<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PFE extends Model
{
    use HasFactory;
    protected $fillable = [
        'sujet',
        'description',
        'prof_id',
        'etu_id',
        'dateSout',
        'note'
    ];
    public function prof()
    {
        return   $this->hasMany(User::class, 'prof_id', 'id');
    }
    public function etu()
    {
        return   $this->hasMany(User::class, 'etu', 'id');
    }
}
