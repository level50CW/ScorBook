<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lineup extends Model
{
    protected $table = 'lineup';
    protected $primaryKey = 'idlineup';

    public $timestamps = false;

    public function team()
    {
        return $this->belongsTo('App\Models\Team','Teams_idteam');
    }

    public function game()
    {
        return $this->belongsTo('App\Models\Game','Games_idgame');
    }

    public function batters()
    {
        return $this->hasMany('App\Models\Batter','Lineup_idlineup');
    }

    public static function hasDH($batters)
    {
        $dict = array_flip(Batter::$defensePositions);
        return $batters->where('DefensePosition',$dict['DH'].'')->count() > 0;
    }

    public static function takeHitters($batters, $hasDH)
    {
        if ($hasDH){
            return $batters->filter(function($item){
                $defensePositions = array_flip(Batter::$defensePositions);
                return $item->DefensePosition != $defensePositions['P'].'';
            });
        }

        return $batters;
    }

    public static function takeFielders($batters, $hasDH)
    {
        if ($hasDH){
            return $batters->filter(function($item){
                $defensePositions = array_flip(Batter::$defensePositions);
                return $item->DefensePosition != $defensePositions['DH'].'';
            });
        }

        return $batters;
    }

    public static function takePitcher($batters)
    {
        $defensePositions = array_flip(Batter::$defensePositions);
        return $batters->where('DefensePosition', $defensePositions['P'].'')->first();
    }
}
