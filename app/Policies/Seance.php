<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    use HasFactory;
    protected $fillable = [
        'jour',
        'start_time',
        'end_time',
        'modul_id',
        'salle_id',
        'class_id'
    ];

    public function module()
    {
        return $this->belongsTo(Module::class, 'modul_id');
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'class_id');
    }
    public function salle()
    {
        return $this->belongsTo(Classe::class, 'salle_id');
    }
}
