<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'pseudo', 'avatar', 'description', 'birth_date', 'admin', 'visibility', 'password', 'secret_key'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function games()
    {
        return $this->belongsToMany('App\Game');
    }

    public function teams()
    {
        return $this->belongsToMany('App\Team');
    }

    public function tournaments()
    {
        return $this->belongsToMany('App\Tournament')->withPivot('place');
    }

    public function joinrequests()
    {
        return $this->hasMany('App\JoinRequest');
    }
    
    public function tournamentPlaces()
    {
        return $this->hasMany('App\TournamentPlaces');
    }
}
