<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    protected $table = 'actions';

    public function cafes()
    {
        return $this->belongsTo('App\Models\Seance', 'seance_id', 'id');
    }

    public function by()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function processedBy()
    {
        return $this->belongsTo('App\Models\User', 'processed_by', 'id');
    }
}
