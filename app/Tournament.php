<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $fillable = [
        'name', 'description', 'game_id', 'start_date', 'end_date', 'places', 'cashprize', 'status', 'image',
    ];
    
    public function teams()
    {
        return $this->belongsToMany('App\Team')->withPivot('place');
    }

    public function game()
    {
        return $this->belongsTo('App\Game');
    }
}