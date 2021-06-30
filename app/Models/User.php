<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'permission',
        'class_id',
        'pass_hashed'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * Send a password reset notification to the user.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $url = 'https://example.com/reset-password?token=' . $token;

        // $this->notify(new ResetPasswordNotification($url));
    }
    public function modele()
    {
        return $this->hasOne(Modele::class);
    }
    public function classe()
    {
        return $this->belongsTo(Classe::class, 'class_id');
    }
    public function actions()
    {
        return $this->hasMany('App\Models\Action', 'id', 'user_id');
    }

    public function actionsProcessed()
    {
        return $this->hasMany('App\Models\Action', 'id', 'processed_by');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    public function note()
    {
        return   $this->hasMany(Note::class, 'etu_id', 'id');
    }
}
