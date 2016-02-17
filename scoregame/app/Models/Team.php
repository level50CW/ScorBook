<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{

    protected $primaryKey = 'idteam';
    public $timestamps = false;

    public $fillable = [
        'Name',
        'location',
        'Abv',
        'thumb',
        'logo',
    ];

    public function gamesAsVisitor()
    {
        return $this->hasMany('App\Models\Game', 'Teams_idteam_visiting');
    }

    public function gamesAsHome()
    {
        return $this->hasMany('App\Models\Game', 'Teams_idteam_home');
    }

    public function division()
    {
        return $this->belongsTo('App\Models\Division', 'Division_iddivision');
    }

    public function players()
    {
        return $this->hasMany('App\Models\Player', 'Teams_idteam');
    }

    public function lineups()
    {
        return $this->hasMany('App\Models\Lineup', 'Teams_idteam');
    }

    public function getPlayerNames()
    {
        $players = $this->players;
        return array_combine($players->pluck('idplayer')->toArray(), $players->map(function($pl){
            return $pl->getFullName();
        })->toArray());
    }

    public function getSimpleName()
    {
        return collect(mb_split(' ',$this->Name))->last();
    }
}
